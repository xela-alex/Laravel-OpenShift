@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('project/list.titleVolunteer') }}} ::
    @parent
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{ Lang::get('project/list.titleVolunteer') }}}</h1>
    </div>

    @if(!isset($viewNgoMyProjects))
        <form method="GET" accept-charset="UTF-8" action="{{URL::to('projectsFilter')}}">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
            <!-- ./ csrf token -->
            <div class="row">
                <div class="span4">
                    <label for="categories">{{{ Lang::get('project/list.categories') }}}</label>
                    <select class="selectpicker" name="category">

                        @foreach ($categories as $category)
                            @if( Input::old('category')==$category->id)

                                <option selected="selected" value={{ $category->id }}>{{{ $category->name }}}</option>
                            @else
                                <option value={{ $category->id }}>{{{ $category->name }}}</option>

                            @endif
                        @endforeach
                    </select>

                    <label for="locations">{{{ Lang::get('project/list.locations') }}}</label>
                    <select class="selectpicker" name="city">
                        @foreach ($locations as $country =>$cities)
                            <optgroup label={{ $country }}>
                                @foreach ($cities as $city)
                                    @if( Input::old('city')==$city)
                                        <option selected="selected">{{ $city }}</option>
                                    @else
                                        <option>{{ $city }}</option>

                                    @endif
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>

                </div>
                <div class="span4">
                    <label for="startDate">{{{ Lang::get('project/list.dateFrom') }}}</label>
                    <input type="date" name="startDate" step="1" min="2014-01-01"
                           value="{{ Input::old('startDate',date("Y-m-d"))}}">

                    <label for="finishDate">{{{ Lang::get('project/list.dateTo') }}}</label>
                    <input type="date" name="finishDate" step="1" min="2014-01-01"
                           value="{{ Input::old('finishDate',date("Y-m-d"))}}">
                </div>
            </div>


            <LINK href="{{URL::to('template/bootstrap/css/listProject.css')}}" rel="stylesheet" type="text/css">

            <div class="pagination">
                <button type="submit"
                        class="btn btn-primary">{{{ Lang::get('project/list.search') }}}</button>

                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to('/') }}'"
                       value="{{ Lang::get('project/list.back') }}">
                <br>
                {{--comprobamos que exista la variable para los casos de iniciar el filtrado en los que aun no esta--}}
                @if(isset($projects))
                    {{ $projects->appends(array('category'=>Input::get('category'),
                 'city'=>Input::get('city'),'startDate'=>Input::get('startDate'),
                 'finishDate'=>Input::get('finishDate'),))->links()}}
                    {{--mostramos los links para paginar--}}
                @endif
            </div>
        </form>
    @else
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

    @endif
    {{--Comprobamos que existen proyectos y los muestra los proyectos--}}
    @if(isset($emptyProjects))

        @if($emptyProjects)
            @if(!isset($viewNgoMyProjects))
                <h3> {{{ Lang::get('project/list.notFound') }}}</h3>
            @elseif($viewNgoMyProjects)
                <h3> {{{ Lang::get('project/list.ngoEmptyProject') }}}</h3>
            @endif

        @elseif(isset($projects))
            <div class="listProject">
                @foreach ($projects as $project)
                    <div class="row">
                        <div class="span3">
                            <img src="{{ URL::to($project->image)}}" class="img-rounded"
                                 alt="{{Lang::get('project/list.notImage') }}"/>
                        </div>
                        <div class="span9">
                            <div class="caption">
                                {{--<a href="{{{ URL::to('campaign/details/'.$campaign->id) }}}"><p>{{$campaign->name }}</p></a>--}}

                                <h3> {{ HTML::link('/project/view/'.$project->id , $project->name) }}  </h3>

                                {{Session::put('backUrl', Request::url())}}

                                <p>{{ $project->description}}</p>

                                <p2> {{ $project->city}}, {{ $project->country}} </p2>
                            </div>
                        </div>
                    </div>
                    <br>
                    @if( isset($viewNgoMyProjects))
                        <input type="button" class="btn btn-primary"
                               onclick="window.location.href='{{ URL::to('ngo/message/sendMessage/'.$project->id) }}'"
                               value="{{ Lang::get('project/list.sendMessage') }}">

                    @elseif(isset($authNgoId))
                        @if($authNgoId!=null && $authNgoId==$project->ngo_id)
                            <input type="button" class="btn btn-primary"
                                   onclick="window.location.href='{{ URL::to('ngo/message/sendMessage/'.$project->id) }}'"
                                   value="{{ Lang::get('project/list.sendMessage') }}">
                        @endif
                    @elseif(isset($authVolunteerId)&&isset($projectsOfVolunteer))
                        @if($authVolunteerId!=null && $projectsOfVolunteer->contains($project->id))
                        <input type="button" class="btn btn-primary"
                               onclick="window.location.href='{{ URL::to('volunteer/message/sendMessage/'.$project->id) }}'"
                               value="{{ Lang::get('project/list.sendMessage') }}">
                        @endif
                    @endif
                    <hr/>
                @endforeach
            </div>
        @endif
    @endif
@stop
