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
                                        <label for="location">location</label>
                                        <select class="form-control" id="location_id" name="location_id">
                                            <option value="">Select location</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="product">product</label>
                                        <select class="form-control" id="product_id" name="product_id">
                                            <option value="">Select product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="quantity"> Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                               placeholder="Enter stock quantity">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="last_stock_update">Last Stock Update</label>
                                        <input type="datetime-local" class="form-control" id="last_stock_update" name="last_stock_update" placeholder="Enter last stock update">
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
            formData.append('location_id', document.getElementById('location_id').value);
            formData.append('product_id', document.getElementById('product_id').value);
            formData.append('quantity', document.getElementById('quantity').value);
            formData.append('last_stock_update', document.getElementById('last_stock_update').value);



            store('/dashboard/inventories' , formData);
        }

    </script>
@endsection
