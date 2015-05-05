@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('application/view.title') }}} ::
    @parent
@stop
<LINK href="{{URL::to('template/bootstrap/css/createApplication.css')}}" rel="stylesheet" type="text/css">

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{ Lang::get('application/view.title') }}}</h1>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="createApplication">
        <div class="row ">
            <div class="span6">

                <br>
                <h7>  {{{ Lang::get('application/view.nameProject') }}} </h7>
                <p>{{$application->project->name }}</p>
                <br>
                <h7>  {{{ Lang::get('application/view.result') }}} </h7>
                @if($application->result==0)
                    <p> {{{ Lang::get('application/view.pending') }}}</p>

                @elseif($application->result==1)
                    <p>{{{ Lang::get('application/view.denied') }}}</p>

                @else
                    <p>{{{ Lang::get('application/view.accepted') }}}</p>
                @endif

            </div>

            <div class="span6">
                <div id="tamanyoMaxImagen">
                    <img src="{{ URL::to($application->project->image)}}" class="img-rounded"
                         alt="{{Lang::get('application/view.notImage') }}"/>
                </div>
            </div>
        </div>

        <h7>  {{{ Lang::get('project/view.description') }}} </h7>
        <p>{{$application->project->description }}</p>
        <br> <br>

        @if(!is_null($application->comments) && $application->comments!="")
            <h7>  {{{ Lang::get('application/view.comments') }}} </h7>
            <p>{{$application->comments }}</p>
            <br> <br>
        @endif

        @if( $application->result==0)
            <input type="button" class="btn btn-primary"
                   onclick="ConfirmDelete();"
                   value="{{ Lang::get('application/view.cancelApplication') }}">
        @endif

        <input type="button" class="btn btn-primary"
               onclick="window.location.href='{{ URL::to($backUrl) }}'"

               value="{{ Lang::get('application/view.back') }}">

    </div>
    </div>

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
        function ConfirmDelete() {
            var mensaje = confirm('{{ Lang::get('application/view.confirmDelete') }}');
            if (mensaje) {
                window.location.href = '{{ URL::to('volunteer/application/cancel/'.$application->id)  }}'
            }
        }
    </script>
@stop
