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
<h1>Data Pre Order</h1>
<table class="cust-table">
    <tr>
        <th>Kendaraan Customer</th>
        <th>:</th>
        <th>{{$custInfo['name']}}</th>
    </tr>
    <tr>
        <th>Nama Customer</th>
        <th>:</th>
        <th>{{$custInfo['vehicle']}}</th>
    </tr>
</table>
<table class="default-table">
    <tr>
        <th>Nama Ikan</th>
        <th>Size Ikan</th>
        <th>Grade Ikan</th>
        <th>Jumlah Ikan</th>
        <th>Tanggal dan Waktu</th>
    </tr>
   @foreach($fish as $item)
        <tr>
            <td>{{ $item->fish->name }}</td>
            <td>{{ $item->size->name }}</td>
            <td>{{ $item->grade->name }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->created_at }}</td>
        </tr>
   @endforeach
</table>
<br>
<table class="default-table">
    <tr>
        <th>Nama ikan</th>
        <th>Nama Rak</th>
        <th>Jumlah Ikan</th>
    </tr>
    @foreach($rackInfo as $item)
        <tr>
            <td>{{ $item['fish_name'] }}</td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['qty'] }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
