@extends('site.layouts.default')

{{-- Content --}}
@section('content')
	<div id="decorative1" style="position:relative">
		<div class="container">

			<div class="divPanel headerArea">
				<div class="row-fluid">
					<div class="span12">

						<div id="headerSeparator"></div>

						<div id="divHeaderText" class="page-content">
							<div id="divHeaderLine1">Your Header Text Here!</div><br />
							<div id="divHeaderLine2">2nd line header text for calling extra attention to featured content..</div><br />
							<div id="divHeaderLine3"><a class="btn btn-large btn-primary" href="#">More Info</a></div>
						</div>

						<div id="headerSeparator2"></div>

					</div>
				</div>

			</div>

		</div>
	</div>

	<div id="contentOuterSeparator"></div>

	<div class="container">

		<div class="divPanel page-content">

			<div class="row-fluid">

				<div class="span12" id="divMain">

					<h1>Welcome</h1>

					<p>Content on this page is for presentation purposes only. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
						Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					</p>

					<hr style="margin:45px 0 35px" />

					<div class="lead">
						<h2>Lorem ipsum dolor sit amet.</h2>
						<h3>Vivamus leo ante, consectetur sit amet vulputate vel, dapibus sit amet lectus.</h3>
					</div>
					<br />

					<div class="list_carousel responsive">
						<ul id="list_photos">
							<li><img src="{{asset('template/images/carmel.jpg')}}" class="img-polaroid">  </li>
							<li><img src="{{asset('template/images/rula-sibai-pink-flowers.jpg')}}" class="img-polaroid">  </li>
							<li><img src="{{asset('template/images/girl-flowers.jpg')}}" class="img-polaroid">  </li>
							<li><img src="{{asset('template/images/night-city.jpg')}}" class="img-polaroid">  </li>
							<li><img src="{{asset('template/images/irish-hands.jpg')}}" class="img-polaroid">  </li>
							<li><img src="{{asset('template/images/Top_view.jpg')}}" class="img-polaroid">  </li>
							<li><img src="{{asset('template/images/vectorbeastcom-grass-sun.jpg')}}" class="img-polaroid">  </li>
							<li><img src="{{asset('template/images/sunset-hair.jpg')}}" class="img-polaroid">  </li>
							<li><img src="{{asset('template/images/stones-hi-res.jpg')}}" class="img-polaroid">  </li>
							<li><img src="{{asset('template/images/salzburg-x.jpg')}}" class="img-polaroid">  </li>
						</ul>
					</div>

					<hr style="margin:45px 0 35px" />

					<div class="lead">
						<h2>Featured Content.</h2>
						<h3>Content on this page is for presentation purposes only.</h3>
					</div>
					<br />

					<div class="row-fluid">
						<div class="span8">

							<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>

							<p>
								<img src="{{asset('template/images/spring-is-coming.jpg')}}" class="img-polaroid" style="margin:12px 0px;">
							</p>

							<p>Content on this page is for presentation purposes only. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
								Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
								Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							</p>

						</div>
						<div class="span4 sidebar">

							<div class="sidebox">
								<h3 class="sidebox-title">Sample Sidebar Content</h3>
								<p>Lorem Ipsum is simply dummy text of the printing and <a href="#">typesetting industry</a>. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s.</p>
							</div>

							<br />

							<div class="sidebox">
								<h3 class="sidebox-title">Sample Sidebar Content</h3>
								<p>
								<div class="input-append">
									<input class="span8" id="inpEmail" size="16" type="text"><button class="btn" type="button">Action</button>
								</div>
								</p>
							</div>

						</div>
					</div>

				</div>

			</div>


		</div>

	</div>
@foreach ($posts as $post)
<div class="row">
	<div class="col-md-8">
		<!-- Post Title -->
		<div class="row">
			<div class="col-md-8">
				<h4><strong><a href="{{{ $post->url() }}}">{{ String::title($post->title) }}</a></strong></h4>
			</div>
		</div>
		<!-- ./ post title -->

		<!-- Post Content -->
		<div class="row">
			<div class="col-md-2">
				<a href="{{{ $post->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy(Str::limit($post->content, 200)) }}
				</p>
				<p><a class="btn btn-mini btn-default" href="{{{ $post->url() }}}">Read more</a></p>
			</div>
		</div>
		<!-- ./ post content -->

		<!-- Post Footer -->
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $post->author->username }}}</span>
					| <span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $post->date() }}}
					| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $post->url() }}}#comments">{{$post->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $post->comments()->count()) }}</a>
				</p>
			</div>
		</div>
		<!-- ./ post footer -->
	</div>
</div>

<hr />
@endforeach

{{ $posts->links() }}

@stop
