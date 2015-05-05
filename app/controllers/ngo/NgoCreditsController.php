<?php

class NgoCreditsController extends BaseController {


    private $_api_context;

    private $_ClientId='AQ10YGdwkquqM6DpBspIeagRqOOeGPh4Dz19832jqdbr55laVUJPxXu2BBH6M7Ay2zNbhS6L2m9GhFaj';
    private $_ClientSecret='EKwZnR0aoVXcgl4SkZgaDZeE2tctC6E0na4fEQmmcuFhyZi1l3kaS5NXQXc_IChCIePUVfgiRTPOdIgr';

    public function __construct()
    {

        // setup PayPal api context
        $this->_api_context = Paypalpayment::apiContext($this->_ClientId, $this->_ClientSecret);
        $this->_api_context->setConfig(array(
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = Lang::get('ngo/credits/table.title');

        // Grab all the blog posts


        // Show the page
        return View::make('site/ngo/credits', compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
    {
        $title = Lang::get('ngo/credits/table.title');
        // Declare the rules for the form validation
        $rules = array(
            'credits' => 'required|integer|min:0',
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes()) {
            // Create a new blog post
            $user = Auth::user();

            // ### Payer
            // A resource representing a Payer that funds a payment
            // Use the List of `FundingInstrument` and the Payment Method
            // as 'credit_card'
            $credits = Input::get("credits");
            $payer = Paypalpayment::payer();
            $payer->setPaymentMethod("paypal");

            $item1 = Paypalpayment::item();
            $item1->setName('Credits Piece by Peace')
                ->setDescription('Credits for campaigns')
                ->setCurrency('EUR')
                ->setQuantity($credits)
                ->setPrice(0.06);


            $itemList = Paypalpayment::itemList();
            $itemList->setItems(array($item1));


            $details = Paypalpayment::details();
            $details->setShipping("0")
                ->setTax(''.$credits * 0.06 * 0.21)
                //total of items prices
                ->setSubtotal(''.$credits * 0.06);

            //Payment Amount
            $amount = Paypalpayment::amount();
            $amount->setCurrency("EUR")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal(($credits * 0.06 * 0.21) + ($credits * 0.06))
                ->setDetails($details);

            // ### Transaction
            // A transaction defines the contract of a
            // payment - what is the payment for and who
            // is fulfilling it. Transaction is created with
            // a `Payee` and `Amount` types

            $transaction = Paypalpayment::transaction();
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("Payment description")
                ->setInvoiceNumber(uniqid());


            $redirectUrls = Paypalpayment::redirectUrls();
            $redirectUrls->setReturnUrl(URL::to('ngo/executePayment'))
                ->setCancelUrl(URL::to('ngo/executePayment'));

            // ### Payment
            // A Payment Resource; create one using
            // the above types and intent as 'sale'

            $payment = Paypalpayment::payment();

            $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions(array($transaction));

            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {
                    echo "Exception: " . $ex->getMessage() . PHP_EOL;
                    $err_data = json_decode($ex->getData(), true);
                    exit;
                } else {
                    die('Some error occur, sorry for inconvenient');
                }
            }

            foreach($payment->getLinks() as $link) {
                if($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }

            // add payment ID to session
            Session::put('paypal_payment_id', $payment->getId());
            Session::put('credits',$credits);
            if(isset($redirect_url)) {
                // redirect to paypal
                return Redirect::away($redirect_url);
            }

            return View::make('site/ngo/credits', compact('title'))->with('error', 'Unknown error occurred');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $post
     * @return Response
     */
	public function getExecutePayment()
	{

        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');

        // clear the session payment ID
        Session::forget('paypal_payment_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            return Redirect::action('BlogController@getIndex')
                ->with('error', 'Payment failed');
        }

        $payment = Paypalpayment::getById($payment_id, $this->_api_context);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = Paypalpayment::PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        //echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later

        if ($result->getState() == 'approved') { // payment made
            $ngo = Auth::user()->actor();
            $ngo->credits = $ngo->credits + Session::get('credits');
            $ngo->save();
            return Redirect::action('BlogController@getIndex')
                ->with('success', 'Payment success');
        }
        return Redirect::action('BlogController@getIndex')
            ->with('error', 'Payment failed');
	}



}