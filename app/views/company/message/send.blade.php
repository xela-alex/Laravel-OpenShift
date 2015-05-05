@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('company/message.sendMessage') }}} ::
    @parent
@stop
<LINK href="{{URL::to('template/bootstrap/css/createMessage.css')}}" rel="stylesheet" type="text/css">

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{ Lang::get('company/message.sendMessage') }}}</h1>
    </div>
    <form method="POST" accept-charset="UTF-8" action="{{URL::to($action)}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="projectId" value="{{{ $project->id }}}">


        <div class="createMessage">

            <div class="row ">
                <div class="span6">

                    <br>
                    <h7>  {{{ Lang::get('company/message.nameProject') }}} </h7>
                    <p>{{$project->name }}</p>

                </div>

                <div class="span6">
                    <div id="tamanyoMaxImagen">
                        <img src="{{ URL::to($project->image)}}" class="img-rounded"
                             alt="{{Lang::get('company/list.notImage') }}"/>
                    </div>
                </div>
            </div>

            <h7>  {{{ Lang::get('project/view.description') }}} </h7>
            <p>{{$project->description }}</p>
            <br> <br>

            <div class="radio">
                <label>
                    <input type="radio" name="type" id="radioBroadcast" value="broadcast" checked>
                    {{{ Lang::get('company/message.broadcast') }}}
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="type" id="radioVoluntter" value="volunteer">
                    {{{ Lang::get('company/message.volunteer') }}}
                </label>
            </div>
            {{--por defecto lo dejamos oculto--}}
            <div id="seleccion" style="display:none;">
                <h7>  {{{ Lang::get('company/message.selectVolunteer') }}} </h7>
                <select class="selectpicker" name="volunteerId">

                    @foreach ($volunteers as $volunteer)

                        <option selected="selected"
                                value={{ $volunteer->id }}>{{{ $volunteer->name.' '.$volunteer->surname }}}</option>

                    @endforeach
                </select>
            </div>
            <div class="form-group  {{{ $errors->has('subject') ? 'error' : '' }}}">

                <h7>{{{ Lang::get('company/message.subject') }}}</h7>

                <input class="field span12" placeholder="{{{ Lang::get('company/message.subject') }}}"
                       type="text"
                       name="subject" id="subject" value="{{{ Input::old('subject') }}}">
                {{ $errors->first('subject', '<span class="help-block">:message</span>') }}
            </div>
            <div class="form-group  {{{ $errors->has('textBox') ? 'error' : '' }}}">
                <h7> {{{ Lang::get('company/message.textBox') }}}</h7>
                        <textarea class="field span12" placeholder="{{{ Lang::get('company/message.textBox') }}}"
                                  rows="11" name="textBox"
                                  id="textBox">{{{ Input::old('textBox') }}}</textarea>
                {{ $errors->first('textBox', '<span class="help-block">:message</span>') }}
            </div>


            <div class="form-actions form-group">
                <button type="submit" class="btn btn-primary">{{{ Lang::get('company/message.send') }}}</button>

                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to($backUrl) }}'"

                       value="{{ Lang::get('company/message.back') }}">
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
@section('js')

    <script type="text/javascript">
        $(document).ready(function () {

            $("input[id=radioVoluntter]").click(function () {

                $("#seleccion").show();
            });
            $("input[id=radioBroadcast]").click(function () {

                $("#seleccion").hide();
            });
        });
    </script>
@stop

