@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('admin/category.categories') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>{{{ Lang::get('admin/category.categories') }}}</h1>
</div>

@if(count($categories))
	<div class="table">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th class="text-center">{{{ Lang::get('admin/category.name') }}}</th>
					<th class="text-center">{{{ Lang::get('admin/category.usedIn') }}}</th>
					<th class="text-center">{{{ Lang::get('admin/category.changeName') }}}</th>
					<th class="text-center">{{{ Lang::get('admin/category.delete') }}}</th>
				</tr>
			</thead>

			@foreach ($categories as $category)
				<tbody>
					<td class="text-center"> {{ $category->name }} </td>
					<td class="text-center"> {{ count($category->project) }} {{{ Lang::get('admin/category.projects') }}} </td>

					<td class="text-center">
						@if(!count($category->project))
							<form method="POST" action="{{{ (Confide::checkAction('AdminCategoryController@createAndEdit')) ?: URL::to('admin/category/createAndEdit') }}}" accept-charset="UTF-8">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<input type="hidden" name="id" value="{{{ $category->id }}}" />

								<div class="form-horizontal">
									<input class="form-control" placeholder="{{{ Lang::get('admin/category.newName') }}}" type="text" name="name" id="name" >

								    <span class="input-group-btn">
										<button type="submit" class="btn btn-primary">{{{ Lang::get('admin/category.save') }}}</button>
								    </span>
								</div>

							</form>
						@endif
					</td>

					<td class="text-center">
						@if(!count($category->project))
							<input type="button" class="btn btn-danger" onclick="window.location.href='{{{ URL::to('admin/category/delete/'.$category->id) }}}'" value="{{{ Lang::get('admin/category.delete') }}}">
						@endif
					</td>

				</tbody>
			@endforeach
		</table>
	</div>


@else
	<div class="row">
		<div class="span3">
			<h3> {{{ Lang::get('admin/category.notFound') }}}</h3>
		</div>
	</div>
@endif

<div class="page-header">
	<h3>{{{ Lang::get('admin/category.newCategory') }}}</h3>
</div>

<form method="POST" action="{{{ (Confide::checkAction('AdminCategoryController@create')) ?: URL::to('admin/category/createAndEdit')  }}}" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<input type="hidden" name="id" value="0" />

	<div class="form-horizontal">
		<input class="form-control" placeholder="{{{ Lang::get('admin/category.name') }}}" type="text" name="name" id="name" >

		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary">{{{ Lang::get('admin/category.save') }}}</button>
		</span>
	</div>

</form>

@stop
