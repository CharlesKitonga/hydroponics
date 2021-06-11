<header>
	<div class="top-bar_sub_w3layouts container-fluid">
		<div class="row">
			<div class="col-md-4 logo text-left">
				<a class="navbar-brand" href="index.html">
					<i class="fab fa-linode"></i> AgriBlog</a>
			</div>
			<div class="col-md-4 top-forms text-center mt-lg-3 mt-md-1 mt-0">
<!-- 				<span>Welcome Back!</span>
 -->				@guest
					<span class="mx-lg-4 mx-md-2  mx-1">
						<a href="{{ url('user-login') }}">
							<i class="fas fa-lock"></i> Sign In</a>
					</span>
				@if (Route::has('register'))
					<span>
						<a href="{{ url('user-register') }}">
							<i class="far fa-user"></i> Register</a>
					</span>
				@endif
				 @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('user-logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ url('user-logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
			</div>
			<div class="col-md-4 log-icons text-right">

				<ul class="social_list1 mt-3">

					<li>
						<a href="#" class="facebook1 mx-2" >
							<i class="fab fa-facebook-f"></i>

						</a>
					</li>
					<li>
						<a href="#" class="twitter2">
							<i class="fab fa-twitter"></i>

						</a>
					</li>
					<li>
						<a href="#" class="instagram1  mx-2">
							<i class="fab fa-instagram"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

		<div class="header_top" id="home">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<button class="navbar-toggler navbar-toggler-right mx-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
					aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
			   </button>


				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item active">
							<a class="nav-link" href="/">Home
								<span class="sr-only">(current)</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{url('/about-us')}}">About</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
							    aria-expanded="false">
								Categories
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="#"></a>
								<a class="dropdown-item" href="blog1.html">Standard Blog</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="blog2.html">2 Column Blog</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="blog3.html">3 Column Blog</a>

							</div>
						</li>

					</ul>
						<form action="#" method="post" class="form-inline my-2 my-lg-0 header-search">
							<input class="form-control mr-sm-2" type="search" placeholder="Search here..." name="Search" required="">
							<button class="btn btn1 my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
						</form>
	
					

				</div>
			</nav>

		</div>
</header>
<!--//header-->