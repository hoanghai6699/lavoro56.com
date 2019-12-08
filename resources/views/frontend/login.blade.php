@extends('frontend.master')
@section('title','Đăng nhập')
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
						<li class="category3"><span>{!! trans('message.login') !!}</span></li>
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
				<div class="customer-login my-account">

					<form action="" method="post" class="login">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-fields">
								<div class="col-lg-12">
								    @if(Session::has('success'))
								        <div class="alert alert-{!! Session::get('level') !!}">
								            {!! Session::get('success') !!}
								        </div>
								    @endif
								</div>
								<h2>{!! trans('message.login') !!}</h2>
								<p class="form-row form-row-wide">
									<label for="username">Email<span class="required">*</span></label>
									<input type="text" class="input-text" name="email">
									@if($errors->has('email'))
							        <div class="help-block">
							            {{$errors->first('email')}}
							        </div>
							        @endif
								</p>
								<p class="form-row form-row-wide">
									<label for="password">{!! trans('message.password') !!} <span class="required">*</span></label>
									<input class="input-text" type="password" name="password">
									@if($errors->has('password'))
							        <div class="help-block">
							            {{$errors->first('password')}}
							        </div>
							        @endif
								</p>
							</div>
							<div class="form-action">
								<p class="lost_password"> <a href="#">{!! trans('message.forgot password') !!}?</a></p>
								<div class="actions-log">
									<input type="submit" class="button" name="login" value="{!! trans('message.login') !!}">
								</div>
								<label for="rememberme" class="inline"> 
								<input name="rememberme" type="checkbox" id="rememberme" value="forever"> {!! trans('message.remember me') !!} </label>
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop