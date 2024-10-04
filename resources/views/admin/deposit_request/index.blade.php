@extends('admin_layouts.app')
@section('styles')
<style>
  .transparent-btn {
    background: none;
    border: none;
    padding: 0;
    outline: none;
    cursor: pointer;
    box-shadow: none;
    appearance: none;
    /* For some browsers */
  }
</style>
@endsection
@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
              <h5 class="mb-0">Deposit Requested Lists</h5>

          </div>
        </div>
          <form action="{{route('admin.agent.deposit')}}" method="GET">
              <div class="row mt-3">
                  <div class="col-md-3">
                      <div class="input-group input-group-static mb-4">
                          <label for="exampleFormControlSelect1" class="ms-0">Select Status</label>
                          <select class="form-control" id="" name="status">
                              <option value="all" {{ request()->get('status') == 'all' ? 'selected' : ''  }} >All
                              </option>
                              <option value="0" {{ request()->get('status') == '0' ? 'selected' : ''  }}>Pending
                              </option>
                              <option value="1" {{ request()->get('status') == '1' ? 'selected' : ''  }}>Approved
                              </option>
                              <option value="2" {{ request()->get('status') == '2' ? 'selected' : ''  }}>Rejected
                              </option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <button class="btn btn-sm btn-primary" id="search" type="submit">Search</button>
                      <a href="{{route('admin.agent.deposit')}}" class="btn btn-link text-primary ms-auto border-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh">
                          <i class="material-icons text-lg">refresh</i>
                      </a>
                  </div>
              </div>
          </form>

      </div>

        <div class="table-responsive">
    <table class="table table-flush" id="users-search">
      <thead class="thead-light">
        <th>#</th>
        <th>PlayerId</th>
        <th>PlayerName</th>
        <th>Requested Amount</th>
        <th>Payment Method</th>
        <th>Status</th>
        <th>DateTime</th>
        <th>Action</th>
      </thead>
      <tbody>
      @foreach ($deposits as $deposit)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $deposit->user->user_name}}</td>
            <td>{{ $deposit->user->name }}</td>
            <td>{{ number_format($deposit->amount) }}</td>
            <td>{{ $deposit->userPayment->paymentType->name }}</td>
            <td>
                @if ($deposit->status == 0)
                    <span class="badge text-bg-warning text-white mb-2">Pending</span>
                @elseif ($deposit->status == 1)
                    <span class="badge text-bg-success text-white mb-2">Approved</span>
                @elseif ($deposit->status == 2)
                    <span class="badge text-bg-danger text-white mb-2">Rejected</span>
                @endif
            </td>
            <td>{{ $deposit->created_at->setTimezone('Asia/Yangon')->format('d-m-Y H:i:s') }}</td>
            <td>
            <div class="d-flex align-items-center">
            <a href="{{route('admin.agent.depositShow', $deposit->id)}}" class="text-white btn btn-info">Detail</a>
            </div>
</td>
        </tr>
    @endforeach
</tbody>
    </table>
</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('admin_app/assets/js/plugins/datatables.js') }}"></script>
<script>
  if (document.getElementById('users-search')) {
    const dataTableSearch = new simpleDatatables.DataTable("#users-search", {
      searchable: true,
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
