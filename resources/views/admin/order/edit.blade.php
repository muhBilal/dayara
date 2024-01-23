@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Barang Keluar </h3>
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
                                <h4 class="card-title">Detail Barang Keluar</h4>
                            </div>
                            <div class="col text-right">
                                <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                        <input type="hidden" id="preOrderId" value="{{ $preOrder->id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('admin.preOrder.update', $preOrder->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Nama Customer</label>
                                        <input type="text" class="form-control" name="name"
                                               value="{{ $preOrder->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Kendaraan</label>
                                        <input type="text" class="form-control" name="vehicle"
                                               value="{{$preOrder->vehicle}}">
                                    </div>

{{--                                    <div id="additionalForms"></div>--}}
                                    <div id="additionalForms">
                                        @foreach($fishOrder as $key => $order)
                                            <div id="section_{{ $key + 1 }}">
                                                <div>
                                                    <div class="border border-left-0 border-right-0 border-bottom-0 p-3"></div>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect2">Nama Ikan</label>
                                                        <select class="form-control" name="fish_id_{{ $key + 1 }}" id="exampleFormControlSelect2">
                                                            @foreach($fish as $item)
                                                                <option value="{{ $item->id }}" {{ $order->fish_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect2">Size Ikan</label>
                                                        <select class="form-control" name="size_id_{{ $key + 1 }}" id="exampleFormControlSelect2">
                                                            @foreach($size as $item)
                                                                <option value="{{ $item->id }}" {{ $order->size_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect2">Grade Ikan</label>
                                                        <select class="form-control" name="grade_id_{{ $key + 1 }}" id="exampleFormControlSelect2">
                                                            @foreach($grade as $item)
                                                                <option value="{{ $item->id }}" {{ $order->grade_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputUsername1">Jumlah Ikan</label>
                                                        <input type="number" class="form-control" name="qty_{{ $key + 1 }}" value="{{ $order->qty }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-right">
                                        <button type="button" class="btn btn-success text-right" data-bs-toggle="modal" data-bs-target="#generate-modal">
                                            Tampilkan kode QR
                                        </button>
                                        <a href="{{ route('admin.order.scan') }}" class="text-white text-decoration-none btn btn-primary text-right">Scan kode</a>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="generate-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="staticBackdropLabel">Menampilkan kode</h3>
                                                </div>
                                                <div class="modal-body">
                                                <div class="d-flex justify-content-center" id="generator"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
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
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var preOrderId = $('#preOrderId').val();
            new QRCode(document.getElementById("generator"), `http://localhost:8000/admin/order/check-order/${preOrderId}`);
        });
    </script>
@endsection
