@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('campaign/campaign.create') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>{{{ Lang::get('admin/message.sendMessage') }}}</h1>
</div>

<form method="POST" action="{{{ (Confide::checkAction('AdminMessageController@store')) ?: URL::to($sendMessageAction)  }}}" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

	@if(isset($user_id))
		<input type="hidden" name="user_id" value="{{{ $user_id }}}">
	@endif


	<div class="row">
		<div class="span12">
			<div class="tab-content">
				@if(isset($recipient))
					<label class="control-label" for="recipient">{{{ Lang::get('admin/message.recipient') }}}</label>
					<span class="uneditable-input">{{ $recipient }}</span>
				@endif

				@if(!isset($user_id))
					<div class="radio">
						<label class="control-label" for="type">
							<input type="radio" name="type" id="type" value="NGOs" checked="checked"> {{{ Lang::get('admin/message.broadcastMessageNGOs') }}}
						</label>
						<label class="control-label" for="type">
							<input type="radio" name="type" id="type" value="companies"> {{{ Lang::get('admin/message.broadcastMessageCompanies') }}}
						</label>
						<label class="control-label" for="type">
							<input type="radio" name="type" id="type" value="volunteers"> {{{ Lang::get('admin/message.broadcastMessageVolunteers') }}}
						</label>
					</div>
					<br>
				@endif

				<div class="form-group  {{{ $errors->has('subject') ? 'error' : '' }}}">
					<label class="control-label" for="subject">{{{ Lang::get('admin/message.subject') }}}</label>
					<input class="form-control" placeholder="{{{ Lang::get('admin/message.subject') }}}" type="text" name="subject" id="subject" value="{{{ Input::old('subject') }}}">
					{{ $errors->first('subject', '<span class="help-block">:message</span>') }}
				</div>
				<div class="form-group  {{{ $errors->has('textBox') ? 'error' : '' }}}">
					<label class="control-label" for="textBox">{{{ Lang::get('admin/message.textBox') }}}</label>
					<textarea class="form-control" placeholder="{{{ Lang::get('admin/message.textBox') }}}" rows="11" cols="6" name="textBox" id="textBox">{{{ Input::old('textBox') }}}</textarea>
					{{ $errors->first('textBox', '<span class="help-block">:message</span>') }}
				</div>
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
			<button type="submit" class="btn btn-primary">{{{ Lang::get('admin/message.send') }}}</button>

			<input type="button" class="btn btn-primary"
				   onclick="window.location.href='{{ URL::to($backUrl) }}'"

				   value="{{ Lang::get('admin/message.back') }}">
		</div>

</form>
@stop
