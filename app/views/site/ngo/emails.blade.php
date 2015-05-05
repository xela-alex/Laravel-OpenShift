@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('ngo/ngo.sendEmail') }}} ::
    @parent
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{ Lang::get('site.ngo') }}}</h1>
    </div>
    <form method="POST" action="{{{URL::to('ngo/sendEmails')  }}}"
          enctype="multipart/form-data" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
        <input type="hidden" name="idCampaing" value="{{{ $campaignId }}}">

        <div class="tab-content">
            <div class="row">
                <div class="span3">

                    <div class="form-group">
                        <label for="Campaing">{{{ Lang::get('ngo/ngo.campaing') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.campaign') }}}" type="text"
                               name="campaing" id="campaing" value="{{{  $campaignName}}}">

                    </div>
                    <div class="form-group">
                        <label for="numberEmails">{{{ Lang::get('ngo/ngo.numberEmails') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.numberEmails') }}}" type="text"
                               name="numberEmails" id="numberEmails" value="0">

                    </div>
                </div>
            </div>

            @if ( Session::get('error') )
                <div class="alert alert-error alert-danger">
                    @if ( is_array(Session::get('error')) )
                        {{ head(Session::get('error')) }}
                    @endif
                </div>
            @endif

            @if ( Session::get('notice') )
                <div class="alert">{{ Session::get('notice') }}</div>
            @endif

            <div class="form-actions form-group">
                <button type="submit"
                        class="btn btn-primary">{{{ Lang::get('ngo/ngo.send') }}}</button>
                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to('/') }}'"

                       value="{{ Lang::get('ngo/ngo.back') }}">
            </div>

        </div>
    </form>
@stop
