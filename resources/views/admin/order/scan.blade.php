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
                                <h4 class="card-title">Scan Kode Barcode</h4>
                            </div>
                            <div class="col text-right">
                                <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="reader"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            var html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", { fps: 10, qrbox: 500 });
            function onScanSuccess(decodedText, decodedResult) {
                console.log(`Scan result: ${decodedText}`, decodedResult);
                $('#result').val(decodedText);
                let route = decodedText;
                html5QrcodeScanner.clear().then(_ => {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: route,
                        type: 'GET',
                        success: function (response) {
                            if (response.message === 'success') {
                                alert('Berhasil');
                            } else if(response.message === 'duplicate') {
                                alert('Gagal, produk sudah dilakukan scanning!');
                            } else if(response.message === 'limit') {
                                alert('Gagal, stok tidak cukup!');
                            } else {
                                alert('Gagal, produk tidak dapat ditemukan!');
                            }

                            window.location.href = 'http://127.0.0.1:8000/admin/order';
                        }
                    });
                }).catch(error => {
                    alert('something wrong');
                });
            }

            function onScanError(errorMessage) {
                console.log(errorMessage);
            }

            html5QrcodeScanner.render(onScanSuccess, onScanError);
        });
    </script>
@endsection
