@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('user/user.register') }}} ::
    @parent
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{ Lang::get('site.ngo') }}}</h1>
    </div>
    <form method="POST" action="{{{ (Confide::checkAction('NgoController@store')) ?: URL::to('userNgo')  }}}"
          enctype="multipart/form-data" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">


        <div class="tab-content">
            <div class="row">
                <div class="span3">
                    <div class="form-group">
                        <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}"
                               type="text"
                               name="username" id="username" value="{{{ Input::old('username') }}}">

                    </div>
                    <div class="form-group ">
                        <label for="email">{{{ Lang::get('confide::confide.e_mail') }}}
                            <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small>
                        </label>
                        <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}"
                               type="text"
                               name="email" id="email" value="{{{ Input::old('email') }}}">

                    </div>
                    <div class="form-group">
                        <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}"
                               type="password"
                               name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
                        <input class="form-control"
                               placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}"
                               type="password" name="password_confirmation" id="password_confirmation">
                    </div>
                    <div class="form-group  {{{ $errors->has('name') ? 'error' : '' }}}">
                        <label for="name">{{{ Lang::get('ngo/ngo.name') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.name') }}}" type="text"
                               name="name"
                               id="name" value="{{{ Input::old('name') }}}">
                        {{ $errors->first('name', '<span class="help-block">:message</span>') }}
                    </div>
                    <div class="form-group  {{{ $errors->has('description') ? 'error' : '' }}}">
                        <label for="description">{{{ Lang::get('ngo/ngo.description') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.description') }}}" type="text"
                               name="description" id="description" value="{{{ Input::old('description') }}}">
                        {{ $errors->first('description', '<span class="help-block">:message</span>') }}
                    </div>
                    <div class="form-group  {{{ $errors->has('phone') ? 'error' : '' }}}">
                        <label for="phone">{{{ Lang::get('ngo/ngo.phone') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.phone') }}}" type="text"
                               name="phone" id="phone" value="{{{ Input::old('phone') }}}">
                        {{ $errors->first('phone', '<span class="help-block">:message</span>') }}
                    </div>

                </div>
                <div class="span3">
                    <div class="form-group  {{{ $errors->has('holderName') ? 'error' : '' }}}">
                        <label for="holderName">{{{ Lang::get('ngo/ngo.holderName') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.holderName') }}}" type="text"
                               name="holderName" id="holderName" value="{{{ Input::old('holderName') }}}">
                        {{ $errors->first('holderName', '<span class="help-block">:message</span>') }}
                    </div>
                    <div class="form-group  {{{ $errors->has('brandName') ? 'error' : '' }}}">
                        <label for="brandName">{{{ Lang::get('ngo/ngo.brandName') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.brandName') }}}" type="text"
                               name="brandName" id="brandName" value="{{{ Input::old('brandName') }}}">
                        {{ $errors->first('brandName', '<span class="help-block">:message</span>') }}
                    </div>
                    <div class="form-group  {{{ $errors->has('number') ? 'error' : '' }}}">
                        <label for="number">{{{ Lang::get('ngo/ngo.number') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.number') }}}" type="text"
                               name="number" id="number" value="{{{ Input::old('number') }}}">
                        {{ $errors->first('number', '<span class="help-block">:message</span>') }}
                    </div>
                    <div class="form-group  {{{ $errors->has('expirationMonth') ? 'error' : '' }}}">
                        <label for="expirationMonth">{{{ Lang::get('ngo/ngo.expirationMonth') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.expirationMonth') }}}"
                               type="text"
                               name="expirationMonth" id="expirationMonth"
                               value="{{{ Input::old('expirationMonth') }}}">
                        {{ $errors->first('expirationMonth', '<span class="help-block">:message</span>') }}
                    </div>
                    <div class="form-group  {{{ $errors->has('expirationYear') ? 'error' : '' }}}">
                        <label for="expirationYear">{{{ Lang::get('ngo/ngo.expirationYear') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.expirationYear') }}}"
                               type="text"
                               name="expirationYear" id="expirationYear" value="{{{ Input::old('expirationYear') }}}">
                        {{ $errors->first('expirationYear', '<span class="help-block">:message</span>') }}
                    </div>
                    <div class="form-group  {{{ $errors->has('cvv') ? 'error' : '' }}}">
                        <label for="cvv">{{{ Lang::get('ngo/ngo.cvv') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('ngo/ngo.cvv') }}}" type="text"
                               name="cvv" id="cvv" value="{{{ Input::old('cvv') }}}">
                        {{ $errors->first('cvv', '<span class="help-block">:message</span>') }}
                    </div>
                    <div class="form-group  {{{ $errors->has('logo') ? 'error' : '' }}}">
                        <label for="logo">{{{ Lang::get('ngo/ngo.logo') }}}</label>
                        <input class="form-control" type="file" name="logo" id="logo">
                        {{ $errors->first('logo', '<span class="help-block">:message</span>') }}
                    </div>
                </div>
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
                <button type="submit"
                        class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
                <input type="button" class="btn btn-primary"
                       onclick="window.location.href='{{ URL::to('/') }}'"

                       value="{{ Lang::get('ngo/ngo.back') }}">
            </div>

        </div>
    </form>
@stop
