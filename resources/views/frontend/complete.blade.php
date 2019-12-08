@extends('frontend.master')
@section('title','Hoàn thành')
@section('content')
<div class="main-contact-area">
	<div class="container wrapper">
        <div id="complete">
			<p class="info">Quý khách đã đặt hàng thành công!</p>
			<p>• Hóa đơn mua hàng của Quý khách đã được gửi vào Email của quý khách có trong phần Thông tin Khách hàng của chúng Tôi</p>
			<p>• Sản phẩm của Quý khách sẽ được chuyển đến Địa chỉ có trong phần Thông tin Khách hàng của chúng Tôi sau thời gian 2 đến 3 ngày, tính từ thời điểm này.</p>
			<p>• Nhân viên giao hàng sẽ liên hệ với Quý khách qua Số Điện thoại trước khi giao hàng 24 tiếng</p>
			<p>• Trụ sở chính: Gia Lâm - Hà Nội</p>
			<p>Cám ơn Quý khách đã sử dụng Sản phẩm của Công ty chúng Tôi!</p>
		</div>
		<p class="text-right return"><a href="{{url('/')}}">Quay lại trang chủ</a></p>
    </div>
</div>
@stop