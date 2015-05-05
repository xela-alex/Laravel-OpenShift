@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.register') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>{{{ Lang::get('site.volunteer') }}}</h1>
</div>
<form method="POST" action="{{{ (Confide::checkAction('VolunteerController@store')) ?: URL::to('userVolunteer')  }}}" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
	<div class="tab-content">
		<div class="form-group">
			<label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
			<input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
		</div>
		<div class="form-group">
			<label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
			<input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
		</div>
		<div class="form-group">
			<label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
			<input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
		</div>
		<div class="form-group">
			<label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
			<input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
		</div>
		<div class="form-group  {{{ $errors->has('name') ? 'error' : '' }}}">
			<label for="name">{{{ Lang::get('volunteer/volunteer.name') }}}</label>
			<input class="form-control" placeholder="{{{ Lang::get('volunteer/volunteer.name') }}}" type="text" name="name" id="name" value="{{{ Input::old('name') }}}">
			{{ $errors->first('name', '<span class="help-block">:message</span>') }}
		</div>
		<div class="form-group  {{{ $errors->has('surname') ? 'error' : '' }}}">
			<label for="surname">{{{ Lang::get('volunteer/volunteer.surname') }}}</label>
			<input class="form-control" placeholder="{{{ Lang::get('volunteer/volunteer.surname') }}}" type="text" name="surname" id="surname" value="{{{ Input::old('surname') }}}">
			{{ $errors->first('surname', '<span class="help-block">:message</span>') }}
		</div>
		<div class="form-group">
			<label for="address">{{{ Lang::get('volunteer/volunteer.address') }}}</label>
			<input class="form-control" placeholder="{{{ Lang::get('volunteer/volunteer.address') }}}" type="text" name="address" id="address" value="{{{ Input::old('address') }}}">
		</div>
		<div class="form-group  {{{ $errors->has('city') ? 'error' : '' }}}">
			<label for="city">{{{ Lang::get('volunteer/volunteer.city') }}}</label>
			<input class="form-control" placeholder="{{{ Lang::get('volunteer/volunteer.city') }}}" type="text" name="city" id="city" value="{{{ Input::old('city') }}}">
			{{ $errors->first('city', '<span class="help-block">:message</span>') }}
		</div>
		<div class="form-group  {{{ $errors->has('zipCode') ? 'error' : '' }}}">
			<label for="zipCode">{{{ Lang::get('volunteer/volunteer.zipCode') }}}</label>
			<input class="form-control" placeholder="{{{ Lang::get('volunteer/volunteer.zipCode') }}}" type="text" name="zipCode" id="zipCode" value="{{{ Input::old('zipCode') }}}">
			{{ $errors->first('zipCode', '<span class="help-block">:message</span>') }}
		</div>
		<div class="form-group {{{ $errors->has('country') ? 'error' : '' }}}">
			<div class="col-md-12">
				<label for="country">{{{ Lang::get('volunteer/volunteer.country') }}}</label>
				<input class="form-control" placeholder="{{{ Lang::get('volunteer/volunteer.country') }}}" type="text" name="country" id="country" value="{{{ Input::old('country') }}}">
				{{ $errors->first('country', '<span class="help-block">:message</span>') }}
			</div>
		</div>
		<div class="form-group">
			<label for="biography">{{{ Lang::get('volunteer/volunteer.biography') }}}</label>
			<textarea class="form-control" placeholder="{{{ Lang::get('volunteer/volunteer.biography') }}}" rows="11" name="biography" id="biography">{{{ Input::old('biography') }}}</textarea>
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
			<button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
		</div>

	</div>
</form>
@stop
