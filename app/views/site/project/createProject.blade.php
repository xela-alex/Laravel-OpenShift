@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{$title}}}
    @parent
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{$title}}}</h1>
    </div>
    <form method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
        <!-- ./ csrf token -->
        <div class="row">
            <div class="span4">
                <div class="tab-content">
                    <div class="form-group{{{ $errors->has('name') ? 'error' : '' }}}">
                        <label for="name">{{{ Lang::get('project/create.name') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('project/create.name') }}}" type="text"
                               name="name" id="name"
                               value="{{{ Input::old('name', isset($project) ? $project->name : null) }}}">
                        {{ $errors->first('name', '<span class="help-block">:message</span>') }}
                    </div>


                    <div class="form-group  {{{ $errors->has('description') ? 'error' : '' }}}">
                        <label for="description">{{{ Lang::get('project/create.description')}}}</label>
                        <textarea class="form-control" placeholder="{{{ Lang::get('project/create.description') }}}"
                                  rows="6" name="description"
                                  id="description">{{{ Input::old('description', isset($project) ? $project->description : null) }}}</textarea>
                        {{ $errors->first('description', '<span class="help-block">:message</span>') }}
                        {{--los textearea no llevan campo value los datos old que queramos poner van dentro de la etiqueta directamente--}}
                    </div>

                    <div class="form-group  {{{ $errors->has('maxVolunteers') ? 'error' : '' }}}">
                        <label for="maxVolunteers">{{{ Lang::get('project/create.maxVolunteers') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('project/create.maxVolunteers') }}}"
                               type="text" name="maxVolunteers" id="maxVolunteers"
                               value="{{{ Input::old('maxVolunteers', isset($project) ? $project->maxVolunteers : null) }}}">
                        {{ $errors->first('maxVolunteers', '<span class="help-block">:message</span>') }}

                    </div>

                    <div class="form-group  {{{ $errors->has('startDate') ? 'error' : '' }}}">
                        <label for="startDate">{{{ Lang::get('project/create.startDate') }}}</label>
                        <input type="date" name="startDate" step="1" min="2014-01-01"
                               value="{{{ Input::old('startDate', isset($project) ? $project->startDate : date("Y-m-d")) }}}">
                        {{ $errors->first('startDate', '<span class="help-block">:message</span>') }}
                    </div>
                    <div class="form-group  {{{ $errors->has('finishDate') ? 'error' : '' }}}">
                        <label for="finishDate">{{{ Lang::get('project/create.finishDate') }}}</label>
                        <input type="date" name="finishDate" step="1" min="2014-01-01"
                               value="{{{ Input::old('finishDate', isset($project) ? $project->finishDate : date("Y-m-d")) }}}">
                        {{ $errors->first('finishDate', '<span class="help-block">:message</span>') }}
                    </div>

                </div>
            </div>


            <div class="span4">


                <div class="form-group">

                    <label for="address">{{{ Lang::get('project/create.address') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('project/create.address') }}}"
                           type="text"
                           name="address" id="address"
                           value="{{{ Input::old('address', isset($project) ? $project->address : null) }}}">
                </div>
                <div class="form-group  {{{ $errors->has('city') ? 'error' : '' }}}">
                    <label for="city">{{{ Lang::get('project/create.city') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('project/create.city') }}}" type="text"
                           name="city" id="city"
                           value="{{{ Input::old('city', isset($project) ? $project->city : null) }}}">
                    {{ $errors->first('city', '<span class="help-block">:message</span>') }}

                </div>
                <div class="form-group  {{{ $errors->has('zipCode') ? 'error' : '' }}}">
                    <label for="zipCode">{{{ Lang::get('project/create.zipCode') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('project/create.zipCode') }}}"
                           type="text"
                           name="zipCode" id="zipCode"
                           value="{{{ Input::old('zipCode', isset($project) ? $project->zipCode : null) }}}">
                    {{ $errors->first('zipCode', '<span class="help-block">:message</span>') }}

                </div>
                <div class="form-group  {{{ $errors->has('country') ? 'error' : '' }}}">
                    <label for="country">{{{ Lang::get('project/create.country') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('project/create.country') }}}"
                           type="text"
                           name="country" id="country"
                           value="{{{ Input::old('country', isset($project) ? $project->country : null) }}}">
                    {{ $errors->first('country', '<span class="help-block">:message</span>') }}

                </div>
                <div class="form-group  {{{ $errors->has('image') ? 'error' : '' }}}">
                    <label for="image">{{{ Lang::get('project/create.image') }}}</label>
                    <input class="form-control" type="file" name="image" id="image">
                    {{ $errors->first('image', '<span class="help-block">:message</span>') }}

                </div>
                <div class="dropup {{{ $errors->has('categories') ? 'error' : '' }}}">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-expanded="true">
                        {{{ Lang::get('project/create.selectCategories') }}}

                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">


                        @foreach( $categories as $category)

                            <li><label>
                                    {{--Si estamos editando es decir existe $project marcamos los checkbos ya seleccionados--}}
                                    @if(isset($project))
                                        {{--Son collection con un array dentro por eso tenemos que usar el metodo contains de collection--}}
                                        @if($project->categories->contains($category))
                                            <input type="checkbox" name="categories[]"
                                                   value="{{{ $category->id }}}" checked>
                                            <font color="white">{{{ $category->name }}}</font>

                                        @else
                                            <input type="checkbox" name="categories[]"
                                                   value="{{{ $category->id }}}"><font
                                                    color="white">{{{ $category->name }}}</font>
                                        @endif

                                    @else
                                        @if(Input::old('categories')!=null)
                                            @if(in_array($category->id,Input::old('categories')))

                                                <input type="checkbox" name="categories[]"
                                                       value="{{{ $category->id }}}" checked>
                                                <font color="white">{{{ $category->name }}}</font>
                                            @else
                                                <input type="checkbox" name="categories[]"
                                                       value="{{{ $category->id }}}"><font
                                                        color="white">{{{ $category->name }}}</font>
                                            @endif

                                        @else
                                            <input type="checkbox" name="categories[]"
                                                   value="{{{ $category->id }}}"><font
                                                    color="white">{{{ $category->name }}}</font>
                                        @endif

                                    @endif
                                </label>
                            </li>
                        @endforeach
                    </ul>
                    {{ $errors->first('categories', '<span class="help-block">:message</span>') }}

                </div>
            </div>

            @if ( Session::get('error') )
                <div class="alert alert-error alert-danger">
                    @if ( is_array(Session::get('error')) )
                        {{ head(Session::get('error')) }}
                    @endif
                </div>
            @endif
        </div>

        <div class="form-actions form-group">

            @if(isset($project))
                <button type="submit"
                        class="btn btn-primary">{{{ Lang::get('project/create.saveEdit') }}}</button>

                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to('project/view/'.$project->id) }}'"

                       value="{{ Lang::get('project/create.back') }}">
            @else
                <button type="submit"
                        class="btn btn-primary">{{{ Lang::get('project/create.saveCreate') }}}</button>
                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to('/') }}'"

                       value="{{ Lang::get('project/create.back') }}">
            @endif

        </div>
    </form>
@stop
