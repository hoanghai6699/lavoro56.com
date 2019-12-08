@extends('frontend.master')
@section('title','Thông tin thanh toán')
@section('content')
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
						<li class="home">
							<a href="{{route('shoppingcart.get.giohang')}}">{!! trans('message.cart') !!}</a>
							<span><i class="fa fa-angle-right"></i></span>
						</li>
						<li class="category3"><span>{!! trans('message.payment') !!}</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="main-contact-area">
	<div class="container wrapper">
        <div class="row cart-body">
            <form class="form-horizontal" method="post" action="">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
                <!--REVIEW ORDER-->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        {!! trans('message.order confirmation') !!} <div class="pull-right"><small><a class="afix-1" href="{{route('shoppingcart.get.giohang')}}">{!! trans('message.update') !!}</a></small></div>
                    </div>
                    <div class="panel-body">
                    	@foreach($content as $item)
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">
                                <img class="img-responsive" src="{{url('/uploads')}}/{{$item->options->img}}" />
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="col-xs-12">{{$item->name}}</div>
                                <div class="col-xs-12"><small>{!! trans('message.quantity') !!} : <span>{{$item->qty}}</span></small></div>
                                <div class="col-xs-12">
                                    <small>Size : 
                                        <span>
                                            <?php $p = DB::table('sizes')->where('id',$item->options->size)->first();
                                                echo "$p->size";
                                            ?>   
                                        </span>
                                    </small>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-3 text-right">
                                <h6>{{number_format($item->price,0,',','.')}} đ</h6>
                                
                            </div>
                        </div>
                        <div class="form-group"><hr /></div>
						@endforeach
                        <div class="form-group">
                            <div class="col-xs-12">
                                <strong>{!! trans('message.total') !!}: </strong>
                                <div class="pull-right"><span>{{number_format($total,0,',','.')}} đ</span></div>
                            </div>
                            @if(session()->has('coupon'))
                            <div class="col-xs-12">
                                <strong>{!! trans('message.sale') !!}: </strong>
                                <div class="pull-right"><span>- {{number_format(session()->get('coupon')['discount'],0,',','.')}} đ</span></div>
                            </div>
                            <div class="col-xs-12">
                                <strong>{!! trans('message.total') !!} {!! trans('message.after') !!} {!! trans('message.sale') !!}: </strong>
                                <div class="pull-right"><span>{{number_format($newtotal,0,',','.')}} đ</span></div>
                            </div>
                            @endif
                            
                        </div>

                    </div>
                </div>
                <!--REVIEW ORDER END-->
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
            	@if(Auth::check())
                <div class="panel panel-info">
                    <div class="panel-heading">{!! trans('message.billing information') !!}</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12"><strong>{!! trans('message.name') !!}:</strong></div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12"><strong>Email:</strong></div>
                            <div class="col-md-12">
                                <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12"><strong>{!! trans('message.phone') !!}:</strong></div>
                            <div class="col-md-12"><input type="number" name="phone" class="form-control" value="{{Auth::user()->phone}}" readonly/></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12"><strong>{!! trans('message.city') !!}:</strong></div>
                                    <div class="col-md-12">
                                        <select class="form-control" name="city" id="city">
                                            <option value="">Vui lòng chọn thành phố</option>
                                            <?php $city = DB::table('cities')->pluck('city','id'); ?>
                                            @foreach($city as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    @if($errors->has('city'))
                                    <div class="help-block" style="color: red;">
                                        *{{$errors->first('city')}}
                                    </div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12"><strong>{!! trans('message.district') !!}:</strong></div>
                                    <div class="col-md-12">
                                        <select class="form-control" name="district" id="district"></select>
                                    @if($errors->has('district'))
                                    <div class="help-block" style="color: red;">
                                        *{{$errors->first('district')}}
                                    </div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12"><strong>{!! trans('message.address') !!}:</strong></div>
                            <div class="col-md-12"><textarea class="form-control" rows="2" name="address"></textarea>
                            @if($errors->has('address'))
                            <div class="help-block" style="color: red;">
                                *{{$errors->first('address')}}
                            </div>
                            @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12"><strong>{!! trans('message.note') !!}:</strong></div>
                            <div class="col-md-12"><textarea class="form-control" rows="3" name="note"></textarea></div>
                        </div>
                        <div class="form-group pull-right">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-submit-fix">{!! trans('message.confirm') !!}</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function (){
            $('#city').change(function (){
                var city_id = $(this).val();
                if(city_id){
                    $.ajax({
                        url: `{{route('getDistrict')}}?city_id=`+city_id,
                        type: 'GET',
                        dataType: 'json',
                        success:function(data)
                        {
                            if(data){
                                $('#district').empty();
                                $("#district").append('<option value="">Select</option>');
                                $.each(data,function(key,value){
                                    $("#district").append('<option value="'+key+'">'+value+'</option>');
                                });
                            }else{
                                $('#district').empty();
                            }
                        }
                    })
                }else{
                    $("#district").empty();
                }
            })
        })
</script>
@stop