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
<h1 align="center">Surat Jalan</h1>
<table class="cust-table">
    <tr>
        <th align="left">Nama Customer</th>
        <th>:</th>
        <th align="left">{{$order->name}}</th>
    </tr>
    <tr>
        <th align="left">Kendaraan Customer</th>
        <th>:</th>
        <th align="left">{{$order->vehicle}}</th>
    </tr>
    <tr>
        <th align="left">Status</th>
        <th>:</th>
        <th align="left">{{$order->status}}</th>
    </tr>
    <tr>
        <th align="left">Tanggal & Waktu</th>
        <th>:</th>
        <th align="left">{{ $order->created_at->format('d-m-Y|H:i') }}</th>
    </tr>
</table>
<table class="default-table">
    <tr>
        <th>Nama Ikan</th>
        <th>Grade Ikan</th>
        <th>Size Ikan</th>
        <th>Jumlah Ikan</th>
    </tr>
   @foreach($order->detailOrders as $item)
        <tr>
            <td>{{ $item->fish->name }}</td>
            <td>{{ $item->grade->name }}</td>
            <td>{{ $item->size->name }}</td>
            <td>{{ $item->qty }}</td>
        </tr>
   @endforeach
</table>
<br>
</body>
</html>
