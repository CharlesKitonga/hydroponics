@extends('layouts.frontLayout.front_design')
@section('content')
	<div class="banner-inner">
	</div>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.html">Home</a>
		</li>
		<li class="breadcrumb-item active">Single</li>
	</ol>
	<!--/model-->
	<!--/main-->
	<section class="banner-bottom">
		<div class="container">
			<div class="row">
				<!--left-->
				<div class="col-lg-8 left-blog-info-w3layouts-agileits text-left">
					<div class="blog-grid-top">
						<div class="b-grid-top">
							<div class="blog_info_left_grid">
								<a href="single.html">
									<img src="{{asset('images/b1.jpg')}}" class="img-fluid" alt="">
								</a>
							</div>
							<div class="blog-info-middle">
								<ul>
									<li>
										<a href="#">
											<i class="far fa-calendar-alt"></i>{{$blog->created_at->diffForHumans()}}</a>
									</li>
									<li class="mx-2">
										<a href="#">
											<i class="far fa-thumbs-up"></i> 201 Likes</a>
									</li>
									<li>
										<a href="#">
											<i class="far fa-comment"></i> 15 Comments</a>
									</li>
									
								</ul>
							</div>
						</div>
						<h3>
							<a href="single.html">{{$blog->title}} </a>
						</h3>
						<p>{!! $blog->post !!}</p>
					</div>
					<div class="comment-top">
						<h4>Comments</h4>
						<div class="media">
							<img src="{{asset('images/t1.jpg')}}" alt="" class="img-fluid">
							<div class="media-body">
								<h5 class="mt-0">Joseph Goh</h5>
								<p>Lorem Ipsum convallis diam consequat magna vulputate malesuada. id dignissim sapien velit id felis ac cursus eros.
									Cras a ornare elit.</p>

								<div class="media mt-3">
									<a class="d-flex pr-3" href="#">
										<img src="{{asset('images/t2.jpg')}}" alt="" class="img-fluid">
									</a>
									<div class="media-body">
										<h5 class="mt-0">Richard Spark</h5>
										<p>Lorem Ipsum convallis diam consequat magna vulputate malesuada. id dignissim sapien velit id felis ac cursus eros.
											Cras a ornare elit.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="comment-form-wrap pt-5">
						<h3 class="mb-5">Leave a comment</h3>
						<form action="#" class="p-5 bg-light">
						<div class="form-group">
							<label for="name">Name *</label>
							<input type="text" class="form-control" id="name">
						</div>
						<div class="form-group">
							<label for="email">Email *</label>
							<input type="email" class="form-control" id="email">
						</div> 
						<div class="form-group">
							<label for="message">Message</label>
							<textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<input type="submit" value="Post Comment" class="btn btn-primary">
						</div>

						</form>
					</div>
				</div>
				<!--//left-->
				<!--right-->
				
				<aside class="col-lg-4 agileits-w3ls-right-blog-con text-right">
					<div class="right-blog-info text-left">
						<div class="tech-btm">
							<img src="{{asset('images/banner1.jpg')}}" class="img-fluid" alt="">
						</div>
						<div class="tech-btm">
							<h4>Categories</h4>
							<ul class="list-group single">
									<li class="list-group-item d-flex justify-content-between align-items-center">
									  Cras justo odio
									  <span class="badge badge-primary badge-pill">14</span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center">
									  Dapibus ac facilisis in
									  <span class="badge badge-primary badge-pill">2</span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center">
									  Morbi leo risus
									  <span class="badge badge-primary badge-pill">1</span>
									</li>
								  </ul>
						</div>
						<div class="tech-btm">
							<h4>Top stories of the week</h4>

							<div class="blog-grids row mb-3">
								<div class="col-md-5 blog-grid-left">
									<a href="single.html">
										<img src="{{asset('images/1.jpg')}}" class="img-fluid" alt="">
									</a>
								</div>
								<div class="col-md-7 blog-grid-right">

									<h5>
										<a href="single.html">Pellentesque dui, non felis. Maecenas male non felis </a>
									</h5>
									<div class="sub-meta">
										<span>
											<i class="far fa-clock"></i> 20 Jan, 2018</span>
									</div>
								</div>

							</div>
							<div class="blog-grids row mb-3">
								<div class="col-md-5 blog-grid-left">
									<a href="single.html">
										<img src="{{asset('images/6.jpg')}}" class="img-fluid" alt="">
									</a>
								</div>
								<div class="col-md-7 blog-grid-right">
									<h5>
										<a href="single.html">Pellentesque dui, non felis. Maecenas male non felis </a>
									</h5>
									<div class="sub-meta">
										<span>
											<i class="far fa-clock"></i> 20 Feb, 2018</span>
									</div>
								</div>

							</div>
						</div>
					</div>

				</aside>
				<!--//right-->
			</div>
		</div>
	</section>
	<!--//main-->
@endsection
