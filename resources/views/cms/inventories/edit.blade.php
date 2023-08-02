@extends('cms.parent')

@section('title', 'Admin')

@section('main-title', 'Edit Admin')

@section('sub-title', 'Edit Admin')

@section('styles')

@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data of Inventory</h3>
                        </div>
                        <form>
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="location">Location</label>
                                        <select class="form-control" id="location_id" name="location_id">
                                            <option value="">Select location</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}" {{ $inventories->location_id === $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="product">Product</label>
                                        <select class="form-control" id="product_id" name="product_id">
                                            <option value="">Select product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" {{ $inventories->product_id === $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                               value="{{ $inventories->quantity }}" placeholder="Enter stock quantity">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="last_stock_update">Last Stock Update</label>
                                        <input type="datetime-local" class="form-control" id="last_stock_update" name="last_stock_update"
                                               value="{{ date('Y-m-d\TH:i', strtotime($inventories->last_stock_update)) }}" placeholder="Enter last stock update">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" onclick="performUpdate({{ $inventories->id }})" class="btn btn-primary">Update</button>
                                <a href="{{ route('inventories.index') }}" type="button" class="btn btn-info">Return Back</a>
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
        function performUpdate(id) {
            let formData = new FormData();
            formData.append('location_id', document.getElementById('location_id').value);
            formData.append('product_id', document.getElementById('product_id').value);
            formData.append('quantity', document.getElementById('quantity').value);
            formData.append('last_stock_update', document.getElementById('last_stock_update').value);
            storeRoute('/dashboard/update-inventories/' + id, formData);
        }
    </script>
@endsection
