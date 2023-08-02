@extends('cms.parent')

@section('title', 'Admin')

@section('main-title', 'Create product')

@section('sub-title', 'create product')

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Data of Admin</h3>
                        </div>
                        <form>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="category">Category</label>
                                        <select class="form-control" id="category_id" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name of Product</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="Enter name of Product">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description"
                                                  placeholder="Enter product description" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                               placeholder="Enter product price">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="stock_quantity">Stock Quantity</label>
                                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity"
                                               placeholder="Enter stock quantity">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control-file" id="image" name="image">
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="button" onclick="performStore()" class="btn btn-primary">Store</button>
                                <a href="{{ route('products.index') }}" type="button" class="btn btn-info">Return Back</a>
                            </div>
                            <div class="alert alert-danger" id="error_alert" hidden>
                                <ul id="error_messages_ul"></ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function performStore() {
            let formData = new FormData();
            formData.append('category_id', document.getElementById('category_id').value);
            formData.append('name', document.getElementById('name').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('price', document.getElementById('price').value);
            formData.append('stock_quantity', document.getElementById('stock_quantity').value);
            formData.append('image', document.getElementById('image').files[0]);

            store('/dashboard/products' , formData);
        }

    </script>
@endsection
