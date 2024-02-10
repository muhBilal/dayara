@extends('admin.layout.app')
@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white mr-2">
				<i class="mdi mdi-home"></i>
			</span> Tambah Banner
		</h3>
		<nav aria-label="breadcrumb">
			<ul class="breadcrumb">
				<li class="breadcrumb-item active" aria-current="page">
					<span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
				</li>
			</ul>
		</nav>
	</div>
	<div class="row">
		<div class="col-12 grid-margin">
			<div class="card">
				<div class="card-body">
					<div class="row mb-3">
						<div class="col">
							<h4 class="card-title">Tambah Banner</h4>
						</div>
						<div class="col text-right">
							<a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="flex">
									<div class="w-3/4">
										<div class="form-group">
											<label for="exampleInputUsername1">Nama Banner</label>
											<input required type="text" class="form-control" name="name">
										</div>
										<div class="form-group">
											<label for="">Deskripsi</label>
											<textarea name="description" id="" cols="30" rows="10" class="form-control" required>
												</textarea>
										</div>
										<div class="text-right">
											<button type="submit" class="bg-success btn btn-success text-right">Simpan</button>
										</div>
									</div>
									<div class="w-1/4">
										<div class="form-group">
											<label>File upload</label>
											<input required type="file" name="image" class="form-control">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
	tailwind.config = {
		theme: {
			extend: {
				colors: {
					success: '#1bcfb4',
				}
			}
		}
	}
</script>
@endsection