@extends('admin.layout.app')
@section('content')
<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white mr-2">
				<i class="mdi mdi-home"></i>
			</span> Tambah Kedatangan
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
							<h4 class="card-title">Tambah Kedatangan</h4>
						</div>
						<div class="col text-right">
							<a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<form action="{{ route('admin.kedatangan.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleInputUsername1">Tanggal</label>
											<input required type="date" class="form-control" name="date">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleInputUsername1">Urutan Kontainer</label>
											<input required type="number" class="form-control" name="kontainer">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleInputUsername1">Urutan Pallet</label>
											<input required type="number" class="form-control" name="urutan">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleFormControlSelect2">Pilih Gudang</label>
											<select class="form-control" name="warehouse_id" id="exampleFormControlSelect2">
												@foreach($warehouse as $categorie)
													<option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleFormControlSelect2">Pilih Supplier</label>
											<select class="form-control" name="supplier_id" id="exampleFormControlSelect2">
												@foreach($supplier as $categorie)
													<option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleFormControlSelect2">Pilih Ikan</label>
											<select class="form-control" name="fish_id" id="exampleFormControlSelect2">
												@foreach($fish as $ikan)
													<option value="{{ $ikan->id }}">{{ $ikan->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleFormControlSelect2">Pilih Grade</label>
											<select class="form-control" name="grade_id" id="exampleFormControlSelect2">
												@foreach($grade as $categorie)
													<option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleFormControlSelect2">Pilih Size</label>
											<select class="form-control" name="size_id" id="exampleFormControlSelect2">
												@foreach($size as $categorie)
													<option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleInputUsername1">Qty</label>
											<input required type="number" class="form-control" name="qty">
										</div>
									</div>
								</div>
								
								<div class="text-right">
									<button type="submit" class="bg-success btn btn-success text-right">Simpan</button>
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