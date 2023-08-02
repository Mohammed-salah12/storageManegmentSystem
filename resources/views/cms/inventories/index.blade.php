
@extends('cms.parent')

@section('title' , ' Admin')

@section('main-title' , 'Index Admin')

@section('sub-title' , 'index Admin')

@section('styles')

@endsection

{{-- <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Simple Tables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Simple Tables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section> --}}

    <!-- Main content -->
@section('content')
    <div class="container">
        <h1>Products</h1>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>product</th>
                <th>location</th>
                <th>quantity</th>
                <th>last stock update</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($inventories as $inventory)
                <tr>
                    <td>{{ $inventory->id }}</td>
                    <td>{{ $inventory->product->name }}</td>
                    <td>{{ $inventory->location->name }}</td>
                    <td>{{ $inventory->quantity }}</td>

                    <td>{{ $inventory->last_stock_update }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('inventories.edit', $inventory->id) }}" type="button" class="btn btn-info">
                                <i class="fas fa-edit"></i>
                            </a>

                            @if ($inventory->trashed())
                                <form action="{{ route('inventories.restore', $inventory->id) }}" method="POST" style="display: inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">Restore</button>
                                </form>
                            @else
                                <a href="#" onclick="performDestroy({{ $inventory->id }}, this)" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $inventories->links() }} <!-- Display pagination links -->
    </div>
@endsection

                  <!-- Add the following script at the end of your view -->

                  @section('scripts')
                      <script>
                          function performDestroy(id, reference) {
                              let url = '/dashboard/inventories/' + id;
                              confirmDestroy(url, reference);
                          }

                          function performRestore(id, reference) {
                              let url = '/dashboard/inventories' + id + '/restore';
                              confirmRestore(url, reference);
                          }

                          function confirmDestroy(url, reference) {
                              Swal.fire({
                                  title: 'Are you sure?',
                                  text: 'This action cannot be undone.',
                                  icon: 'warning',
                                  showCancelButton: true,
                                  confirmButtonColor: '#3085d6',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'Yes, delete it!',
                                  cancelButtonText: 'Cancel',
                              }).then((result) => {
                                  if (result.isConfirmed) {
                                      axios.delete(url)
                                          .then(() => {
                                              Swal.fire(
                                                  'Deleted!',
                                                  'Admin has been deleted.',
                                                  'success'
                                              );
                                              $(reference).closest('tr').fadeOut(300, function () {
                                                  $(this).remove();
                                              });
                                          })
                                          .catch(() => {
                                              Swal.fire(
                                                  'Error!',
                                                  'An error occurred.',
                                                  'error'
                                              );
                                          });
                                  }
                              });
                          }

                          function confirmRestore(url, reference) {
                              Swal.fire({
                                  title: 'Are you sure?',
                                  text: 'This action will restore the admin.',
                                  icon: 'warning',
                                  showCancelButton: true,
                                  confirmButtonColor: '#3085d6',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'Yes, restore it!',
                                  cancelButtonText: 'Cancel',
                              }).then((result) => {
                                  if (result.isConfirmed) {
                                      axios.patch(url)
                                          .then(() => {
                                              Swal.fire(
                                                  'Restored!',
                                                  'Admin has been restored.',
                                                  'success'
                                              );
                                              $(reference).closest('tr').fadeOut(300, function () {
                                                  $(this).remove();
                                              });
                                          })
                                          .catch(() => {
                                              Swal.fire(
                                                  'Error!',
                                                  'An error occurred.',
                                                  'error'
                                              );
                                          });
                                  }
                              });
                          }
                      </script>
@endsection
