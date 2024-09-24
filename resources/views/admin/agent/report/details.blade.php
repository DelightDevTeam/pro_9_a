@extends('admin_layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">WinLoseDetail</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('admin.agent_report.index') }}"
                            class="btn bg-gradient-success btn-sm mb-0">+&nbsp;
                            Back</a>
                    </div>
                    <div class="card " style="border-radius: 20px;">
                        <div class="card-header">
                            <h3>WinLoseDetail </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-flush" id="users-search">

                                    <thead>
                                        <tr>
                                            <th>Wager ID</th>
                                            <th>Member Name</th>
                                            {{-- <th>Agent Name</th> --}}
                                            <th>Product Name</th>
                                            <th>Game Name</th>
                                            <th>Bet Amount</th>
                                            <th>Valid Bet Amount</th>
                                            <th>Payout</th>
                                            <th>Win/Loss</th>
                                            <th>Settlement Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($details as $detail)
                                            <tr>
                                                {{-- <td>{{ $detail->wager_id }}</td> --}}
                                                <td>
                                                    <a href="https://prodmd.9977997.com/Report/BetDetail?agentCode=E822&WagerID={{ $detail->wager_id }}"
                                                        target="_blank"
                                                        style="color: blueviolet; text-decoration: underline;">{{ $detail->wager_id }}</a>
                                                </td>
                                                <td style="font-size: 10px">
                                                    Agent: {{ $detail->agent_name }} <br>
                                                    Member:
                                                    {{ $detail->agent_name }}
                                                    @
                                                    {{ $detail->member_name }}
                                                </td>

                                                {{-- <td>{{ $detail->agent_name }}</td> --}}
                                                <td>{{ $detail->product_name }}</td>
                                                <td>{{ $detail->game_name }}</td>
                                                <td>{{ $detail->bet_amount }}</td>
                                                <td>{{ $detail->valid_bet_amount }}</td>
                                                <td>{{ $detail->payout }}</td>
                                                <td>{{ $detail->win_loss }}</td>
                                                <td>{{ $detail->settle_match_date }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('admin_app/assets/js/plugins/datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script>
        if (document.getElementById('users-search')) {
            const dataTableSearch = new simpleDatatables.DataTable("#users-search", {
                searchable: false,
                fixedHeight: false,
                perPage: 7
            });

            document.querySelectorAll(".export").forEach(function(el) {
                el.addEventListener("click", function(e) {
                    var type = el.dataset.type;

                    var data = {
                        type: type,
                        filename: "material-" + type,
                    };

                    if (type === "csv") {
                        data.columnDelimiter = "|";
                    }

                    dataTableSearch.export(data);
                });
            });
        };
    </script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
