@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> PreOrder </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <span></span>Overview <i
                            class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
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
                                <h4 class="card-title">Edit PreOrder</h4>
                            </div>
                            <div class="col text-right">
                                <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('admin.preOrder.update', $preOrder->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect2">Nama Ikan</label>
                                        <select class="form-control" name="fish_id" id="exampleFormControlSelect2">
                                            @foreach($fish as $item)
                                                <option value="{{ $item->id }}"
                                                        @if($item->id == $preOrder->fish_id ) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect2">Size Ikan</label>
                                        <select class="form-control" name="size_id" id="exampleFormControlSelect2">
                                            @foreach($size as $item)
                                                <option value="{{ $item->id }}"
                                                        @if($item->id == $preOrder->fish_size_id) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect2">Grade Ikan</label>
                                        <select class="form-control" name="grade_id" id="exampleFormControlSelect2">
                                            @foreach($grade as $item)
                                                <option value="{{ $item->id }}"
                                                        @if($item->id == $preOrder-> fish_grade_id) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Jumlah Ikan</label>
                                        <input type="number" class="form-control" name="qty"
                                               value="{{ $preOrder->qty }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Nama Customer</label>
                                        <input type="text" class="form-control" name="name"
                                               value="{{ $preOrder->cust_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Kendaraan</label>
                                        <input type="text" class="form-control" name="vehicle"
                                               value="{{$preOrder->cust_vehicle}}">
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success text-right">Simpan</button>
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
