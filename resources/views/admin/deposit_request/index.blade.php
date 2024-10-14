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


  .custom-form-group {
    margin-bottom: 20px;
  }

  .custom-form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
  }

  .custom-form-group input,
  .custom-form-group select {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #e1e1e1;
    border-radius: 5px;
    font-size: 16px;
    color: #333;
  }

  .custom-form-group input:focus,
  .custom-form-group select:focus {
    border-color: #d33a9e;
    box-shadow: 0 0 5px rgba(211, 58, 158, 0.5);
  }

  .submit-btn {
    background-color: #d33a9e;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
  }

  .submit-btn:hover {
    background-color: #b8328b;
  }
</style>
@endsection
@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="card-body">
          <h5 class="mb-0">Deposit Requested Lists</h5>
          <form action="{{route('admin.agent.deposit')}}" method="GET">
            <div class="row mt-4">
              <div class="col-lg-2">
                <div class="custom-form-group">
                  <label for="Status">Status</label>
                  <select class="form-control" id="" name="status">
                    <option value="all" {{ request()->get('status') == 'all' ? 'selected' : ''  }}>All
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
              <div class="col-lg-2">
                <div class="custom-form-group">
                  <label for="End Date">PlayerId</label>
                  <input type="text" class="form-control" id="player_id" name="player_id" value="{{request()->player_id}}">
                </div>
              </div>
              <div class="col-lg-2">
                <div class="custom-form-group">
                  <label for="End Date">PaymentType</label>
                  <select name="user_payment_id" id="" class="form-control">
                    <option selected>Select Payment Type</option>
                    @foreach($paymentTypes as $payment)
                    <option value="{{$payment->id}}" {{request()->user_payment_id == $payment->id ? 'selected' : ''}}>{{$payment->paymentType->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="custom-form-group">
                  <label for="Start Date">Start Date</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" value="{{request()->start_date}}">
                </div>
              </div>
              <div class="col-lg-2">
                <div class="custom-form-group">
                  <label for="End Date">End Date</label>
                  <input type="date" class="form-control" id="end_date" name="end_date" value="{{request()->end_date}}">
                </div>
              </div>

              <div class="col-lg-2 mt-4">
                <button type="submit" class="btn bg-gradient-primary btn-sm mb-0">Search</button>
                <a href="{{route('admin.agent.deposit')}}" class="btn bg-gradient-primary btn-sm mb-0">Refresh</a>
              </div>
            </div>

          </form>
        </div>
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