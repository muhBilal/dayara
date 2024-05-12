@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Kedatangan </h3>
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
                                <h4 class="card-title">Data Kedatangan belum mendapat rack</h4>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('admin.kedatangan.tambah') }}" class="btn btn-primary">Tambah</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hovered" id="table">
                                <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal</th>
                                    <th>Ikan</th>
                                    <th>Grade</th>
                                    <th>Size</th>
                                    <th>Gudang</th>
                                    <th>Qty</th>
                                    <th>Urutan</th>
                                    <th>Kode</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($kedatangan as $data)
                                    <tr>
                                        <td align="center"></td>
                                        <td>{{ $data->date,"dmY" }}</td>
                                        <td>{{ $data->fish->name }}</td>
                                        <td>{{ $data->grade->name }}</td>
                                        <td>{{ $data->size->name }}</td>
                                        <td>{{ $data->warehouse->name }}/{{ $data->supplier->name }}</td>
                                        <td>{{ $data->qty }}</td>
                                        <td>{{ $data->kontainer }}/{{ $data->urutan }}</td>
                                        <td>{{ $data->code }}</td>
                                        <td align="center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('admin.kedatangan.edit',['id'=>$data->id]) }}"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="mdi mdi-tooltip-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.kedatangan.cetak',['id'=>$data->id]) }}"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="mdi mdi-printer"></i>
                                                </a>
                                                <form method="post"
                                                      action="{{ route('admin.kedatangan.destroy',['id'=>$data->id]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')">
                                                        <i class="mdi mdi-delete-forever"></i>
                                                    </button>
                                                </form>
                                            </div>
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
