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
      <h5 class="mb-0">Game List Dashboards</h5>

     </div>
     <div class="ms-auto my-auto mt-lg-0 mt-4">
      <div class="ms-auto my-auto">
       {{-- <a href="" class="btn bg-gradient-primary btn-sm mb-0 py-2">+&nbsp; Create New
        User</a> --}}
       <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1 " data-type="csv" type="button"
        name="button">Export</button>
      </div>
     </div>
    </div>
   </div>
   <div class="table-responsive">
    @can('admin_access')
    <table class="table table-flush" id="users-search">
    <thead>
    <tr>
        <th class="bg-success text-white">Game Type</th>
        <th class="bg-danger text-white">Product</th>
        <th class="bg-info text-white">Game Name</th>
        <th class="bg-warning text-white">Image</th>
        <th class="bg-warning text-white">Actions</th>
    </tr>
</thead>
<tbody>
    @foreach($games as $game)
        <tr>
            <td>{{ $game->gameType->name ?? 'N/A' }}</td>
            <td>{{ $game->product->name ?? 'N/A' }}</td>
            <td>{{ $game->name }}</td>
            <td>
                <img src="{{ $game->image_url }}" alt="{{ $game->name }}" width="100px">
            </td>
            <td>
                <a href="{{ route('admin.gameLists.edit', $game->id) }}" class="btn btn-info btn-sm">Edit</a>
            </td>
        </tr>
    @endforeach
</tbody>
</table>
@endcan
   </div>
  </div>
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
