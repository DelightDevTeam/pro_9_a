@extends('admin_layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">GSC Win/Lose</li>
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
                        {{-- <a href="{{ route('admin.banners.create') }}" class="btn bg-gradient-success btn-sm mb-0">+&nbsp;
                            New Banner</a> --}}
                    </div>
                    <div class="card " style="border-radius: 20px;">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-flush" id="users-search">

                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>AgentName</th>
                                            <th>Total Record</th>
                                            <th>Total Bet</th>
                                            <th>Total Valid Bet</th>
                                            {{-- <th>Total Progressive JP</th> --}}
                                            <th>Total Payout</th>
                                            <th>Total Win/Loss</th>
                                            {{-- <th>Member Commission</th> --}}
                                            <th>Upline Commission</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $report)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.agent_report.detail', $report->product_name) }}"
                                                        style="color: blue;">
                                                        {{ $report->product_name }}
                                                    </a>
                                                </td>
                                                <td style="font-size: 10px">
                                                    {{-- Master: {{ $report->master_user_name }} <br>
                                                Agent:
                                                {{ $report->master_user_name }} --}}
                                                    @
                                                    {{ $report->agent_user_name }}
                                                </td>

                                                <td>{{ $report->total_record }}</td>
                                                <td>{{ $report->total_bet }}</td>
                                                <td>{{ $report->total_valid_bet }}</td>
                                                {{-- <td>{{ $report->total_prog_jp }}</td> --}}
                                                <td>{{ $report->total_payout }}</td>
                                                {{-- <td>{{ $report->total_win_lose }}</td> --}}
                                                <td>
                                                    @if ($report->total_win_lose < 0)
                                                        <span style="color: red;">-{{ abs($report->total_win_lose) }}</span>
                                                    @else
                                                        <span style="color: green;">+{{ $report->total_win_lose }}</span>
                                                    @endif
                                                </td>
                                                {{-- <td>{{ $report->member_comm }}</td> --}}
                                                <td>{{ $report->upline_comm }}</td>
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
