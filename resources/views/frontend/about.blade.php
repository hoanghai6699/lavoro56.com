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
						<li class="category3"><span>{!! trans('message.about') !!}</span></li>
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
				<h4>LAVORO giới thiệu<br></h4>
				<div>
					Giầy dép là một trong những phụ kiện không thể thiếu góp phần tạo nên phong cách thời trang của mỗi người. Chính vì điều đó LAVORO mong muốn đem đến những mẫu giầy mới nhất được cập nhật thường xuyên giúp các bạn dễ dàng hơn trong việc lựa chọn và cập nhật những style thịnh hành của thời trang giầy dép trong nước và thế giới.<br>
				</div>
				<div>
					LAVORO được biết đến với những sản phẩm giầy dép hợp thời trang, nhập trực tiếp từ những công ty giầy dép uy tín, cao cấp mà không qua trung gian, đảm bảo về chất lượng và giá thành … LAVORO cung cấp mọi kiểu dáng giầy dép mới nhất: Converse, Vans, Palladium ….Nếu là một người yêu thời trang, tìm kiếm những phong cách mới, thì bạn không thể bỏ qua những xu hướng nổi bật của thời trang.Thật dễ dàng, chỉ với một click bạn có thể nhanh chóng sở hữu chúng trong tủ đồ của mình với LAVORO.<br>
				</div>
				<img src="{{url('/frontend/img/about1.jpg')}}" style="padding: 19px 194px 17px 216px;">
				<div>
					LAVORO cam kết:<br>
					- Hàng thật giống 100% ảnh chụp về kiểu dáng, mẫu mã.<br>

					- Mẫu mới cập nhật liên tục.<br>

					- Sản phẩm chất lượng<br>

					- Giá thành phải chăng<br>

					- Phương thức vận chuyển thuận tiện. ( Ship hàng toàn quốc, nhận chuyển hàng COD )<br>

					- Hàng luôn có sẵn trong kho.<br>

					- Bán hàng nhiệt tình tư vấn
				</div>
				
			</div>
			
		</div>
	</div>	
</div>
@stop