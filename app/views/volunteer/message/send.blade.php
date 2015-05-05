@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('volunteer/message.sendMessage') }}} ::
    @parent
@stop
<LINK href="{{URL::to('template/bootstrap/css/createMessage.css')}}" rel="stylesheet" type="text/css">

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{ Lang::get('volunteer/message.sendMessage') }}}</h1>
    </div>

    <form method="POST" accept-charset="UTF-8" action="{{URL::to($sendMessageAction)}}">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

        <div class="createMessage">

            <input type="hidden" name="userId" value="{{{ $userId }}}">
            <input type="hidden" name="projectId" value="{{{ $project->id }}}">


            <div class="row ">
                <div class="span6">

                    <br>
                    <h7>  {{{ Lang::get('project/view.name') }}} </h7>
                    <p>{{$project->name }}</p>

                </div>

                <div class="span6">
                    <div id="tamanyoMaxImagen">
                        <img src="{{ URL::to($project->image)}}" class="img-rounded"
                             alt="{{Lang::get('project/list.notImage') }}"/>
                    </div>
                </div>
            </div>

            <h7>  {{{ Lang::get('project/view.description') }}} </h7>
            <p>{{$project->description }}</p>
            <br> <br>


            <div class="form-group  {{{ $errors->has('subject') ? 'error' : '' }}}">

                <h7>{{{ Lang::get('volunteer/message.subject') }}}</h7>

                <input class="field span12" placeholder="{{{ Lang::get('volunteer/message.subject') }}}"
                       type="text"
                       name="subject" id="subject" value="{{{ Input::old('subject') }}}">
                {{ $errors->first('subject', '<span class="help-block">:message</span>') }}
            </div>
            <div class="form-group  {{{ $errors->has('textBox') ? 'error' : '' }}}">
                <h7> {{{ Lang::get('volunteer/message.textBox') }}}</h7>
                        <textarea class="field span12" placeholder="{{{ Lang::get('volunteer/message.textBox') }}}"
                                  rows="11" name="textBox"
                                  id="textBox">{{{ Input::old('textBox') }}}</textarea>
                {{ $errors->first('textBox', '<span class="help-block">:message</span>') }}
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
                <button type="submit" class="btn btn-primary">{{{ Lang::get('volunteer/message.send') }}}</button>

                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to($backUrl) }}'"

                       value="{{ Lang::get('volunteer/message.back') }}">
            </div>
        </div>
    </form>
@stop
