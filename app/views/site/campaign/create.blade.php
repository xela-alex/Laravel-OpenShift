@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('campaign/campaign.create') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>{{{ Lang::get('campaign/campaign.create') }}}</h1>
</div>

<form method="POST" action="{{{ (Confide::checkAction('NgoCampaignController@store')) ?: URL::to('ngo/campaign/create')  }}}" enctype="multipart/form-data" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

	<div class="row">
		<div class="span4">
			<div class="tab-content">
				<div class="form-group  {{{ $errors->has('name') ? 'error' : '' }}}">
					<label class="control-label" for="name">{{{ Lang::get('campaign/campaign.name') }}}</label>
					<input class="form-control" placeholder="{{{ Lang::get('campaign/campaign.name') }}}" type="text" name="name" id="name" value="{{{ Input::old('name') }}}">
					{{ $errors->first('name', '<span class="help-block">:message</span>') }}
				</div>
				<div class="form-group  {{{ $errors->has('description') ? 'error' : '' }}}">
					<label class="control-label" for="description">{{{ Lang::get('campaign/campaign.description') }}}</label>
					<textarea class="form-control" placeholder="{{{ Lang::get('campaign/campaign.description') }}}" rows="11" name="description" id="description">{{{ Input::old('description') }}}</textarea>
					{{ $errors->first('description', '<span class="help-block">:message</span>') }}
				</div>
				<div class="form-group  {{{ $errors->has('image') ? 'error' : '' }}}">
					<label class="control-label" for="image">{{{ Lang::get('campaign/campaign.image') }}}</label>
					<input class="form-control" type="file" name="image" id="image">
					{{ $errors->first('image', '<span class="help-block">:message</span>') }}
				</div>
			</div>
		</div>

		<div class="span4">
			<div class="tab-content">
				<div class="form-group  {{{ $errors->has('startDate') ? 'error' : '' }}}">
					<label class="control-label" for="startDate">{{{ Lang::get('campaign/campaign.startDate') }}}</label>
					<input type="date" name="startDate" step="1" min="2014-01-01"
						   value="<?php echo date("Y-m-d");?>">
				</div>

				<div class="form-group  {{{ $errors->has('finishDate') ? 'error' : '' }}}">
					<label class="control-label" for="finishDate">{{{ Lang::get('campaign/campaign.finishDate') }}}</label>
					<input type="date" name="finishDate" step="1" min="2014-01-01"
						   value="<?php echo date("Y-m-d");?>">
				</div>

				<div class="form-group  {{{ $errors->has('link') ? 'error' : '' }}}">
					<label class="control-label" for="link">{{{ Lang::get('campaign/campaign.link') }}}</label>
					<input class="form-control" placeholder="{{{ Lang::get('campaign/campaign.link') }}}" type="text" name="link" id="link" value="{{{ Input::old('link') }}}">
					{{ $errors->first('link', '<span class="help-block">:message</span>') }}
				</div>

				<div class="form-group  {{{ $errors->has('maxVisits') ? 'error' : '' }}}">
					<label class="control-label" for="maxVisits">{{{ Lang::get('campaign/campaign.maxVisits') }}}</label>
					<input class="form-control" placeholder="{{{ Lang::get('campaign/campaign.maxVisits') }}}" type="text" name="maxVisits" id="maxVisits" value="{{{ Input::old('maxVisits') }}}">
					{{ $errors->first('maxVisits', '<span class="help-block">:message</span>') }}
				</div>

				<div class="form-group  {{{ $errors->has('promotionDuration') ? 'error' : '' }}}">
					<label class="control-label" for="promotionDuration">{{{ Lang::get('campaign/campaign.promotionDuration') }}}</label>
					<input class="form-control" placeholder="{{{ Lang::get('campaign/campaign.promotionDuration') }}}" type="text" name="promotionDuration" id="promotionDuration" value="{{{ Input::old('promotionDuration') }}}">
					{{ $errors->first('promotionDuration', '<span class="help-block">:message</span>') }}
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
			<button type="submit" class="btn btn-primary">{{{ Lang::get('campaign/campaign.save') }}}</button>

			<input type="button" class="btn btn-primary"
				   onclick="window.location.href='{{ URL::to($backUrl) }}'"

				   value="{{ Lang::get('campaign/campaign.back') }}">
		</div>

	</div>
</form>
@stop
