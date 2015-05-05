@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('project/view.title') }}} ::
    @parent
@stop
<LINK href="{{URL::to('template/bootstrap/css/viewProject.css')}}" rel="stylesheet" type="text/css">


@section('content')

    <div class="page-header">
        <h1>{{{ Lang::get('project/view.title') }}}</h1>
    </div>
    <div class="viewProject">
        <div class="row">
            <div class="span6">
                <h7>  {{{ Lang::get('project/view.name') }}} </h7>
                <p>{{$project->name }}</p>
                <br>
                <br>
                @if($project->ngo!=null)
                    <h7>  {{{ Lang::get('project/view.ngo') }}} </h7>
                    <p>{{$project->ngo->name }}</p>
                @elseif($project->company!=null)
                    <h7>  {{{ Lang::get('project/view.company') }}} </h7>
                    <p>{{$project->company->name }}</p>
                @endif
            </div>

            <div class="span3">
                <img src="{{ URL::to($project->image)}}" class="img-rounded"
                     alt="{{{ Lang::get('project/view.notImage') }}}"/>
            </div>
        </div>
        <br>

        <h7>  {{{ Lang::get('project/view.description') }}} </h7>
        <p>{{$project->description }}</p>
        <br> <br>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{{{ Lang::get('project/view.location') }}}</th>
                    <th>{{{ Lang::get('project/view.startDate') }}}</th>
                    <th>{{{ Lang::get('project/view.finishDate') }}}</th>
                    <th>{{{ Lang::get('project/view.maxVolunteers') }}}</th>
                    <th>{{{ Lang::get('project/view.availableVolunteers') }}}</th>
                    <th>{{{ Lang::get('project/view.categories') }}}</th>
                </tr>
                </thead>
                <tr>
                    <td>{{{$project->addres }}} {{{$project->city }}}, {{{$project->country }}}
                        . {{{$project->zipCode }}}</td>
                    <td>{{{$project->startDate }}}</td>
                    <td>{{{$project->finishDate }}}</td>
                    <td>{{{$project->maxVolunteers }}}</td>
                    <td>{{{$availableVolunteers}}}</td>
                    <td>{{{$categories}}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="form-actions form-group">
        @if(isset($editable))
            @if($editable)
                @if($isCsrProject)
                    <input type="button" class="btn btn-primary"
                           onclick="window.location.href='{{ URL::to('company/project/editCsrProject/'.$project->id) }}'"
                           value="{{ Lang::get('project/view.edit') }}">
                @else
                    <input type="button" class="btn btn-primary"
                           onclick="window.location.href='{{ URL::to('project/editVolunteerProject/'.$project->id) }}'"
                           value="{{ Lang::get('project/view.edit') }}">
                @endif

                <input type="button" class="btn btn-primary"
                       onclick="ConfirmDelete();"
                       value="{{ Lang::get('project/view.delete') }}">
            @endif
        @endif
        @if($canApply)
            <input type="button" class="btn btn-primary"
                   onclick="window.location.href='{{ URL::to('volunteer/apply/project/'.$project->id) }}'"
                   value="{{ Lang::get('project/view.apply') }}">
        @endif
        <input type="button" class="btn btn-primary"

               onclick="window.location.href='{{ URL::to($backUrl) }}'"

               value="{{ Lang::get('project/view.back') }}">
    </div>

@stop
@section('js')

    <script type="text/javascript">
        function ConfirmDelete() {
            var mensaje = confirm('{{ Lang::get('project/view.confirmDelete') }}');
            if (mensaje) {
                @if($isCsrProject)
                window.location.href = '{{ URL::to('company/project/deleteCsrProject/'.$project->id) }}'
                @else
                    window.location.href = '{{ URL::to('project/deleteVolunteerProject/'.$project->id) }}'
                @endif
            }
        }
    </script>
@stop



