<!DOCTYPE html>
<html lang="en">
<head>
	<title>Quản lý Phòng Trọ</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<base href="{{asset('')}}">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/style.css">
	<link rel="stylesheet" href="assets/awesome/css/fontawesome-all.css">
	<link rel="stylesheet" href="assets/toast/toastr.min.css">
	<script src="assets/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/myjs.js"></script>
	<script src="assets/vote.js"></script>
	<link rel="stylesheet" href="assets/selectize.default.css" data-theme="default">
	<script src="assets/js/fileinput/fileinput.js" type="text/javascript"></script>
	<script src="assets/js/fileinput/vi.js" type="text/javascript"></script>
	<link rel="stylesheet" href="assets/fileinput.css">
	<script src="assets/pgwslider/pgwslider.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="assets/pgwslider/pgwslider.min.css">
	<link href="adminassets/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">

	<style type="text/css">
	.icons-list > li > a {
		color: inherit;
		display: block;
		opacity: 1;
	}
	.dropdown-menu {
		min-width: 180px;
		padding: 7px 0;
		color: #333333;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
	}
	#tacvu li{
		height: 36px;

	}
	#tacvu li i { margin-right: 12px;  }
	.animated {
		-webkit-transition: height 0.2s;
		-moz-transition: height 0.2s;
		transition: height 0.2s;
	}

	.stars
	{
		margin: 20px 0;
		font-size: 24px;
		color: #d17581;
	}
</style>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
	This must be loaded before fileinput.min.js -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/sortable.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/purify.min.js" type="text/javascript"></script> -->
	<link rel="stylesheet" href="assets/bootstrap/bootstrap-select.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="assets/bootstrap/bootstrap-select.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				</button>
				<a class="navbar-brand" href=""><img src="images/logo.png" class="logo"></a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					@foreach($categories as $category)
					<li><a href="category/{{$category->id}}">{{ $category->name }}</a></li>
					@endforeach
				</ul>
				@if(Auth::user())
				<ul class="nav navbar-nav navbar-right thongbao ">
					<li><a class="btn-dangtin" href="user/dangtin"><i class="fas fa-edit"></i> Đăng tin ngay</a></li>
					<li class="dropdown ">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="getthongbao()">Thông báo</a>
						<script>
							function getthongbao() {
								if ($('ul.thongbao li').hasClass('open') == true) {
							  	//redirect('user/notifi/{{Auth::user()->id}}');
							  	window.location='user/notifi/{{Auth::user()->id}}';
							  }
							}
						</script>
						<ul class="dropdown-menu">
							<?php $i=0; ?>
							@foreach($notification as $notifi)
							@if( $notifi->id_users ==  Auth::user()->id && $notifi->status == 0)
							<li>{{$notifi->notification}}</li>
							<?php $i +=1; ?>
							@endif	
							@endforeach
							
						</ul>
						@if($i > 0)
						<span style="position: absolute;top: 0px;right: 0px; color: red; font-size: 16px;">{{$i}}</span>
						@endif
					</li>	
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Xin chào! {{Auth::user()->name}} <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="user/profile">Thông tin chi tiết</a></li>	
							@if( Auth::user()->right != 0)
							<li><a href="user/dsphongtro">Danh sách phòng trọ</a></li>
							@else
							<li><a href="user/dsyeuthich">Danh sách yêu thích</a></li>
							@endif
							<li><a href="user/dangtin">Đăng tin</a></li>
							<li><a href="user/logout">Thoát</a></li>
						</ul>
					</li>
					
					
				</ul>
				
				@else
				<ul class="nav navbar-nav navbar-right">
					<li><a class="btn-dangtin" href="user/dangtin"><i class="fas fa-edit"></i> Đăng tin ngay</a></li>
					<li><a href="user/login"><i class="fas fa-user-circle"></i> Đăng Nhập</a></li>
					<li><a href="user/register"><i class="fas fa-sign-in-alt"></i> Đăng Kí</a></li>
				</ul>
				@endif
			</div>
		</div>
	</nav>
	
	@yield('content')
	<div class="gap"></div>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="logo-footer">
						<a href="/" title="Cổng thông tin số 1 về Dự án Bất động sản - Homedy.com">
							<img src="images/logo.png">                        
						</a>
						<div style="padding-top: 10px;">
							<p>Dự án phát triển Website Đăng tin và Tìm kiếm Phòng trọ.</p>
							<p>Sinh viên thực hiện:</p>
							<p>Hà Ngọc Linh - Ngô Thị Hiền - Nguyễn Minh Hiền</p>
							
						</div>
					</div>
				</div>
			</div>
		</div>

	</footer>
	
	<script type="text/javascript" src="assets/toast/toastr.min.js"></script>
</body>
</html>
