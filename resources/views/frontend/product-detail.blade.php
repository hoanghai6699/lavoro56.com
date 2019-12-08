@extends('frontend.master')
@section('title','Chi tiết sản phẩm')
@section('content')
<style>
	.product-tab-content img,em {
		margin: 0 auto;
		text-align: center;
		display: block;
		max-width: 100%;
	}
</style>
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="container-inner">
					<ul>
						<li class="home">
							<a href="{{route('frontend.get.home')}}">{!! trans('message.home') !!}</a>
							<span><i class="fa fa-angle-right"></i></span>
						</li>
						<li class="category3"><span>{!! trans('message.product details') !!}</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="product-details-area">
	<div class="container">
		<div class="col-lg-12">
			@if(Session::has('success'))
			<div class="alert alert-{!! Session::get('level') !!}">
				{!! Session::get('success') !!}
			</div>
			@endif
		</div>
		<div class="row">
			<div class="col-md-5 col-sm-5 col-xs-12">
				<div class="zoomWrapper">
					<div id="img-1" class="zoomWrapper single-zoom">
						<a>
							<img id="zoom1" src="{{url('/uploads')}}/{{$product->image}}" data-zoom-image="{{url('/uploads')}}/{{$product->image}}" alt="big-1">
						</a>
					</div>
					<div class="single-zoom-thumb">
						<ul class="bxslider" id="gallery_01">
							<img src="{{url('/uploads')}}/{{$product->image}}">
							@foreach($image as $images)
							<li>
								<a class="elevatezoom-gallery" href="#" data-image="{{url('/uploads/detail/')}}/{{$images->images}}" data-zoom-image="{{url('/uploads/detail/')}}/{{$images->images}}"><img id="zoom1" src="{{url('/uploads/detail/')}}/{{$images->images}}" alt="zo-th-2"></a>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12">
				<div class="product-list-wrapper">
					<div class="single-product">
						<div class="product-content">
							<h2 class="product-name"><a href="#">{{$product->name}}</a></h2>
							<div class="rating-price">	
								<div class="pro-rating">
									<a href="#"><i class="fa fa-star"></i></a>
									<a href="#"><i class="fa fa-star"></i></a>
									<a href="#"><i class="fa fa-star"></i></a>
									<a href="#"><i class="fa fa-star"></i></a>
									<a href="#"><i class="fa fa-star"></i></a>
								</div>
								<div class="price-boxes">
									<span class="new-price">{{number_format($product->price,0,',','.')}} đ</span>
									
								</div>


							</div>
								<?php $s = DB::table('sale_products')->where('product_id',$product->id)->get();?>
			                    @foreach($s as $ss)
			                    <?php $p = DB::table('products')->where('id',$ss->product_id)->first(); ?>
			                    <p>KM: {{$ss->sale}} (%)</p>
	                            <p>từ "{{$ss->start_date}}" đến "{{$ss->end_date}}"</p>
			                    @endforeach
							<div class="product-desc">
								<p>{{$product->description}}</p>
							</div>
							
							<div class="price-boxes">
								<div class="select-box">
									<select name="size" id="size" class="form-control" style="font-weight: bold; width: 220px;">
										<option value="">{!! trans('message.please choose size') !!}</option>
										@if(isset($size))
										@foreach($size as $sizes)
											@if($sizes->qty > 0)
											<option value="{{$sizes['size_id']}}" data-quantity="{{$sizes->qty}}">
												<?php $s = DB::table('sizes')->where('id',$sizes["size_id"])->first();
												echo "$s->size";
												 ?> EUR
											</option>
											@endif
										@endforeach
										@endif
									</select>
								</div>
							</div>
							
							<div class="actions-e">
								<div class="action-buttons-single">
									<div class="inputx-content">
										<label for="qty">{!! trans('message.quantity') !!}:</label>
										<input type="number" name="qty" id="qty" maxlength="12" value="1" title="Qty" class="input-text qty">
									</div>
									<div class="add-to-cart">
										<button id="add-to-cart" class="btn btn-success">{!! trans('message.add to cart') !!}</button>
									</div>
								</div>
								<p>{!! trans('message.remain') !!} <span id='amount'></span> {!! trans('message.product') !!}</p>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="single-product-tab">
				<!-- Nav tabs -->
				<ul class="details-tab">
					<li class="active"><a href="#home" data-toggle="tab">{!! trans('message.describe') !!}</a></li>
					<li class=""><a href="#messages" data-toggle="tab"> {!! trans('message.comment') !!}</a></li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						<div class="product-tab-content">
							<p>{!!$product->content!!}</p>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="messages">
						<div class="single-post-comments col-md-12">
							<div class="comment-respond">
								<div class="row">
									<div class="fb-comments" data-href="{{route('frontend.get.loaisanpham',[$product->id,$product->slug])}}" data-width="" data-numposts="1"></div>
								</div>
							</div>						
						</div>
					</div>
				</div>					
			</div>
		</div>
	</div>
</div>
<!-- product-details Area end -->
<!-- product section start -->
<div class="our-product-area new-product">
	<div class="container">
		<div class="area-title">
			<h2>{!! trans('message.products of the same type') !!}</h2>
		</div>
		<!-- our-product area start -->
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="features-curosel">
						@foreach($product_new as $prod_new)
						@if($prod_new->active == 1)
						<div class="col-lg-12 col-md-12">
							<div class="single-product first-sale">
								<div class="product-img">
									<a href="{{route('frontend.get.chitietsanpham',[$prod_new->id,$prod_new->slug])}}">
										<img class="primary-image" src="{{url('/uploads')}}/{{$prod_new->image}}" alt="" />
										<img class="secondary-image" src="{{url('/uploads')}}/{{$prod_new->image}}" alt="" />
									</a>
									<div class="action-zoom">
										<div class="add-to-cart">
											<a href="{{route('frontend.get.chitietsanpham',[$prod_new->id,$prod_new->slug])}}" title="Quick View"><i class="fa fa-search-plus"></i></a>
										</div>
									</div>
									<div class="price-box">
										<span class="new-price">{{number_format($prod_new->price,0,',','.')}} đ</span>
									</div>
								</div>
								<div class="product-content">
									<h2 class="product-name"><a href="#">{{$prod_new->name}}</a></h2>
								</div>
							</div>
						</div>
						@endif
						@endforeach
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">
	$(document).ready(function (){
		var size_id =  $('#size').val();
		showQuantity(size_id);
		$('#size').change(function (){
			size_id = $(this).val();
			$('#qty').val(1);
			showQuantity(size_id);
		})

		$('#add-to-cart').on('click', function (){
			let productId = {{$product->id}};
			let qty = $('#qty').val();
			let size = $('#size').val();
			$.ajax({
				url: `{{route('shoppingcart.ajax.muahang')}}`,
				type: 'POST',
				dataType: 'json',
				data: {
					'productId': productId,
					'qty': qty,
					'size': size
				},
				success:function(data)
                {
                	if (data.valid.success==false) {
                		toastr.warning(data.valid.messages);
                	} else {
                		toastr.success(data.valid.messages);
                		setTimeout(function() {
                            location.assign("{{route("shoppingcart.get.giohang")}}");
                        }, 2000);
                		
                	}
                }
			})
		})
		function showQuantity(size_id){
			// lặp qua mỗi option, nếu option value bằng với size_id được chọn thì lấy data-quantity của option đó để hiện thị số lượng sản phẩm trong table
			$("#size option").each(function (){
			var option_size = $(this).attr('value');
			if(size_id === option_size){
				size_qty = $(this).attr('data-quantity');
					$('#amount').html(size_qty);
					$('#amount').attr('data-quantity',size_qty);
				}
			})
		}
	})
</script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v4.0"></script>
@stop