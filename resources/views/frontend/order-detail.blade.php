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
						<li class="home">
							<a href="{{route('don-hang')}}">{!! trans('message.order history') !!}</a>
							<span><i class="fa fa-angle-right"></i></span>
						</li>
						<li class="category3"><span>{!! trans('message.follow') !!} {!! trans('message.order') !!}</span></li>
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
				@foreach($order as $item)
				<ol class="progtrckr" data-progtrckr-steps="3">
				    <li @if($item->status==2 || $item->status==1 || $item->status==0) class="progtrckr-done" @else class="progtrckr-todo" @endif>Đang xử lý</li>
					<li @if($item->status==2 || $item->status==1) class="progtrckr-done" @else class="progtrckr-todo" @endif>Đang giao hàng</li>
					<li @if($item->status==2) class="progtrckr-done" @else class="progtrckr-todo" @endif>Đã nhận hàng</li>
				</ol>
				@endforeach
			</div>
		</div>
	</div>	
</div>

<style type="text/css">
	ol.progtrckr {
    margin: 0;
    padding: 0;
    list-style-type none;
}

ol.progtrckr li {
    display: inline-block;
    text-align: center;
    line-height: 3.5em;
}

ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }

ol.progtrckr li.progtrckr-done {
    color: black;
    border-bottom: 4px solid yellowgreen;
}
ol.progtrckr li.progtrckr-todo {
    color: silver; 
    border-bottom: 4px solid silver;
}

ol.progtrckr li:after {
    content: "\00a0\00a0";
}
ol.progtrckr li:before {
    position: relative;
    bottom: -2.5em;
    float: left;
    left: 50%;
    line-height: 1em;
}
ol.progtrckr li.progtrckr-done:before {
    content: "\2713";
    color: white;
    background-color: yellowgreen;
    height: 2.2em;
    width: 2.2em;
    line-height: 2.2em;
    border: none;
    border-radius: 2.2em;
}
ol.progtrckr li.progtrckr-todo:before {
    content: "\039F";
    color: silver;
    background-color: white;
    font-size: 2.2em;
    bottom: -1.2em;
}
</style>
@stop

