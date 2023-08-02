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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data of Admin</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>

                            <div class="card-body">
                                <div class="row">

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="name">name of Admin</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ $categories->name ?? "" }}" placeholder="Enter name of Admin">
                                        </div>


                                        <!-- No need to display password field, as it is not updated -->
                                        <!-- ... -->

                                    </div>

                                    <!-- ... -->
                                    <form>
                                    <div class="card-footer">
                                        <button type="button" onclick="performUpdate({{$categories->id}})" class="btn btn-primary">update</button>
                                        <a href="{{ route('categories.index') }}" type="button" class="btn btn-info">Return Back</a>

                                    </div>
                        </form>

                                    <!-- Include CSRF token field in the form -->
                                    @csrf

                                </div>
                            </div>

                            <!-- ... -->

                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->

                <!-- ... -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

@endsection

@section('scripts')
    <script>
        function performUpdate(id) {
            let formData = new FormData();
            formData.append('name', document.getElementById('name').value);

            storeRoute('/dashboard/update-categories/' + id, formData);
        }
    </script>
@endsection
