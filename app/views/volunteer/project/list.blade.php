@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    @if(isset($isCsr))
        {{{ Lang::get('project/list.titleCsr') }}} ::
    @else
        {{{ Lang::get('project/list.titleVolunteer') }}} ::

    @endif
    @parent
@stop
<LINK href="{{URL::to('template/bootstrap/css/listProject.css')}}" rel="stylesheet" type="text/css">

{{-- Content --}}
@section('content')
    <div class="page-header">
        @if(isset($isCsr))

            <h1>{{{ Lang::get('project/list.titleCsr') }}}</h1>
        @else
            <h1>{{{ Lang::get('project/list.titleVolunteer') }}}</h1>

        @endif
    </div>


    <div class="pagination">

        <input type="button" class="btn btn-primary"
               onclick="window.location.href='{{ URL::to('/') }}'"
               value="{{ Lang::get('project/list.back') }}">
        <br>
        @if(isset($projects))
            {{ $projects->links()}}
            {{--mostramos los links para paginar--}}
        @endif
    </div>

    {{--Comprobamos que existen proyectos y los muestra los proyectos--}}
    @if($emptyProjects  )
            <h3> {{{ Lang::get('project/list.volunteerEmptyProject') }}}</h3>
    @else
        <div class="listProject">
            @foreach ($projects as $project)
                <div class="row">
                    <div class="span3">
                        <img src="{{ URL::to($project->image)}}" class="img-rounded"
                             alt="{{Lang::get('project/list.notImage') }}"/>
                    </div>
                    <div class="span9">
                        <div class="caption">

                            <h3> {{ HTML::link('/project/view/'.$project->id , $project->name) }}  </h3>

                            {{Session::put('backUrl', Request::url())}}

                            <p>{{ $project->description}}</p>

                            <p2> {{ $project->city}}, {{ $project->country}} </p2>
                        </div>
                    </div>
                </div>
                <br>
                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to('volunteer/message/sendMessage/'.$project->id) }}'"
                       value="{{ Lang::get('project/list.sendMessage') }}">
                <hr/>
            @endforeach
        </div>
    @endif
@stop
