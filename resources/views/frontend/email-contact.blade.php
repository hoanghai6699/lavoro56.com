<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<section id="typography">      
		<div id="wrap-inner">
			<div id="khach-hang">
				<h3>Thông tin người liên hệ</h3>
				<p>
					<span class="info">Họ tên: </span>
					{{$info['name']}}
				</p>
				<p>
					<span class="info">Email: </span>
					{{$info['email']}}
				</p>
				<p>
					<span class="info">Điện thoại: </span>
					{{$info['phone']}}
				</p>
				<p>
					<span class="info">Địa chỉ: </span>
					{{$info['address']}}
				</p>
				<p>
					<span class="info">Nội dung: </span>
					{{$info['content']}}
				</p>
			</div>						
		</div>
	</section>
</body>
</html>

