@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> PO </h3>
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
                                <h4 class="card-title">Data Ikan</h4>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('admin.preOrder.tambah') }}" class="btn btn-primary">Tambah</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hovered" id="table">
                                <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Ikan</th>
                                    <th>Jumlah</th>
                                    <th>Size</th>
                                    <th>Grade</th>
                                    <th>Nama Customer</th>
                                    <th>Kendaraan Customer</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($preOrder as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->fish->name }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{$item->size->name}}</td>
                                        <td>{{$item->grade->name}}</td>
                                        <td>{{ $item->cust_name }}</td>
                                        <td>{{ $item->cust_vehicle }}</td>
                                        <td align="center">
{{--                                            @if($item->status == 'menunggu')--}}
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{ route('admin.preOrder.edit',['id'=>$item->id]) }}"
                                                       target="_blank"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="mdi mdi-tooltip-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.preOrder.cetak', $item->id) }}"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="mdi mdi-printer"></i>
                                                    </a>
                                                    <a href="{{ route('admin.preOrder.delete',['id'=>$item->id]) }}"
                                                       onclick="return confirm('Yakin Hapus data')"
                                                       class="btn btn-danger btn-sm">
                                                        <i class="mdi mdi-delete-forever"></i>
                                                    </a>
                                                </div>
{{--                                            @endif--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
