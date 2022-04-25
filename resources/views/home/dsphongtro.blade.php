@extends('layouts.master')
@section('content')
<!-- Main content -->
<div class="content-wrapper" style="margin: 0px 30px;">
	<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Danh sách các phòng trọ</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="admin"><i class="icon-home2 position-left"></i> Trang chủ</a></li>
							<li class="active">Trang Quản Lý</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
	<div class="content">
		<div class="row">
			<div class="col-12">
				<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Danh sách các phòng trọ <span class="badge badge-primary">{{$motelrooms->count()}}</span></h5>
						</div>

						<div class="panel-body">
							Các <code>Phòng trọ</code> được liệt kê tại đây. <strong>Dữ liệu đang cập nhật.</strong>
						</div>
                        @if(session('thongbao'))
                        <div class="alert bg-success">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							<span class="text-semibold">Well done!</span>  {{session('thongbao')}}
						</div>
                        @endif
						<table class="table datatable-show-all">
							<thead>
								<tr class="bg-blue">
									<th>ID</th>
									
									<th>Tiêu đề</th>
									<th>Danh mục</th>
									<th>Giá phòng</th>
									<th>Trạng thái</th>
									<th>Tình trạng phòng</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($motelrooms as $room)
								<tr>
									<td>{{$room->id}}</td>
									
									<td><a href="phongtro/{{$room->slug}}" target="_blank">{{$room->title}}</a></td>
									<td>{{$room->category->name}}</td>
									
									<td>{{$room->price}}</td>
									<td>{{$room->tinhtrangphong}}</td>
									<td>
										@if($room->approve == 1)
											<span class="label label-success">Đã kiểm duyệt</span>
										@elseif($room->tinhtrang == 0)
											<span class="label label-danger">Chờ Phê Duyệt</span>
										@endif
									</td>
									<td class="text-center" style="vertical-align: middle;">
										<ul class="icons-list" style="    margin: 0; padding: 0; list-style: none; line-height: 1; font-size: 0;">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<ul class="dropdown-menu dropdown-menu-right" id="tacvu" style="text-align: left;">
													@if($room->approve == 1)
														@if($room->tinhtrangphong == "Còn phòng")
															<li><a href="user/conphong/{{$room->id}}"><i class="icon-file-pdf"></i>Đã cho thuê</a></li>
														@else
															<li><a href="user/dachothue/{{$room->id}}"><i class="icon-file-pdf"></i>Còn phòng</a></li>
														@endif
													@elseif($room->tinhtrang == 0)
														<li><a href="admin/motelrooms/approve/{{$room->id}}"><i class="icon-file-pdf"></i> Chỉnh sửa</a></li>
														<li><a href="admin/motelrooms/del/{{$room->id}}"><i class="icon-file-excel"></i> Xóa</a></li>
													@endif
																							
												</ul>
											</li>
										</ul>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
			</div>
		</div>
		<!-- Footer -->
		<div class="footer text-muted">
			&copy; 2020.
		</div>
		<!-- /footer -->
	</div>
</div>
@endsection