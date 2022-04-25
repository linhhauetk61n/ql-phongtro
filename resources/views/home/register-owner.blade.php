@extends('layouts.master')
@section('content')
<div class="container" style="padding-left: 0px;padding-right: 0px;">
	<div class="gap"></div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">Đăng kí thông tin Người cho thuê</div>
				<div class="panel-body">
					@if ($errors->any())
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					@if(session('success'))
		                        <div class="alert bg-success">
									<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
									<span class="text-semibold">Done!</span>  {{session('success')}}
								</div>
		            @endif
					<form class="form-horizontal" method="POST" action="{{ route('user.register-owner') }}" >
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="control-label col-sm-3" for="fullname">Họ tên:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="txtuser" placeholder="Họ tên Người cho thuê" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="pwd">Số thẻ căn cước:</label>
							<div class="col-sm-9"> 
								<input type="text" class="form-control" name="txtcmt" placeholder="Số thẻ căn cước/ chứng minh thư" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="pwd">Địa chỉ thường trú:</label>
							<div class="col-sm-9"> 
								<input type="text" class="form-control" name="txtadd" placeholder="Địa chỉ thường trú" required="required">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="pwd">Số điện thoại:</label>
							<div class="col-sm-9"> 
								<input type="text" class="form-control" name="txtsdt" placeholder="Số điện thoại" required="required">
							</div>
						</div>
						
						<div class="form-group"> 
							<div class="col-sm-offset-6 col-sm-9">
								<button type="submit" class="btn btn-primary">Đăng kí</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection