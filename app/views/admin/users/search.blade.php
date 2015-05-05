@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('admin/search.searchTitleMessage') }}} ::
    @parent
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{ Lang::get('admin/search.searchTitleMessage') }}}</h1>
    </div>

    <form method="GET" accept-charset="UTF-8" action="{{URL::to($searchAction)}}">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>

        <div class="row">
            <div class="span4">
                <div class="tab-content">
                    <div class="form-group">
                        <label class="control-label" for="username">{{{ Lang::get('admin/search.username') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('admin/search.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="pagination">
            <button type="submit" class="btn btn-primary">{{{ Lang::get('admin/search.search') }}}</button>

            <input type="button" class="btn btn-primary" onclick="window.location.href='{{ URL::to('/') }}'" value="{{ Lang::get('admin/search.back') }}">
        </div>
    </form>

    @if(isset($users))
        @if(count($users))
            <hr>
            @foreach ($users as $user)
                @if($searchType == 'volunteers')
                    <div class="row">
                        <div class="clearfix control-group span6">
                            <div class="caption">

                                <h3> {{{ Lang::get('admin/search.username') }}} </h3>

                                <p>{{$user->userAccount->username }}</p>

                                <h3> {{{ Lang::get('admin/search.fullName') }}} </h3>

                                <p>{{$user->name }} {{$user->surname }}</p>

                                <h3> {{{ Lang::get('admin/search.fullAddress') }}} </h3>

                                <p>{{$user->address }}{{{', '}}} {{$user->zipCode }} {{{ '(' }}}{{$user->city }} {{{ ', ' }}} {{$user->country }}{{{ ')' }}}</p>

                            </div>
                        </div>
                    </div>

            @elseif($searchType == 'companies' || $searchType == 'NGOs')
                    <div class="row">
                        <div class="span4">
                            <img src="{{ URL::to($user->logo)}}" class="img-rounded"/>
                        </div>

                        <div class="clearfix control-group span6">
                            <div class="caption">

                                <h3> {{{ Lang::get('admin/search.username') }}} </h3>

                                <p>{{$user->userAccount->username }}</p>

                                <h3> {{{ Lang::get('admin/search.fullName') }}} </h3>

                                <p>{{$user->name }}</p>

                                <h3> {{{ Lang::get('admin/search.contactPhone') }}} </h3>

                                <p><b>{{$user->phone }}</b></p>

                            </div>
                        </div>

                    </div>

            @endif

            <div class="pagination">
                <input type="button" class="btn btn-info" onclick="window.location.href='{{{ URL::to('admin/message/sendMessage/'.$user->id) }}}'" value="{{{ Lang::get('admin/search.sendMessage') }}}">

                @if(!$user->active && ($searchType == 'companies' || $searchType == 'NGOs'))
                    <input type="button" class="btn btn-primary" onclick="window.location.href='{{{ URL::to('admin/user/activateAccount/'.$user->id) }}}'" value="{{{ Lang::get('admin/accountActivation.activate') }}}">
                @endif

                @if(!$user->banned)
                    <input type="button" class="btn btn-danger" onclick="window.location.href='{{{ URL::to('admin/user/ban/'.$user->id) }}}'" value="{{{ Lang::get('admin/ban.banUser') }}}">
                @else
                    <input type="button" class="btn btn-primary" onclick="window.location.href='{{{ URL::to('admin/user/unban/'.$user->id) }}}'" value="{{{ Lang::get('admin/ban.unbanUser') }}}">
                @endif

            </div>

            <hr>

            @endforeach

        @else
            <div class="row">
                <div class="span3">
                    <h3> {{{ Lang::get('admin/search.notFound') }}}</h3>
                </div>
            </div>
        @endif

        {{ Session::put('type', $searchType) }}
    @endif

    {{ Session::put('backUrl', Request::url()) }}

@stop
