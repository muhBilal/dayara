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
                                    <th>Nama Customer</th>
                                    <th>Kendaraan Customer</th>
                                    <th>Waktu Order</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($preOrder as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->vehicle }}</td>
                                        <td>{{ $item->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}</td>
                                        <td align="center">
{{--                                            @if($item->status == 'menunggu')--}}
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{ route('admin.preOrder.edit',['id'=>$item->id]) }}"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="mdi mdi-tooltip-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.preOrder.cetak', $item->id) }}"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="mdi mdi-printer"></i>
                                                    </a>
                                                    <form action="{{route('admin.preOrder.destroy', $item->id)}}"
                                                          method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Yakin hapus data?')">
                                                            <i class="mdi mdi-delete-forever"></i>
                                                        </button>
                                                    </form>
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
