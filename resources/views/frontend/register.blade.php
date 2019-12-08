@extends('frontend.master')
@section('title','Đăng ký')
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
						<li class="category3"><span>{!! trans('message.register') !!}</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumbs area end -->
<!-- account-details Area Start -->
<div class="customer-login-area">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="customer-register my-account">
					<form method="post" class="register">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="form-fields">
							<div class="col-lg-12">
							    @if(Session::has('success'))
							        <div class="alert alert-{!! Session::get('level') !!}">
							            {!! Session::get('success') !!}
							        </div>
							    @endif
							</div>
							<h2>{!! trans('message.register') !!}</h2>
							<p class="form-row form-row-wide">
								<label for="username">{!! trans('message.name') !!} <span class="required">*</span></label>
								<input type="text" class="input-text" name="name" value="">
								@if($errors->has('name'))
						        <div class="help-block">
						            {{$errors->first('name')}}
						        </div>
						        @endif
							</p>
							<p class="form-row form-row-wide">
								<label for="reg_email">Email <span class="required">*</span></label>
								<input type="email" class="input-text" name="email" value="">
								@if($errors->has('email'))
						        <div class="help-block">
						            {{$errors->first('email')}}
						        </div>
						        @endif
							</p>
							<p class="form-row form-row-wide">
								<label for="reg_password">{!! trans('message.password') !!} <span class="required">*</span></label>
								<input type="password" class="input-text" name="password">
								@if($errors->has('password'))
						        <div class="help-block">
						            {{$errors->first('password')}}
						        </div>
						        @endif
							</p>
							<p class="form-row form-row-wide">
								<label for="reg_password">{!! trans('message.confirm password') !!} <span class="required">*</span></label>
								<input type="password" class="input-text" name="re_password">
								@if($errors->has('re_password'))
						        <div class="help-block">
						            {{$errors->first('re_password')}}
						        </div>
						        @endif
							</p>
							<p class="form-row form-row-wide">
								<label for="username">{!! trans('message.phone') !!} </label>
								<input type="number" class="input-text" name="phone">
							</p>
						</div>
						<div class="form-action">
							<div class="actions-log">
								<input type="submit" class="button" name="register" value="{{trans('message.register')}}">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop