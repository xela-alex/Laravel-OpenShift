@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{$title}}} ::
    @parent
@stop
<LINK href="{{URL::to('template/bootstrap/css/listProject.css')}}" rel="stylesheet" type="text/css">

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1> {{{$title}}}</h1>
    </div>


    <div class="pagination">

        <input type="button" class="btn btn-primary"
               onclick="window.location.href='{{ URL::to('/') }}'"
               value="{{ Lang::get('application/list.back') }}">
        <br>
        {{ $applications->links()}}
        {{--mostramos los links para paginar--}}
    </div>

    {{Session::put('backUrl', Request::url())}}


    @if($applications->getTotal() == 0)
        <h3> {{{ Lang::get('application/list.empty') }}}</h3>

    @else
        <div class="listProject">
            @foreach ($applications as $application)
                <div class="row">
                    <div class="span3">
                        <img src="{{ URL::to($application->project->image)}}" class="img-rounded"
                             alt="{{Lang::get('project/list.notImage') }}"/>
                    </div>
                    <div class="span9">
                        <div class="caption">

                            <h3> {{ HTML::link('/project/view/'.$application->project->id , $application->project->name) }}  </h3>

                            <p>{{ $application->project->description}}</p>

                            <p2> {{$application->project->city}}, {{$application->project->country}} </p2>
                        </div>
                    </div>
                </div>
                <br>
                @if( $application->result==0)
                    <input type="button" class="btn btn-primary"
                           onclick="ConfirmDelete();"
                           value="{{ Lang::get('application/list.cancelApplication') }}">
                @endif
                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to('volunteer/application/view/'.$application->id) }}'"
                       value="{{ Lang::get('application/list.view') }}">
                <hr/>
            @endforeach
        </div>
    @endif
@stop


@section('js')
    <script type="text/javascript">
        function ConfirmDelete() {
            @if(isset($application))
            var mensaje = confirm('{{ Lang::get('application/view.confirmDelete') }}');
            if (mensaje) {
                window.location.href = '{{ URL::to('volunteer/application/cancel/'.$application->id)  }}'
            }
            @endif

        }
    </script>
@stop
