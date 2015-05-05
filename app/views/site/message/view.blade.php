@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('message/view.title') }}} ::
    @parent
@stop
<LINK href="{{URL::to('template/bootstrap/css/viewMessage.css')}}" rel="stylesheet" type="text/css">


@section('content')

    <div class="page-header">
        <h1>{{{ Lang::get('message/view.title') }}}</h1>
    </div>
    <div class="viewMessage">
        <div class="row">
            <div class="span4">
                <h7>  {{{ Lang::get('message/view.from') }}} </h7>
                <p>{{$message->from }}</p>

                <h7>  {{{ Lang::get('message/view.subject') }}} </h7>
                <p>{{$message->subject }}</p>
            </div>

            <div class="span4">
                <h7>  {{{ Lang::get('message/view.to') }}} </h7>

                @if(substr($message->to, 0,1)=='(' && substr($message->to, -1)==')')
                    <p>{{{ Lang::get('message/list.BroadcastAllVolunteers').' '.$message->to }}}</p>
                @else
                    <p>{{$message->to }}</p>
                @endif

                <h7>  {{{ Lang::get('message/view.date') }}} </h7>
                <p>{{$message->date }}</p>
            </div>
        </div>
        <br>
        <br>

        <h7>  {{{ Lang::get('message/view.text') }}} </h7>
        <p1>{{$message->textBox }}</p1>
    </div>
    <br><br><br>
    <div class="form-actions form-group">

        <input type="button" class="btn btn-primary"
               onclick="window.location.href='{{ URL::to($backUrl) }}'"

               value="{{ Lang::get('message/view.back') }}">
    </div>
@stop



