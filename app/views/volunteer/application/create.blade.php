@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('application/create.title') }}} ::
    @parent
@stop
<LINK href="{{URL::to('template/bootstrap/css/createApplication.css')}}" rel="stylesheet" type="text/css">

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{ Lang::get('application/create.title') }}}</h1>
    </div>
    <form method="POST" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="createApplication">
            <div class="row ">
                <div class="span6">

                    <br>
                    <h7>  {{{ Lang::get('application/create.nameProject') }}} </h7>
                    <p>{{$project->name }}</p>

                </div>

                <div class="span6">
                    <div id="tamanyoMaxImagen">
                        <img src="{{ URL::to($project->image)}}" class="img-rounded"
                             alt="{{Lang::get('application/create.notImage') }}"/>
                    </div>
                </div>
            </div>

            <h7>  {{{ Lang::get('project/view.description') }}} </h7>
            <p>{{$project->description }}</p>
            <br> <br>


            <div class="form-group  {{{ $errors->has('comments') ? 'error' : '' }}}">
                <h7> {{{ Lang::get('application/create.comments') }}}</h7>
                        <textarea class="field span12" placeholder="{{{ Lang::get('application/create.comments') }}}"
                                  rows="7" name="comments"
                                  id="comments">{{{ Input::old('comments') }}}</textarea>
                {{ $errors->first('comments', '<span class="help-block">:message</span>') }}
            </div>


            <div class="form-actions form-group">
                <button type="submit" class="btn btn-primary">{{{ Lang::get('application/create.submit') }}}</button>

                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to($backUrl) }}'"

                       value="{{ Lang::get('application/create.back') }}">
            </div>
        </div>

    </form>
    @if ( Session::get('error') )
        <div class="alert alert-error alert-danger">
            @if ( is_array(Session::get('error')) )
                {{ head(Session::get('error')) }}
            @endif
        </div>
    @endif
@stop

