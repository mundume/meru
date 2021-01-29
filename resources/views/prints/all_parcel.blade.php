<!DOCTYPE html>
<html>

<head>
    <title>Parcels Sheet</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            text-align: left;
        }

        th,
        td {
            padding: 5px;
        }

        .size {
            font-size: 12px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="row" style="font-style:sans-serif;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" style="margin-top: -20px;" cellspacing="0">
                        <thead>
                            <th>
                                <h5 class="size">
                                    {{$user->c_name}} | Parcels List
                                </h5>
                                <p class="size">{{$drop->office_name}}</p>
                                <br>
                                <p><small><?php echo date("d-m-Y"); ?></small></p>
                            </th>
                        </thead>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" style="font-size:10px;" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Parcel No</th>
                                <th>Receiver Name</th>
                                <th>Receiver Mobile</th>
                                <th>Description</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parcs as $parc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$parc->parcel_no}}</td>
                                <td>{{$parc->receiver_name}}</td>
                                <td>{{$parc->receiver_mobile}}</td>
                                <td>{{substr($parc->parcel_description, 0, 10)}}...</td>
                                <td>{{$parc->id_no}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>