
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="author" content="www.frebsite.nl" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title>
        @yield('title')
    </title>

    {{-- customer list css  --}}
    <link href="{{ asset("client/css/styles.css") }}" rel="stylesheet">

    {{-- customer css color --}}
    <link href="{{ asset("client/css/colors.css") }}" rel="stylesheet">
    
    {{-- the require css lay out --}}
    @section('css')
        
    @show

</head>

<body class="red-skin blog-page">

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div id="preloader">
        <div class="preloader"><span></span><span></span></div>
    </div>


    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">

        <!-- ============================================================== -->
        <!-- Top header  -->
        <!-- ============================================================== -->
        <!-- Start Navigation -->
        <div class="header header-light head-shadow">
            <div class="container">
                <nav id="navigation" class="navigation navigation-landscape">
                    <div class="nav-header">
                        <!-- <a class="nav-brand static-logo" href="#"><img src="assets/img/logo-light.png" class="logo" alt="" /></a> -->
                        <a class="nav-brand fixed-logo" href="#"><img src="assets/img/logo.png" class="logo" alt="" /></a>
                        <div class="nav-toggle"></div>
                    </div>
                    <div class="nav-menus-wrapper" style="transition-property: none;">
                        <ul class="nav-menu">

                            <li><a href="#">Khóa học online<span class="submenu-indicator"></span></a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li><a href="#">Courses Grid Sidebar<span class="submenu-indicator"></span></a>
                                        <ul class="nav-dropdown nav-submenu">
                                            <li><a href="grid-with-sidebar.html">PHP</a></li>
                                            <li><a href="grid-with-sidebar-2.html">Courses grid 1</a></li>
                                            <li><a href="grid-with-sidebar-3.html">Courses grid 1</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="list-with-sidebar.html">List Layout with Sidebar</a></li>
                                    <li><a href="#">Courses Grid Full Width<span class="submenu-indicator"></span></a>
                                        <ul class="nav-dropdown nav-submenu">
                                            <li><a href="full-width-course.html">Courses grid 1</a></li>
                                            <li><a href="full-width-course-2.html">Courses grid 1</a></li>
                                            <li><a href="full-width-course-3.html">Courses grid 1</a></li>
                                            <li><a href="full-width-course-4.html">Courses grid 1</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Courses Detail<span class="submenu-indicator"></span></a>
                                        <ul class="nav-dropdown nav-submenu">
                                            <li><a href="detail.html">Course Detail 1</a></li>
                                            <li><a href="detail-2.html">Course Detail 2</a></li>
                                            <li><a href="detail-3.html">Course Detail 3</a></li>
                                            <li><a href="detail-4.html">Course Detail 4</a></li>
                                            <li><a href="detail-5.html">Course Detail 5</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="find-instructor.html">Find Instructor</a></li>
                                    <li><a href="instructor-detail.html">Instructor Detail</a></li>
                                </ul>
                            </li>


                            <li><a href="#">Khóa học offline<span class="submenu-indicator"></span></a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li><a href="#">Courses Grid Sidebar<span class="submenu-indicator"></span></a>
                                        <ul class="nav-dropdown nav-submenu">
                                            <li><a href="grid-with-sidebar.html">Courses grid 1</a></li>
                                            <li><a href="grid-with-sidebar-2.html">Courses grid 1</a></li>
                                            <li><a href="grid-with-sidebar-3.html">Courses grid 1</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="list-with-sidebar.html">List Layout with Sidebar</a></li>
                                    <li><a href="#">Courses Grid Full Width<span class="submenu-indicator"></span></a>
                                        <ul class="nav-dropdown nav-submenu">
                                            <li><a href="full-width-course.html">Courses grid 1</a></li>
                                            <li><a href="full-width-course-2.html">Courses grid 1</a></li>
                                            <li><a href="full-width-course-3.html">Courses grid 1</a></li>
                                            <li><a href="full-width-course-4.html">Courses grid 1</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Courses Detail<span class="submenu-indicator"></span></a>
                                        <ul class="nav-dropdown nav-submenu">
                                            <li><a href="detail.html">Course Detail 1</a></li>
                                            <li><a href="detail-2.html">Course Detail 2</a></li>
                                            <li><a href="detail-3.html">Course Detail 3</a></li>
                                            <li><a href="detail-4.html">Course Detail 4</a></li>
                                            <li><a href="detail-5.html">Course Detail 5</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="find-instructor.html">Find Instructor</a></li>
                                    <li><a href="instructor-detail.html">Instructor Detail</a></li>
                                </ul>
                            </li>

                            <li><a href="#">Bài viết<span class="submenu-indicator"></span></a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li class=""><a href="#">User Dashboard<span class="submenu-indicator"></span></a>
                                        <ul class="nav-dropdown nav-submenu">
                                            <li><a href="dashboard.html">User Dashboard</a></li>
                                            <li><a href="my-profile.html">My Profile</a></li>
                                            <li><a href="all-courses.html">My Courses</a></li>
                                            <li><a href="my-order.html">My Order</a></li>
                                            <li><a href="saved-courses.html">Saved Courses</a></li>
                                            <li><a href="reviews.html">My Reviews</a></li>
                                            <li><a href="settings.html">My Settings</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Shop Pages<span class="submenu-indicator"></span></a>
                                        <ul class="nav-dropdown nav-submenu">
                                            <li><a href="shop-full-width.html">Shop Full Width</a></li>
                                            <li><a href="shop-left-sidebar.html">Shop Sidebar Left</a></li>
                                            <li><a href="shop-right-sidebar.html">Shop Sidebar Right</a></li>
                                            <li><a href="product-detail.html">Shop Detail</a></li>
                                            <li><a href="add-to-cart.html">Add To Cart</a></li>
                                            <li><a href="product-wishlist.html">Wishlist</a></li>
                                            <li><a href="checkout.html">Checkout</a></li>
                                            <li><a href="shop-order.html">Order</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="about-us.html">About Us</a></li>
                                    <li><a href="blog.html">Blog Style</a></li>
                                    <li><a href="blog-detail.html">Blog Detail</a></li>
                                    <li><a href="pricing.html">Pricing</a></li>
                                    <li><a href="404.html">404 Page</a></li>
                                    <li><a href="register.html">Register</a></li>
                                    <li><a href="component.html">Elements</a></li>
                                    <li><a href="privacy.html">Privacy Policy</a></li>
                                    <li><a href="faq.html">FAQs</a></li>
                                </ul>
                            </li>

                            <li><a href="contact.html">Liên Hệ</a></li>

                        </ul>

                        <ul class="nav-menu nav-menu-social align-to-right">

                            <li class="login_click light">
                                <a href="#" data-toggle="modal" data-target="#login">Đăng nhập</a>
                            </li>
                            <li class="login_click bg-green">
                                <a href="#" data-toggle="modal" data-target="#signup">Đăng ký</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- End Navigation -->
        <div class="clearfix"></div>
        <!-- ============================================================== -->
        <!-- Top header  -->
        <!-- ============================================================== --><!-- post index 6-11-2020 -->

  {{-- require content --}}

  @section('content')
      
  @show

<!-- ============================== Start Newsletter ================================== -->
<section class="newsletter theme-bg inverse-theme">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7 col-md-8 col-sm-12">
				<div class="text-center">
					<h2>Join Thousand of Happy Students!</h2>
					<p>Subscribe our newsletter & get latest news and updation!</p>
					<form class="sup-form">
						<input type="email" class="form-control sigmup-me" placeholder="Your Email Address" required="required">
						<input type="submit" class="btn btn-theme" value="Get Started">
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ================================= End Newsletter =============================== -->

<!-- ============================ Footer Start ================================== -->
<footer class="dark-footer skin-dark-footer">
	<div>
		<div class="container">
			<div class="row">

				<div class="col-lg-3 col-md-3">
					<div class="footer-widget">
						<img src="assets/img/logo-light.png" class="img-footer" alt="" />
						<div class="footer-add">
							<p>4967 Sardis Sta, Victoria 8007, Montreal.</p>
							<p>+1 246-345-0695</p>
							<p>info@learnup.com</p>
						</div>

					</div>
				</div>
				<div class="col-lg-2 col-md-3">
					<div class="footer-widget">
						<h4 class="widget-title">Navigations</h4>
						<ul class="footer-menu">
							<li><a href="about-us.html">About Us</a></li>
							<li><a href="faq.html">FAQs Page</a></li>
							<li><a href="checkout.html">Checkout</a></li>
							<li><a href="contact.html">Contact</a></li>
							<li><a href="blog.html">Blog</a></li>
						</ul>
					</div>
				</div>

				<div class="col-lg-2 col-md-3">
					<div class="footer-widget">
						<h4 class="widget-title">New Categories</h4>
						<ul class="footer-menu">
							<li><a href="#">Designing</a></li>
							<li><a href="#">Nusiness</a></li>
							<li><a href="#">Software</a></li>
							<li><a href="#">WordPress</a></li>
							<li><a href="#">PHP</a></li>
						</ul>
					</div>
				</div>

				<div class="col-lg-2 col-md-3">
					<div class="footer-widget">
						<h4 class="widget-title">Help & Support</h4>
						<ul class="footer-menu">
							<li><a href="#">Documentation</a></li>
							<li><a href="#">Live Chat</a></li>
							<li><a href="#">Mail Us</a></li>
							<li><a href="#">Privacy</a></li>
							<li><a href="#">Faqs</a></li>
						</ul>
					</div>
				</div>

				<div class="col-lg-3 col-md-12">
					<div class="footer-widget">
						<h4 class="widget-title">Download Apps</h4>
						<a href="#" class="other-store-link">
							<div class="other-store-app">
								<div class="os-app-icon">
									<i class="lni-playstore theme-cl"></i>
								</div>
								<div class="os-app-caps">
									Google Play
									<span>Get It Now</span>
								</div>
							</div>
						</a>
						<a href="#" class="other-store-link">
							<div class="other-store-app">
								<div class="os-app-icon">
									<i class="lni-apple theme-cl"></i>
								</div>
								<div class="os-app-caps">
									App Store
									<span>Now it Available</span>
								</div>
							</div>
						</a>
					</div>
				</div>

			</div>
		</div>
    </div>
   

<!-- Log In Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
    <div class="modal-content" id="registermodal">
      <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
      <div class="modal-body">
        <h4 class="modal-header-title">Đăng nhập</h4>
        <div class="login-form">
          <form>

            <div class="form-group">
              <label>Tài Khoản</label>
              <input type="text" class="form-control" placeholder="Tài Khoản">
            </div>

            <div class="form-group">
              <label>Mật Khẩu</label>
              <input type="password" class="form-control" placeholder="*******">
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-md full-width pop-login">Đăng Ký</button>
            </div>

          </form>
        </div>

        <div class="social-login mb-3">
          <ul>
            <li>
              <input id="reg" class="checkbox-custom" name="reg" type="checkbox">
              <label for="reg" class="checkbox-custom-label">Nhớ mật khẩu</label>
            </li>
            <li><a href="#" class="theme-cl" aria-hidden="true" data-dismiss="modal" data-toggle="modal" data-target="#forget-password" >Quên mật khẩu ?</a></li>
          </ul>
        </div>
        <div class="text-center">
          <p class="mt-2">Tôi chưa có tài khoản? <a href="#" class="link" data-dismiss="modal" aria-hidden="true" data-toggle="modal" data-target="#signup">Đăng ký</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Sign Up Modal -->
<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
    <div class="modal-content" id="sign-up">
      <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
      <div class="modal-body">
        <h4 class="modal-header-title">Đăng Ký</h4>
        <div class="login-form">
          <form>

            <div class="form-group">
              <input type="text" class="form-control" placeholder="Họ và tên">
            </div>

            <div class="form-group">
              <input type="email" class="form-control" placeholder="Email">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" placeholder="Tài Khoản">
            </div>

            <div class="form-group">
              <input type="password" class="form-control" placeholder="*******">
            </div>


            <div class="form-group">
              <button type="submit" class="btn btn-md full-width pop-login">Đăng ký</button>
            </div>

          </form>
        </div>
        <div class="text-center">
          <p class="mt-3"><i class="ti-user mr-1"></i>Tôi đã có tài khoản <a href="#" class="link" data-dismiss="modal" aria-hidden="true" data-toggle="modal" data-target="#login">Đăng nhập</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
<!-- Model forget password -->
<div class="modal fade" id="forget-password" tabindex="-1" role="dialog" aria-labelledby="forget-password" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
    <div class="modal-content" id="sign-up">
      <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
      <div class="modal-body">
        <h4 class="modal-header-title">Quên Mật Khẩu</h4>
        <div class="login-form">
          <form>
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-md full-width pop-login">Gửi</button>
            </div>
          </form>
        </div>
        <div class="text-center">
          <p class="mt-3"><i class="ti-user mr-1"></i>Tôi đã có tài khoản <a href="#" class="link" data-dismiss="modal" aria-hidden="true" data-toggle="modal" data-target="#login">Đăng nhập</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Model forget password -->


<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset("client/js/jquery.min.js") }}"></script>
<script src="{{ asset("client/js/popper.min.js") }}"></script>
<script src="{{ asset("client/js/bootstrap.min.js") }}"></script>
<script src="{{ asset("client/js/select2.min.js") }}"></script>
<script src="{{ asset("client/js/slick.js") }}"></script>
<script src="{{ asset("client/js/jquery.counterup.min.js") }}"></script>
<script src="{{ asset("client/js/counterup.min.js") }}"></script>
<script src="{{ asset("client/js/custom.js") }}"></script>

<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<script>
			function openNav() {
			  document.getElementById("filter-sidebar").style.width = "320px";
			}

			function closeNav() {
			  document.getElementById("filter-sidebar").style.width = "0";
            }
            
        </script>

<script>
    
</script>
        

{{-- require js  --}}
@section('js')
    
@endsection        
</body>

</html>