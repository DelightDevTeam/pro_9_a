<!DOCTYPE html>
<html>
<head>
    <title>Agent Monthly Report</title>
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
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
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
    <section>
    <h1 class="text-center">Win/Lose Report</h1>

    <div class="card">

        <div class="card-body dflex-row">
            <form method="GET" action="{{ route('admin.report.index') }}">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" >

                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">

                <label for="month_year">MemberAccount:</label>
                <input type="text" id="text" name="member_name" value="{{ request('member_name') }}" >

                <button type="submit">Filter</button>
            </form>

        </div>
    </div>
<br>
    <div class="mt-5">
        <table class="mt-5">
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
                    
                    <!-- Win/Loss for Member -->
                    <td class="{{ $report->win_or_lose < 0 ? 'lose' : 'win' }}">
                        {{ number_format($report->win_or_lose, 2) }}
                    </td>
                    <td>0 </td>
                    <td>{{ number_format($report->win_or_lose + $report->total_commission_amount, 2) }}</td> <!-- Member Total -->
                    
                    <td>--</td> <!-- Downline W/L Placeholder -->
                    <td>0</td> <!-- Downline Comm Placeholder -->
                    <td>--</td> <!-- Downline Total Placeholder -->
                    
                    <!-- Win/Loss for Myself -->
                    <td class="{{ $report->win_or_lose < 0 ? 'lose' : 'win' }}">
                        {{ number_format($report->win_or_lose, 2) }}
                    </td>
                    <td>0</td> <!-- Myself Comm -->
                    <td>{{ number_format($report->win_or_lose + $report->total_commission_amount, 2) }}</td> <!-- Myself Total -->
                    
                    <!-- Win/Loss for Upline -->
                    <td class="{{ $report->win_or_lose < 0 ? 'lose' : 'win' }}">
                        {{ number_format($report->win_or_lose, 2) }}
                    </td>
                    <td>0</td> <!-- Upline Comm -->
                    <td>{{ number_format($report->win_or_lose + $report->total_commission_amount, 2) }}</td> <!-- Upline Total -->
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
    </section>
</body>
</html>
