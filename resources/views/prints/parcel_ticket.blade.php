<!DOCTYPE html>
<html>

<head>
    <title>Parcel</title>
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
                                    {{$parc->provider[1]}}
                                </h5>
                                <p><small>{{ $parc->parcel_no }} | <?php echo date("d-m-Y"); ?></small></p>
                            </th>
                        </thead>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table width="100%" style="font-size:6px;" cellspacing="0">
                        <tr>
                            <th>Sender Name</th>
                            <th>Reveiver Name</th>
                            <th>Reciever Mobile</th>
                        </tr>
                        <tr>
                            <td>{{$parc->sender_name}}</td>
                            <td>{{$parc->receiver_name}}</td>
                            <td>{{$parc->receiver_mobile}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <p style="font-size: 10px;">
                        <b>
                            Destination {{@$parc->dropoff->c_name}}
                        </b>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>