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
{{-- <img src="{{ public_path('shuttle_images/barcode.png') }}" style="height: 50px;width:100%;"> --}}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12" style="font-size: 8px;">
                    Name {{ $parc->receiver_name }} <br>
                    ID Number {{ $parc->id_no }}
                    <center><b>#{{ $parc->parcel_no }}</b></center>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <p style="font-size: 10px;">
                        <b>
                            CLEARED
                        </b>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>