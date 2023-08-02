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
                            <h3 class="card-title">Edit Data of Transaction</h3>
                        </div>
                        <form>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="transaction_type">Transaction Type</label>
                                        <select class="form-control" id="transaction_type" name="transaction_type">
                                            <option value="">Select transaction type</option>
                                            <option value="incoming" {{ $transactions->transaction_type === 'incoming' ? 'selected' : '' }}>Incoming</option>
                                            <option value="outgoing" {{ $transactions->transaction_type === 'outgoing' ? 'selected' : '' }}>Outgoing</option>
                                            <option value="incoming_done" {{ $transactions->transaction_type === 'incoming_done' ? 'selected' : '' }}>Incoming Done</option>
                                            <option value="outgoing_done" {{ $transactions->transaction_type === 'outgoing_done' ? 'selected' : '' }}>Outgoing Done</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="location">Location</label>
                                        <select class="form-control" id="location_id" name="location_id">
                                            <option value="">Select location</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}" {{ $transactions->location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
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
                                                <option value="{{ $product->id }}" {{ $transactions->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $transactions->quantity }}" placeholder="Enter stock quantity">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="transaction_date">Transaction Date</label>
                                        <input type="datetime-local" class="form-control" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d\TH:i', strtotime($transactions->transaction_date)) }}" placeholder="Enter transaction date">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ $transactions->notes }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="button" onclick="performUpdate({{ $transactions->id }})" class="btn btn-primary">Update</button>
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
        function performUpdate(id) {
            let formData = new FormData();
            formData.append('transaction_type', document.getElementById('transaction_type').value);
            formData.append('location_id', document.getElementById('location_id').value);
            formData.append('product_id', document.getElementById('product_id').value);
            formData.append('quantity', document.getElementById('quantity').value);
            formData.append('transaction_date', document.getElementById('transaction_date').value);
            formData.append('notes', document.getElementById('notes').value);

            storeRoute('/dashboard/update-transactions/' + id, formData);
        }
    </script>
@endsection
