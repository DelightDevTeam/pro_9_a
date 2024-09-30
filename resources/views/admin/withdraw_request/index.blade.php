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
                            <h5 class="mb-0">Withdraw Requested Lists</h5>

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-flush" id="users-search">
                        <thead class="thead-light">
                        <th>#</th>
                        <th>PlayerName</th>
                        <th>Requested Amount</th>
                        <th>Payment Method</th>
                        <th>Bank Account Name</th>
                        <th>Bank Account Number</th>
                        <th>Status</th>
                        <th>Created_at</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach ($withdraws as $withdraw)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="d-block">{{ $withdraw->user->name }}</span>
                                </td>
                                <td>{{ number_format($withdraw->amount) }}</td>
                                <td>{{ $withdraw->paymentType->name }}</td>
                                <td>{{$withdraw->account_name}}</td>
                                <td>{{$withdraw->account_no}}</td>
                                <td>
                                    @if ($withdraw->status == 0)
                                        <span class="badge text-bg-warning text-white mb-2">Pending</span>
                                    @elseif ($withdraw->status == 1)
                                        <span class="badge text-bg-success text-white mb-2">Approved</span>
                                    @elseif ($withdraw->status == 2)
                                        <span class="badge text-bg-danger text-white mb-2">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $withdraw->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <form action="{{ route('admin.agent.withdrawStatusUpdate', $withdraw->id) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="amount" value="{{ $withdraw->amount }}">
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="player" value="{{ $withdraw->user_id }}">
                                            @if($withdraw->status == 0)
                                                <button class="btn btn-success p-1 me-1" type="submit">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </form>

                                        <form action="{{ route('admin.agent.withdrawStatusreject', $withdraw->id) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="status" value="2">
                                            @if($withdraw->status == 0)
                                                <button class="btn btn-danger p-1 me-1" type="submit">
                                                    <i class="fas fa-xmark"></i>
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

<script src="{{ asset('admin_app/assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('admin_app/assets/js/plugins/quill.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var errorMessage =  @json(session('error'));
    var successMessage =  @json(session('success'));
   

    @if(session()->has('success'))
    Swal.fire({
      icon: 'success',
      title: successMessage,
      text: '{{ session('
      SuccessRequest ') }}',
      timer: 3000,
      showConfirmButton: false
    });
    @elseif(session()->has('error'))
    Swal.fire({
      icon: 'error',
      title: '',
      text: errorMessage,
      timer: 3000,
      showConfirmButton: false
    });
    @endif
  });
</script>
@endsection