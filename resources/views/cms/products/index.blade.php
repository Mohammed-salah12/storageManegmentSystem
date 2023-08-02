
@extends('cms.parent')

@section('title' , ' Admin')

@section('main-title' , 'Index Admin')

@section('sub-title' , 'index Admin')

@section('styles')

@endsection

    <!-- Main content -->
@section('content')
    <div class="container">
        <h1>Products</h1>
        <div class="mb-3">
            <label for="category">Sort by Category:</label>
            <select id="category" name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if(session('selected_category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>name</th>
                <th>Description</th>
                <th>price</th>
                <th>stock_quantity</th>
                <th>category</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if ($product->image)
                            <img class="img-circle img-bordered-sm" src="{{asset('storage/images/products/'.$product->image)}}" width="60" height="60" alt="User Image">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>{{ $product->category->name }}</td>


                    <td>
                        <div class="btn-group">
                            <a href="{{ route('products.edit', $product->id) }}" type="button" class="btn btn-info">
                                <i class="fas fa-edit"></i>
                            </a>

                            @if ($product->trashed())
                                <form action="{{ route('products.restore', $product->id) }}" method="POST" style="display: inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">Restore</button>
                                </form>
                            @else
                                <a href="#" onclick="performDestroy({{ $product->id }}, this)" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $products->links() }} <!-- Display pagination links -->
    </div>
@endsection

                  <!-- Add the following script at the end of your view -->

                  @section('scripts')
                      <script>
                          document.getElementById('category').addEventListener('change', function () {
                              const categoryId = this.value;
                              console.log(categoryId); // Debugging: Check if categoryId is being correctly retrieved
                              const baseUrl = '/dashboard/products'; // Adjust this based on your route
                              const url = categoryId ? `${baseUrl}?category_id=${categoryId}` : baseUrl;
                              console.log(url); // Debugging: Check if the URL is being generated correctly
                              window.location.href = url;
                          });

                          function performDestroy(id, reference) {
                              let url = '/dashboard/products/' + id;
                              confirmDestroy(url, reference);
                          }

                          function performRestore(id, reference) {
                              let url = '/dashboard/products' + id + '/restore';
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
