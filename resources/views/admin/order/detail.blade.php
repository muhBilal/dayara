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
                        <div class="row">
                            <div class="col-md-12">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hovered" id="table">
                                        <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama Ikan</th>
                                            <th>Size Ikan</th>
                                            <th>Grade Ikan</th>
                                            <th>Jumlah Ikan</th>
                                            <th>Tanggal dan Waktu</th>
                                            <th>Status</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fish as $item)
                                                <input type="hidden" id="itemID" value="{{ $item->id }}">
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->fish->name }}</td>
                                                    <td>{{ $item->size->name }}</td>
                                                    <td>{{ $item->grade->name }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td>{{ $item->status }}</td>
                                                    <td align="center">
                                                        @if($item->status == "menunggu")
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-success text-right" data-bs-toggle="modal" data-bs-target="#generate-modal-{{ $item->id }}">
                                                                    Tampilkan kode QR
                                                                </button>
                                                                <a href="{{ route('admin.order.scan') }}" class="text-white text-decoration-none btn btn-primary text-right">Scan kode</a>
                                                            </div>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="generate-modal-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h3 class="modal-title" id="staticBackdropLabel">Menampilkan kode</h3>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="modal-generator" id="barcode-{{ $item->id }}"></div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
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
        </div>
    </div>

@endsection

@section('js')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('[id^=barcode-]').each(function(index, element) {
                var itemID = $(element).attr('id').split('-')[1];

                new QRCode(document.getElementById(`barcode-${itemID}`), {
                    text: `http://localhost:8000/admin/order/check-order/${itemID}`,
                    width: 256, // Sesuaikan ukuran sesuai kebutuhan
                    height: 256
                });
            });
        });
    </script>
@endsection
