@extends('admin.layout.app')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Stock </h3>
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
                      <h4 class="card-title">Data Stock</h4>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered table-hovered" id="table">
                        <thead>
                          <tr>
                            <th width="5%">No</th>
                            <th>Ikan</th>
                            <th>Grade</th>
                            <th>Size</th>
                            <th>Gudang</th>
                            <th >Qty</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($stocks as $stock)
                            <tr>
                                <td align="center"></td>
                                <td >{{$stock->fish->name}}</td>
                                <td align="center">{{$stock->grade->name}}</td>
                                <td align="center">{{$stock->size->name}}</td>
                                <td align="center">{{$stock->warehouse->name}}, {{$stock->supplier->name}}</td>
                                <td align="center">{{$stock->qty}}</td>
                                
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
