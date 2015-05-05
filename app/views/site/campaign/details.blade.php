@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get($campaign->name) }}} ::
    @parent
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>{{{ Lang::get($campaign->name) }}}</h1>
    </div>

    <div class="span4">
        <img src="{{ URL::to($campaign->image)}}" class="img-rounded"/>
    </div>

    <div class="clearfix control-group span6">

        <h3> {{{ Lang::get('campaign/campaign.name') }}} </h3>

        <p>{{$campaign->name }}{{{ Lang::get('campaign/campaign.promotorMessage') }}}<b>{{$ngo->name }}</b>{{{ Lang::get('campaign/campaign.dot') }}}</p></a>

        <h3> {{{ Lang::get('campaign/campaign.description') }}} </h3>

        <p>{{$campaign->description }}</p>

        <h3> {{{ Lang::get('campaign/campaign.period') }}}</h3>

        <p>{{{ Lang::get('campaign/campaign.periodFirst') }}}{{$campaign->startDate}}{{{ Lang::get('campaign/campaign.periodSecond') }}}{{$campaign->finishDate}}{{{ Lang::get('campaign/campaign.dot') }}}</p>

        <br>

        <input type="button" class="btn btn-info" onclick="window.location.href='{{{ URL::to('campaign/payToClick/'.$campaign->id) }}}'" value="{{{ Lang::get('campaign/campaign.seeOfficialWebsite') }}}">

    </div>

@stop