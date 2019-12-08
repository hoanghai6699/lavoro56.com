@extends('frontend.master')
@section('title','Giỏ hàng')
@section('content')
<form action="" method="post">
{{csrf_field()}}
<script>
	function updatecart(qty,rowId){
	$.get(
	    '{{ asset("cap-nhat") }}',
	    {qty:qty,rowId:rowId},
	    function(){
	      	location.reload();
	    }
	);
}
</script>
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
						<li class="category3"><span>{!! trans('message.cart') !!}</span></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-12">
			@if(Session::has('success'))
			<div class="alert alert-{!! Session::get('level') !!}">
				{!! Session::get('success') !!}
			</div>
			@endif
		</div>
		</div>
	</div>
</div>
<!-- breadcrumbs area end -->
<!-- Shopping Table Container -->
<div class="cart-area-start">
	<div class="container">
		@if(Cart::count()>0)
		<!-- Shopping Cart Table -->
		<div class="row">
			<div class="col-md-12">

				<div class="table-responsive">
					<table class="cart-table">
						<thead>
							<tr>
								<th>STT</th>
								<th>{!! trans('message.image') !!}</th>
								<th>{!! trans('message.name product') !!}</th>
								<th>{!! trans('message.unit price') !!}</th>
								<th>{!! trans('message.quantity') !!}</th>
								<th>{!! trans('message.subtotal') !!}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php $stt=0 ?>
							@foreach($content as $key => $item)
							<?php $stt++ ?>
							<tr>
								<td>#{{$stt}}</td>
								<td>
									<img src="{{url('/uploads')}}/{{$item->options->img}}" class="img-responsive" alt=""/>
								</td>
								<td>
									<h6>
										{{$item->name}}
										<ul style="padding-left: 20px;">
                                            <li>Size: 
                                            	<?php $p = DB::table('sizes')->where('id',$item->options->size)->first();
                                                        echo "$p->size";
                                                    ?>
                                            </li>
                                        </ul>
									</h6>
								</td>
								<td>
									<div class="cart-price">{{number_format($item->options->price_old,0,',','.')}} đ</div>
								</td>
								<td>
									<form>
										<input type="text" name="qty" placeholder="{{$item->qty}}" onchange="updatecart(this.value,'{{$item->rowId}}')">
									</form>
								</td>
								<td>
									<div class="cart-subtotal">{{number_format($item->price*$item->qty,0,',','.')}} đ</div>
								</td>
								<td><a href="{{route('shoppingcart.get.xoahang',$key)}}"><i class="fa fa-times"></i></a></td>
							</tr>
							@endforeach
							<tr>
								<td class="actions-crt" colspan="7">
									<div class="">
										<div class="col-md-6 col-sm-6 col-xs-6 align-left"><a class="cbtn" href="{{route('frontend.get.home')}}">{!! trans('message.continue shopping') !!}</a></div>
										<div class="col-md-6 col-sm-6 col-xs-6 align-right"><a class="cbtn" href="{{route('shoppingcart.get.xoagiohang')}}">{!! trans('message.clear shopping cart') !!}</a></div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 vendee-clue" @if(!(session()->has('coupon'))) style="padding-left: 307px;" @else style="padding-left: 685px;" @endif>
				{{-- <div class="shipping coupon" style="width: 237px;"></div> --}}
				@if(!(session()->has('coupon')))
				<div class="shipping coupon hidden-sm" style="width: 40%;height: 172px;">
					
					<div class=""><h5>{!! trans('message.discount codes') !!}</h5></div>
					<form action="{{route('coupon.store')}}" method="post">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="text" class="coupon-input" name="coupon">
						<button class="pull-left" type="submit" id="add-coupon">{!! trans('message.apply') !!}</button>
					</form>
					
				</div>
				@endif
				<div class="shipping coupon cart-totals" style="width: 500px;">
					<ul>
						<li class="cartSubT">{!! trans('message.free ship') !!}:    <span>0đ</span></li>
						@if(session()->has('coupon'))
						<li class="cartSubT">{!! trans('message.discount codes') !!} ({{session()->get('coupon')['name']}}):
						<span>- {{number_format(session()->get('coupon')['discount'],0,',','.')}} đ</span></li>
						<form action="{{route('coupon.destroy')}}" method="post" style="display: inline">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							{{method_field('delete')}}
							<button type="submit">{!! trans('message.cancel code') !!}</button>
						</form>
						<li class="cartSubT">{!! trans('message.total') !!}:    <span>{{number_format($newtotal,0,',','.')}} đ</span></li>
						@elseif(!(session()->has('coupon')))
						<li class="cartSubT">{!! trans('message.total') !!}:    <span>{{number_format($total,0,',','.')}} đ</span></li>
						@endif
						
					</ul>
					<div class="col-md-6"><a class="proceedbtn" href="{{route('thanh-toan-nhan-hang')}}" data-toggle="tooltip" data-placement="top" title="Ship COD">{!! trans('message.payment on delivery') !!}</a></div>
					<div class="col-md-6">
					<a class="proceedbtn" href="{{route('thanh-toan-atm')}}" data-toggle="tooltip" data-placement="top" title="ATM">{!! trans('message.pay by ATM') !!}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	@else
		<h4>{!! trans('message.no product') !!}.</h4>
	@endif
</div>
</form>
@stop

@section('script')
<script>
	@if(Session::has('message'))
		var type="{{Session::get('alert-type','info')}}"

		switch(type){
			case 'info':
		         toastr.info("{{ Session::get('message') }}");
		         break;
	        case 'success':
	            toastr.success("{{ Session::get('message') }}");
	            break;
         	case 'warning':
	            toastr.warning("{{ Session::get('message') }}");
	            break;
	        case 'error':
		        toastr.error("{{ Session::get('message') }}");
		        break;
		}
	@endif
</script>
@stop