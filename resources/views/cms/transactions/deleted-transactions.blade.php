@extends('cms.parent')

@section('title', 'Deleted Admins')

@section('main-title', 'Deleted Admins')

@section('sub-title', 'Deleted Admins')

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Deleted transaction</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>product</th>
                                    <th>location</th>
                                    <th>quantity</th>
                                    <th>transaction status</th>
                                    <th>transaction date</th>
                                    <th>notes</th>
                                    <th>deleted_at</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($deletedTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>{{ $transaction->product->name }}</td>
                                        <td>{{ $transaction->location->name }}</td>
                                        <td>{{ $transaction->quantity }}</td>
                                        <td>{{ $transaction->transaction_type }}</td>
                                        <td>{{ $transaction->transaction_date }}</td>
                                        <td>{{ $transaction->notes }}</td>
                                        <td>{{ $transaction->deleted_at }}</td>

                                        <td>
                                            <div class="btn-group">
                                                <form action="{{ route('transactions.restore', $transaction->id) }}" method="POST"
                                                      style="display: inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success">Restore</button>
                                                </form>
                                                <form action="{{ route('transactions.forceDelete', $transaction->id) }}"
                                                      method="POST" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Force Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script>
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

        function confirmForceDelete(url, reference) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will permanently delete the admin.',
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
                                'Admin has been permanently deleted.',
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
