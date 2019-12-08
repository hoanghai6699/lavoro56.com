@extends('frontend.master')
@section('title','Chi tiết tin tức')
@section('content')
<style>
	.article_info img,em {
		margin: 0 auto;
		text-align: center;
		display: block;
		max-width: 100%;
	}
</style>
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
						<li class="home">
							<a href="{{route('tin-tuc')}}">{!! trans('message.news') !!}</a>
							<span><i class="fa fa-angle-right"></i></span>
						</li>
						<li class="category3"><span>{{$article->name}}</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="main-contact-area">
	<div class="container">
		<div class="row">
			<div class="col-sm-3" style="position: sticky;top: 90px;">
				<div class="new-sidebar">
			        <h3 class="title-sidebar">
			            {{trans('message.news')}} {{trans('message.featured')}}
			        </h3>
			        <?php $ah = DB::table('articles')->where('hot','=',1)->get(); ?>
			        @foreach($ah as $it)
	    			<div class="nav-new-sidebar">
			            <div class="item">
				    		<div class="images">
				        		<a href="{{route('chi-tiet-tin-tuc',[$it->id,$it->slug])}}" title="{{$it->name}}"><img src="{{url('uploads/article')}}/{{$it->image}}" style="object-fit: cover;height: 77px;width: 85px;" alt=""></a>
				    		</div>
			    		<div class="title2">
			        		<h5 class="title"><a href="{{route('chi-tiet-tin-tuc',[$it->id,$it->slug])}}" data-toggle="tooltip" data-placement="top" title="{{$it->name}}">{{$it->name}}</a></h5>
			    		</div>
			    		<div class="clearfix"></div>
			    			<p class="desc">{{$it->description}}</p>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
				@if(isset($article))
				
				<div class="article" style="display: flex;padding-bottom: 10px;margin-bottom: 10px;">
					<div class="article_info" style="margin-left: 20px;">
						<h2 style="font-size: 20px;"><a href="">{{$article->name}}</a></h2>
						<p><i class="fa fa-calendar"></i> {{$article->created_at->format('d-m-Y')}}</p>
						<p style="font-size: 13px">{!!$article->content!!}</p>
					</div>
				</div>
				
				@endif
			</div>
		</div>
	</div>	
</div>
@stop

<style type="text/css">
.new-sidebar {
    background: #ffffff;
    border: 1px solid #dddddd;
    margin-bottom: 20px;
}

.new-sidebar .title-sidebar {
    padding: 10px;
    color: #e63935;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 16px;
    position: relative;
    margin-bottom: 0;
    margin-top: 7px;
}

.new-sidebar .title-sidebar:before {
    content: '';
    position: absolute;
    background: #e63935;
    width: 130px;
    height: 3px;
    top: 34px;
    left: 14px;
}

.nav-new-sidebar {
}

.nav-new-sidebar .item {
    padding: 15px;
    border-bottom: 1px solid #ddd;
}

.nav-new-sidebar .item .images {
    width: 40%;
    display: inline-block;
    float: left;
}
</style>