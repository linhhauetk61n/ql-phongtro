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
							<h5 class="panel-title">Danh sách Review <span class="badge badge-primary">{{$review->count()}}</span></h5>
						</div>

						<div class="panel-body">
							Các <code>review</code> được liệt kê tại đây. <strong>Dữ liệu đang cập nhật.</strong>
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
									
									<th>Tài khoản</th>
									<th>Bài viết</th>
									<th>Nội dung</th>
									<th>Số sao</th>
									<th>Trạng thái</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($review as $review)
								<tr>
									<td>{{$review->id}}</td>
									
									<td>{{$review->taikhoan->name}}</td>
									<td><a href="phongtro/{{$review->tenbaidang->slug}}" target="_blank">{{$review->tenbaidang->title}}</a></td>
									<td>{{$review->review}}</td>
									<td>{{$review->star}}</td>

									<td>
										@if($review->tinhtrang == 1)
											<span class="label label-success">Đã kiểm duyệt</span>
										@elseif($review->tinhtrang == 0)
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
													@if($review->tinhtrang == 1)
														<li><a href="admin/reviews/boduyet/{{$review->id}}"><i class="icon-file-pdf"></i> Bỏ kiểm duyệt</a></li>
													@elseif($review->tinhtrang == 0)
														<li><a href="admin/reviews/duyet/{{$review->id}}"><i class="icon-file-pdf"></i> Kiểm duyệt</a></li>
													@endif
													<li><a href="admin/reviews/del/{{$review->id}}"><i class="icon-file-excel"></i> Xóa</a></li>
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