<!DOCTYPE html>
<html>

<head>
    <title>Print Fleet Dispatch</title>
</head>

<body>
    <div class="row" style="font-style:sans-serif;">
        <div class="col-md-12">
            <table width="100%" style="margin-top: -20px;">
                <tbody>
                    <tr>
                        <td>
                            <h5 style="font-size:12px;text-transform:uppercase;">
                                {{$rout->group}} | Commuters List
                            </h5>
                            <p><small><?php echo date("d-m-Y"); ?></small></p>
                            <hr>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="100%" style="font-size:10px;" class="ab">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Seat No</th>
                        <th>Amount</th>
                        <th>Departure</th>
                        <th>Destination</th>
                        <th>Ticket Number</th>
                        <th>ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            {{$book->fullname}}
                        </td>
                        <td>
                            {{$book->phonenumber}}
                        </td>
                        <td>{{$book->seat_no}}</td>
                        <td>
                            {{$book->amount}}
                        </td>
                        <td>{{$book->departure}}</td>
                        <td>{{$book->destination}}</td>
                        <td>{{ $book->ticket_no }}</td>
                        <td>
                            {{$book->id_no}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>