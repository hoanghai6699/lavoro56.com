@extends('frontend.master')
@section('title','Giới thiệu')
@section('content')
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="container-inner">
					<ul>
						<li class="home">
							<a href="{{route('frontend.get.home')}}">{!! trans('message.home') !!}</a>
							<span><i class="fa fa-angle-right"></i></span>
						</li>
						<li class="category3"><span>{!! trans('message.order history') !!}</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="main-contact-area">
	<div class="container">
		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				@if($order->count()>0)
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th style="text-align: center;">{{trans('message.code orders')}}</th>
							<th style="text-align: center;">{{trans('message.order date')}}</th>
							<th style="text-align: center;">{{trans('message.total money')}}</th>
							<th style="text-align: center;">{{trans('message.methods')}}</th>
							<th style="text-align: center;">{{trans('message.payment')}}</th>
							<th style="text-align: center;">{{trans('message.manipulation')}}</th>
						</tr>
					</thead>

					<tbody>
						@foreach($order as $item)
						<tr>
							<td style="text-align: center;">#HD{{$item->id}}-{{$item->created_at->format('dmY')}}</td>
							<td style="text-align: center;">{{$item->created_at->format('d-m-Y H:i:s')}}</td>
							<td style="text-align: center;">{{number_format($item->total,0,',','.')}} VNĐ</td>
							<td style="text-align: center;">
								@if($item->payment_method=='cod')
                                    Ship COD
                                @elseif($item->payment_method=='atm')
                                    ATM
                                @endif
							</td>
							<td style="text-align: center;">{{$item->payment}}</td>
							
							<td style="text-align: center;">
								@if($item->status==3)
									Đã hủy đơn
								@else
								<a class="fa fa-eye fa-fw" data-id="{{$item->id}}" href="{{route('chi-tiet',[$item->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('message.follow')}}"></a>
								@endif
							</td>
							
						</tr>
						@endforeach
					</tbody>

				</table>
				@else
				<h4>Chưa có đơn hàng nào</h4>
				@endif
			</div>
			
		</div>
	</div>	
</div>
@stop