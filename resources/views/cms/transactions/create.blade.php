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
                                        <label for="transaction_type">Transaction Type</label>
                                        <select class="form-control" id="transaction_type" name="transaction_type">
                                            <option value="">Select transaction type</option>
                                            <option value="incoming">Incoming</option>
                                            <option value="outgoing">Outgoing</option>
                                            <option value="incoming_done">Incoming Done</option>
                                            <option value="outgoing_done">Outgoing Done</option>
                                        </select>
                                    </div>
                                </div>

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
                                        <label for="transaction_date">Transaction Date</label>
                                        <input type="datetime-local" class="form-control" id="transaction_date" name="transaction_date" placeholder="Enter transaction date">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="notes" name="notes" placeholder="Enter notes" rows="3"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="button" onclick="performStore()" class="btn btn-primary">Store</button>
                                <a href="{{ route('transactions.index') }}" type="button" class="btn btn-info">Return Back</a>
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
            formData.append('transaction_type', document.getElementById('transaction_type').value);
            formData.append('location_id', document.getElementById('location_id').value);
            formData.append('product_id', document.getElementById('product_id').value);
            formData.append('quantity', document.getElementById('quantity').value);
            formData.append('transaction_date', document.getElementById('transaction_date').value);
            formData.append('notes', document.getElementById('notes').value);


            store('/dashboard/transactions' , formData);
        }

    </script>
@endsection
