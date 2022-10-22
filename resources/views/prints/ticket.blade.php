<!DOCTYPE html>
<html>

<head>
    <title>Meru Artist Coaches Ticket</title>
    <style>
        .logo {
            height: 20px;
            width: 20px;
        }
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
    </style>
</head>

<body>
    <div class="row" style="font-style:sans-serif;">
        <div class="col-md-12">
            <table width="100%" style="margin-top: -20px;">
                <thead>
                    <th align="center">
                        {{-- <img src="{{ asset('avatar.png') }}" class="logo" alt=""> --}}
                        <p style="font-size:12px;">
                            Rider with us, ride with style.
                        </p>
                        <hr>
                    </th>
                </thead>
            </table>
            <table width="100%" style="font-size:8px;">
                <thead>
                    <th align="right">
                        <b>Ticket No: {{$book->ticket_no}} &nbsp;~&nbsp;{{$book->seat_no}}</b>
                    </th>
                </thead>
            </table>
            <table width="100%" style="font-size:8px;" border="1px;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Amount</th>
                        <th>ID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{$book->fullname}}
                        </td>
                        <td>
                            {{$book->mobile}}
                        </td>
                        <td>
                            {{$book->amount}}
                        </td>
                        <td>
                            {{$book->id_no}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table width="100%" style="font-size:8px;" bordber="1px;">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Seaters</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Meru Artist Coaches
                        </td>
                        <td>
                            {{$book->seaters}}
                        </td>
                        <td>
                            {{$book->travel_date}}
                        </td>
                        <td>
                            {{$book->time}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="100%">
                <thead>
                    <th>
                        <b style="font-size:10px;">From: {{$book->departure}} &nbsp;~&nbsp; To:
                            {{$book->destination}}</b>
                        <br>
                        <p style="font-size:8px;">
                            Customers support contacts
                            <br>
                            +254721542489 | booking@meruartists.co.ke
                            <br>
                            visit: meruartists.co.ke.co.ke | P.O BOX 16337-00100 Nairobi, Kenya
                        </p>
                    </th>
                </thead>
            </table>
        </div>
    </div>
</body>

</html>