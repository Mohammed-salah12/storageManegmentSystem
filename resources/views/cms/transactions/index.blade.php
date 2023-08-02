
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
        <h1>transactions</h1>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>product</th>
                <th>location</th>
                <th>quantity</th>
                <th>transaction status</th>
                <th>transaction date</th>
                <th>notes</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->product->name }}</td>
                    <td>{{ $transaction->location->name }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ $transaction->transaction_date }}</td>
                    <td>{{ $transaction->notes }}</td>

                    <td>
                        <div class="btn-group">
                            <a href="{{ route('transactions.edit', $transaction->id) }}" type="button" class="btn btn-info">
                                <i class="fas fa-edit"></i>
                            </a>

                            @if ($transaction->trashed())
                                <form action="{{ route('transactions.restore', $transaction->id) }}" method="POST" style="display: inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">Restore</button>
                                </form>
                            @else
                                <a href="#" onclick="performDestroy({{ $transaction->id }}, this)" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $transactions->links() }} <!-- Display pagination links -->
    </div>
@endsection

                  <!-- Add the following script at the end of your view -->

                  @section('scripts')
                      <script>
                          function performDestroy(id, reference) {
                              let url = '/dashboard/transactions/' + id;
                              confirmDestroy(url, reference);
                          }

                          function performRestore(id, reference) {
                              let url = '/dashboard/transactions' + id + '/restore';
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
