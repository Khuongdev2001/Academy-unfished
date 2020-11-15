
{{-- extends template parent  --}}
@extends("layouts.client")

{{-- require title  --}}

@section("title","Danh sách bài viết")


{{-- require css more --}}
@section('css')
    
@endsection

{{-- require js more --}}
@section('js')
    
@endsection

{{-- require content   --}}
@section('content')
  

<section class="pt-5">
	<div class="container">
		<!-- Onclick Sidebar -->
		<!-- Row -->
		<form action="" class="row">
			<div class="col-md-12 col-sm-12 order-1 order-lg-2 order-md-1">

				<!-- Row -->
				<div class="row align-items-center mb-3">
					<div class="col-md-4 col-sm-12">
						We found <strong>142</strong> courses for you
                    </div>
                    <div class="col-md-4 form-inline addons">
						<input class="form-control" name="seach" type="search" placeholder="Search Courses" value="{{ request("seach") }}">
						<button class="btn my-2 my-sm-0" type="submit"><i class="ti-search"></i></button>
					</div>
					<select name="created_at" class="col-md-4 col-sm-12 form-control form-control-sm">
                        <option value="desc">Cũ dần</option>
                        <option value="asc">Mới dần</option>
					</select>
				</div>
				<!-- /Row -->

				<div class="row">

                    <!-- Cource Grid 1 -->
                    
                    @foreach($posts as $post)
					<div class="col-md-4">
						<div class="education_block_grid style_2">

							<div class="education_block_thumb n-shadow">
                                <a href="{{ route("post.detail",$post->id) }}"><img src="{{ asset($post->thumbnail) }}" class="img-fluid" alt=""></a>
							</div>

							<div class="education_block_body">
                                <h4 class="bl-title"><a href="{{ route("post.detail",$post->id) }}">{{ $post->name }}</a></h4>
							</div>

							<div class="desc cources_info_style3 p-2"> {!! $post->desc !!}</div>
                            <div class="p-2 cources_facts">
                                <ul class="cources_facts_list">
                                    <li class="facts-3">
                                        {{ $post->cat->name }}
                                    </li>
                                </ul>
                            </div>
							<div class="education_block_footer">
								<div class="education_block_author">
                                    {{-- thumbnail user --}}
									<div class="path-img"><a href="instructor-detail.html"><img src="{{ asset($post->user->thumbnail) }}" class="img-fluid" alt=""></a></div>
                                    {{-- name user creator --}}
                                    <h5><a href="instructor-detail.html">

                                        {{ $post->user->fullname }}

                                    </a></h5>
								</div>
								<div class="foot_lecture">{{ $post->created_at }} </div>
							</div>

						</div>
                    </div>
                    @endforeach
				</div>

				<!-- Row -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">

						<!-- Pagination -->
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<ul class="pagination p-center">
									<li class="page-item "><a class="page-link" href="#">1</a></li>
								</ul>
							</div>
						</div>

					</div>
				</div>
				<!-- /Row -->

			</div>

		</form>
		<!-- Row -->

	</div>
</section>

@endsection