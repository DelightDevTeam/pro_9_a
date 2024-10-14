<!DOCTYPE html>
<html>

<head>
    <title>Win/Lose Monthly Report</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script
        src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .summary {
            background-color: #ffffe0;
            font-weight: bold;
        }

        .qty {
            text-align: left;
        }

        .win {
            color: green;
        }

        .lose {
            color: red;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <h1 class="text-center">Win/Lose Report</h1>

        <div class="">

            <div class="card-body dflex-row">
                <form method="GET" action="{{ route('admin.report.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="form-control">

                        </div>
                        <div class="col-md-2">
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="form-control">

                        </div>
                        <div class="col-md-2">
                            <label for="month_year">MemberAccount:</label>
                            <input type="text" id="text" name="member_name" value="{{ request('member_name') }}" class="form-control">

                        </div>
                        <div class="col-md-2">
                            <label for="month_year">Provider Type:</label>
                            <select name="product_code" id="" class="form-control">
                                @foreach($providers as $provider)
                                <option value="{{$provider->code}}">{{$provider->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-success mt-4">Filter</button>
                            <a href="{{route('admin.report.index')}}" class="btn btn-primary mt-4">refresh</a>
                        </div>
                </form>

            </div>
        </div>
        <br>
        <div class="mt-5">
            <table class="mt-5 table-responsive">
                <thead>
                    <tr>
                        <th rowspan="2">Account</th>
                        <th rowspan="2">Name</th>
                        <th rowspan="2">Bet Amount</th>
                        <th rowspan="2">Valid Amount</th>
                        <th rowspan="2">Stake Count</th>
                        <th rowspan="2">Gross Comm</th>
                        <th colspan="3">Member</th>
                        <th colspan="3">Detail</th>
                    </tr>
                    <tr>
                        <th>W/L</th>
                        <th>Comm</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agentReports as $report)
                    <tr>
                        <td>{{ $report->user_name }}</td>
                        <td>{{ $report->member_name }}</td>
                        <td>{{ number_format($report->total_bet_amount, 2) }}</td>
                        <td>{{ number_format($report->total_valid_bet_amount, 2) }}</td>
                        <td>{{ $report->stake_count }}</td> <!-- Placeholder for stake count -->
                        <td>0</td>

                        <td class="{{ $report->win_or_lose < 0 ? 'lose' : 'win' }}">
                            {{ number_format($report->win_or_lose, 2) }}
                        </td>
                        <td>0 </td>
                        <td>{{ number_format($report->win_or_lose + $report->total_commission_amount, 2) }}</td>


                        <td>
                            <a href="{{ route('admin.report.detail', $report->user_name) }}" class="btn btn-info">
                                View Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>