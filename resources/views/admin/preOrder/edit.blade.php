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
                                                <div class="text-left">
                                                    <button type="button" class="btn btn-danger text-right btnHapus" id="btnDelete_{{ $key + 1 }}">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-left mt-3">
                                        <button type="button" class="btn btn-success text-right" id="btnTambah">
                                            Tambah
                                        </button>
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

@section('js')
    <script>
        $(document).ready(function () {
            // let counter = 0;
            let counter = {{ count($fishOrder) }};
            console.log(counter)

            function addFormSection() {
                counter++;
                let additionalForm = `
            <div id="section_${counter}">
                <div>
                    <div class="border border-left-0 border-right-0 border-bottom-0 p-3"></div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Nama Ikan</label>
                        <select class="form-control" name="fish_id_${counter}" id="exampleFormControlSelect2">
                            @foreach($fish as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Size Ikan</label>
                <select class="form-control" name="size_id_${counter}" id="exampleFormControlSelect2">
                            @foreach($size as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Grade Ikan</label>
                <select class="form-control" name="grade_id_${counter}" id="exampleFormControlSelect2">
                            @foreach($grade as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">Jumlah Ikan</label>
                <input type="number" class="form-control" name="qty_${counter}">
                    </div>
                </div>
                <div class="text-left">
                    <button type="button" class="btn btn-danger text-right btnHapus" id="btnDelete_${counter}">
                        Hapus
                    </button>
                </div>
            </div>
            `;
                $("#additionalForms").append(additionalForm);
            }

            addFormSection();

            function deleteFormSection(btn) {
                const idToDelete = btn.id.split("_")[1];
                const sectionToDelete = $("#section_" + idToDelete);

                // if (counter === 1) {
                //     alert("Tidak bisa menghapus form ini");
                //     return;
                // }

                if (sectionToDelete.length) {
                    sectionToDelete.remove();
                    counter--;
                }
            }

            $(document).on("click", ".btnHapus", function () {
                deleteFormSection(this);
            });

            $("#btnTambah").click(function () {
                addFormSection();
            });

            $("form").submit(function () {
                $("<input>").attr({
                    type: "hidden",
                    name: "counter",
                    value: counter
                }).appendTo($(this));
            });
        });
    </script>
@endsection
