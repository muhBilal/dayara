<!DOCTYPE html>
<html>
<head>
    <style>
        /* Tambahkan style CSS di sini */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>Data Pre Order</h1>
<table>
    <tr>
        <th>Nama Ikan</th>
        <th>Size Ikan</th>
        <th>Grade Ikan</th>
        <th>Jumlah Ikan</th>
        <th>Nama Customer</th>
        <th>Kendaraan</th>
        <th>Tanggal dan Waktu</th>
    </tr>
    <tr>
        <td>{{ $preOrder->fish->name }}</td>
        <td>{{ $preOrder->size->name }}</td>
        <td>{{ $preOrder->grade->name }}</td>
        <td>{{ $preOrder->qty }}</td>
        <td>{{ $preOrder->cust_name }}</td>
        <td>{{ $preOrder->cust_vehicle }}</td>
        <td>{{ $preOrder->created_at }}</td>
    </tr>
</table>
<br>
<table>
    <tr>
        <th>Nama Rak</th>
        <th>Jumlah Ikan</th>
    </tr>
    @foreach($rackInfo as $item)
        <tr>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['qty'] }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
