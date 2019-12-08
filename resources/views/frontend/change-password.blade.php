@extends('frontend.master')
@section('title','Thay đổi mật khẩu')
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
						<li class="category3"><span>{!! trans('message.change password') !!}</span></li>
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
							<h2>{!! trans('message.change password') !!}</h2>
							<p class="form-row form-row-wide">
								<label for="username">{!! trans('message.old password') !!} <span class="required">*</span></label>
								<input type="password" class="input-text" name="old_password" value="">
								@if($errors->has('old_password'))
						        <div class="help-block" style="color: red;">
						            *{{$errors->first('old_password')}}
						        </div>
						        @endif
							</p>
							<p class="form-row form-row-wide">
								<label for="reg_password">{!! trans('message.new password') !!} <span class="required">*</span></label>
								<input type="password" class="input-text" name="new_password">
								@if($errors->has('new_password'))
						        <div class="help-block" style="color: red;">
						            *{{$errors->first('new_password')}}
						        </div>
						        @endif
							</p>
							<p class="form-row form-row-wide">
								<label for="reg_password">{!! trans('message.confirm password') !!} <span class="required">*</span></label>
								<input type="password" class="input-text" name="re_password">
								@if($errors->has('re_password'))
						        <div class="help-block" style="color: red;">
						            *{{$errors->first('re_password')}}
						        </div>
						        @endif
							</p>
						</div>
						<div class="form-action">
							<div class="actions-log">
								<input type="submit" class="button" value="{{trans('message.confirm')}}">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop