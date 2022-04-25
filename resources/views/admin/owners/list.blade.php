@extends('admin.layout.master')
@section('content2')
<!-- Main content -->
<div class="content-wrapper">
	<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Danh sách Người cho thuê</h4>
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
							<h5 class="panel-title">Danh sách Người cho thuê <span class="badge badge-primary">{{$owners->count()}}</span></h5>
						</div>

						<div class="panel-body">
							Các <code>Tài khoản</code> được liệt kê tại đây. <strong>Dữ liệu đang cập nhật.</strong>
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
									
									<th>Họ tên</th>
									<th>Địa chỉ</th>
									<th>Số điện thoại</th>
									<th>Số căn cước</th>
									<th>Email</th>
									<th>Trạng thái</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($owners as $owner)
								<tr>
									<td>{{$owner->id}}</td>
									
									<td>{{$owner->fullname}}</td>
									<td>{{$owner->address}}</td>
									<td>{{$owner->phone_number}}</td>
									<td>{{$owner->cmt}}</td>
									<td>{{$owner->email}}</td>

									<td>
										@if($owner->right == 2)
											<span class="label label-success">Đã kiểm duyệt</span>
										@elseif($owner->right == 0)
											<span class="label label-danger">Chờ Phê Duyệt</span>
										@endif
									</td>
									<td class="text-center">
										<ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<ul class="dropdown-menu dropdown-menu-right">
													@if($owner->right == 2)
														<li><a href="admin/owners/unright/{{$owner->id_users}}"><i class="icon-file-pdf"></i> Bỏ kiểm duyệt</a></li>
													@elseif($owner->right == 0)
														<li><a href="admin/owners/right/{{$owner->id_users}}"><i class="icon-file-pdf"></i> Kiểm duyệt</a></li>
													@endif
													<li><a href="admin/owners/del/{{$owner->id_users}}"><i class="icon-file-excel"></i> Xóa</a></li>
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