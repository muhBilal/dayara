<style>
body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 1cm;
        border: 5px red solid;
        height: 257mm;
        outline: 2cm #FFEAEA solid;
    }
    
    @page {
        size: A7;
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }
table, th, td {
  border: 1px solid black;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
</style>
<h5 style="text-align: center">PT. Dayara Laut Sejahtera</h5>
<table style="width:100%">
	<tbody>
		<tr>
			<td style="height:50px">Kode:<strong><br /> {{ $data->code }} </strong></td>
			<td>Tanggal :<br /> <strong>{{ $data->date }}</strong></td>
		</tr>
		<tr>
			<td style="height:50px">Nama Barang :<br><strong> {{ $data->fish->name }}</strong></td>
			<td>Size | Grade : <br> <strong>{{ $data->size->name }} |  {{ $data->grade->name }}</strong></td>
		</tr>
		<tr>
			<td style="height:50px">Gudang | Supplier :<br> <strong>{{ $data->warehouse->name }} | {{ $data->supplier->name }}</strong></td>
			<td>Jumlah :<br> <strong> {{ $data->qty }}</strong></td>
		</tr>
	</tbody>
</table>
<br/>

<div class="card-body center">
<img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(120)->generate("http://192.168.1.2:8001/admin/kedatangan/cetak/".$data->id)) !!} ">

</div>