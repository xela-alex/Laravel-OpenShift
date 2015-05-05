@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop



{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{ $title }}}

			</h3>
	</div>
	<form class="form-horizontal" method="post" action="{{ URL::to('ngo/credits/create')}}" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

	<table id="credit" class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-md-4">{{{ Lang::get('ngo/credits/table.credits') }}}</th>
				<th class="col-md-2">{{{ Lang::get('ngo/credits/table.price') }}}</th>
				<th class="col-md-2">{{{ Lang::get('ngo/credits/table.total') }}}</th>

			</tr>
		</thead>
		<tbody>
		<tr>
			<td class="col-md-4">
				<input class="form-control" type="text"	name="credits" id="credits" onchange="document.getElementById('total').value=parseInt(document.getElementById('credits').value)*0.06;"	value="{{{ Input::old('credits') }}}">
				{{ $errors->first('credits', '<span class="help-block">:message</span>') }}</td>
			<td class="col-md-2">0.06</td>
			<td class="col-md-2"><input class="form-control" readonly="readonly" type="text" name="total" id="total" value="0.0"></td>

		</tr>
		</tbody>
	</table>
		<div class="form-actions form-group">
			<button type="submit"
					class="btn btn-primary">{{{ Lang::get('ngo/credits/table.pay') }}}</button>
			<input type="button" class="btn btn-primary"
				   onclick="window.location.href='{{ URL::to('/') }}'"

				   value="{{ Lang::get('ngo/ngo.back') }}">
		</div>

		</div>
	</form>
@stop




@stop