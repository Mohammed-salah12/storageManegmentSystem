
@extends('cms.parent')


@section('title' , 'Admin')

@section('main-title' , 'Create Admin')

@section('sub-title' , 'create Admin')

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
              <h3 class="card-title">Create Data of Location</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>

              <div class="card-body">



                 <div class="row">
                     <div class="form-group col-md-6">
                         <label for="name">Name of location</label>
                         <input type="text" class="form-control" id="name" name="name" placeholder="Enter name of Admin">
                     </div>

                     <div class="row">
                         <div class="form-group col-md-6">
                             <label for="description">Description of location</label>
                             <input type="text" class="form-control" id="description" name="description" placeholder="Enter name of Admin">
                         </div>





              <div class="card-footer">
                <button type="button" onclick="performStore()" class="btn btn-primary">Store</button>
                <a href="{{ route('locations.index') }}" type="button" class="btn btn-info">Return Back</a>
              </div>
            </form>
              <div class="alert alert-danger" id="error_alert" hidden>
                  <ul id="error_messages_ul"></ul>
              </div>

          </div>

          <!-- /.card -->


        </div>
        <!--/.col (left) -->


        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /
    .container-fluid -->
  </section>

@endsection


@section('scripts')
  <script>
    function performStore(){
      let formData = new FormData();
        formData.append('name',document.getElementById('name').value);
        formData.append('description',document.getElementById('description').value);

        store('/dashboard/locations' , formData);
    }

  </script>
@endsection
