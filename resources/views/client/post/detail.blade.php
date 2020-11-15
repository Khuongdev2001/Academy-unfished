
{{-- extends template parent  --}}
@extends("layouts.client")

{{-- require title  --}}

@section("title","Danh sách bài viết")


{{-- require css more --}}
@section('css')
    
    <link rel="stylesheet" href="{{asset("css/main.css")}}">

@endsection

{{-- require js more --}}
@section('js')


@endsection

{{-- require content   --}}
@section('content')

<!-- ============================================================== -->
<section class="gray">

    <div class="container">

        <!-- row Start -->
        <div class="row">

            <!-- Blog Detail -->
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="article_detail_wrapss single_article_wrap format-standard">
                    <div class="article_body_wrap">

                        <div class="article_featured_image">
                            <img class="img-fluid" src="{{ asset($post->thumbnail) }}" alt="{{ $post->name }}">
                        </div>

                        <div class="article_top_info">
                            <ul class="article_middle_info">
                                <li><a href="#"><span class="icons"></span>by {{ $post->user->fullname }}</a></li>
                                <li><a href="#"><span class="icons"></span>{{ $numComment }} Comments</a></li>
                            </ul>
                        </div>
                        <h2 class="post-title">{{ $post->name }}</h2>
                        <div class="content">
                            {!! $post->content !!}
                        </div>
                        <div class="single_article_pagination">
                           @if($prevId) 
                            <div class="prev-post">
                                <a href="{{ route("post.detail",$prevId) }}" class="theme-bg">
                                    <div class="title-with-link">
                                        <span class="intro">Prev Post</span>
                                    </div>
                                </a>
                            </div>
                            @endif

                            @if($nextId)
                            <div class="next-post">
                                <a href="{{ route("post.detail",$nextId) }}" class="theme-bg">
                                    <div class="title-with-link">
                                        <span class="intro">Next Post</span>
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- Blog Comment -->
                <div class="article_detail_wrapss single_article_wrap format-standard">

                    <div class="comment-area">
                        <div class="all-comments">
                            <h3 class="comments-title">{{ $numComment }} Bình Luận</h3>
                            <div class="comment-list">
                                <ul>
                                    @foreach( $comments as $comment )
                                    <li class="article_comments_wrap">
                                        <article>
                                            <div class="article_comments_thumb">
                                                <img src="{{ asset($comment->user->thumbnail) }}" alt="">
                                            </div>
                                            <div class="comment-details">
                                                <div class="comment-meta">
                                                    <div class="comment-left-meta">
                                                        <h4 class="author-name"> {{ $comment->user->fullname }}</h4>
                                                        <div class="comment-date">{{ $comment->created_at }}</div>
                                                    </div>
                                                </div>
                                                <div class="comment-text">
                                                    <p>
                                                        {{ $comment->content }}
                                                    </p>
                                                </div>
                                            </div>
                                        </article>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        
                        <div class="comment-box submit-form">
                            <h3 class="reply-title">Bình Luận</h3>
                            <div class="comment-form">
                                <form method="POST" action="{{ route("post.comment.add",$post->id)}}" >

                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <textarea name="content" class="form-control" cols="30" rows="6" placeholder="Type your comments...."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <button class="btn search-btn">Submit Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <!-- Single blog Grid -->
            <div class="col-lg-4 col-md-12 col-sm-12 col-12">

                <!-- Searchbard -->
                <div class="single_widgets widget_search">
                    <h4 class="title">Search</h4>
                    <form action="{{ route("post") }}" class="sidebar-search-form">
                        <input type="search" name="seach" placeholder="Search..">
                        <button type="submit"><i class="ti-search"></i></button>
                    </form>
                </div>
         </div>
        <!-- /row -->

    </div>

</section>
<!-- ============================ Agency List End ================================== -->

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

@endsection