@extends('frontend.master')
@section('title','Liên hệ')
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
						<li class="category3"><span>{!! trans('message.contact') !!}</span></li>
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
				<div class="contact-us-area">
					<div class="google-map-area">
						<div id="contacts" class="map-area">
							<div class="map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.6971156731092!2d105.9307250142449!3d21.00477499397414!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135a8d22485051d%3A0x5cb2530a1a6b6c0!2zxJDhuqFpIEjhu41jIE7DtG5nIE5naGnhu4dw!5e0!3m2!1svi!2s!4v1565660590518!5m2!1svi!2s" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe></div>
						</div>

					</div>
					<!-- google-map-area end -->
					<!-- contact us form start -->

					
					<div class="contact-us-form">
						<div class="sec-heading-area">
							<h2>{!! trans('message.contact') !!}</h2>
						</div>
						<div class="contact-form">
							@if(Auth::check())
							<span class="legend">{!! trans('message.contact person information') !!}</span>
							<form action="" method="post">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="form-top">
									<div class="form-group col-sm-12 col-md-12 col-lg-12">
										<label>{!! trans('message.name') !!} <sup>*</sup></label>
										<input type="text" name="name" class="form-control" value="{{Auth::user()->name}}">
										@if($errors->has('name'))
	                                    <div class="help-block">
	                                        {{$errors->first('name')}}
	                                    </div>
	                                    @endif
									</div>
									<div class="form-group col-sm-6 col-md-6 col-lg-6">
										<label>Email <sup>*</sup></label>
										<input type="email" name="email" class="form-control" value="{{Auth::user()->email}}">
										@if($errors->has('email'))
	                                    <div class="help-block">
	                                        {{$errors->first('email')}}
	                                    </div>
	                                    @endif
									</div>									
									<div class="form-group col-sm-6 col-md-6 col-lg-6">
										<label>{!! trans('message.phone') !!} <sup>*</sup></label>
										<input type="number" name="phone" class="form-control" value="{{Auth::user()->phone}}">
										@if($errors->has('phone'))
	                                    <div class="help-block">
	                                        {{$errors->first('phone')}}
	                                    </div>
	                                    @endif
									</div>
									<div class="form-group col-sm-12 col-md-12 col-lg-12">
										<label>{!! trans('message.address') !!} <sup>*</sup></label>
										<input type="text" name="address" class="form-control">
										@if($errors->has('address'))
	                                    <div class="help-block">
	                                        {{$errors->first('address')}}
	                                    </div>
	                                    @endif
									</div>	
									<div class="form-group col-sm-12 col-md-12 col-lg-12">
										<label>{!! trans('message.content') !!} <sup>*</sup></label>
										<textarea class="yourmessage" name="content"></textarea>
										@if($errors->has('content'))
	                                    <div class="help-block">
	                                        {{$errors->first('content')}}
	                                    </div>
	                                    @endif
									</div>
									<button type="submit" class="btn btn-default pull-right">{!! trans('message.submit') !!}</button>
								</div>
								
							</form>
							@endif
						</div>
					</div>
					<!-- contact us form end -->
				</div>					
			</div>
		</div>
	</div>	
</div>
@stop