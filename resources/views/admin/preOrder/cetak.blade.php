<!DOCTYPE html>
<html>
<head>
    <style>
        .cust-table {
            border-collapse: collapse;
            padding-bottom: 1em;
        }
        .default-table {
            width: 100%;
            border-collapse: collapse;
        }

        .default-table th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1 align="Center">Pre Order</h1>
<table class="cust-table">
    <tr>
        <th align="left">Nama Customer</th>
        <th>:</th>
        <th align="left">{{$custInfo['name']}}</th>
    </tr>
    <tr>
        <th align="left">Kendaraan Customer</th>
        <th>:</th>
        <th align="left">{{$custInfo['vehicle']}}</th>
    </tr>
</table>
<table class="default-table">
    <tr>
        <th>Nama Ikan</th>
        <th>Grade Ikan</th>
        <th>Size Ikan</th>
        <th>Jumlah Ikan</th>
        <th>Tanggal dan Waktu</th>
    </tr>
   @foreach($fish as $item)
        <tr>
            <td>{{ $item->fish->name }}</td>
            <td>{{ $item->grade->name }}</td>
            <td>{{ $item->size->name }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->created_at }}</td>
        </tr>
   @endforeach
</table>
<br>
<table class="default-table">
    <tr>
        <th>Rekomendasi Rack</th>
        <th>Nama ikan</th>
        <th>Jumlah Ikan</th>
    </tr>
    @foreach($rackInfo as $item)
        <tr>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['fish_name'] }}</td>
            <td>{{ $item['qty'] }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
