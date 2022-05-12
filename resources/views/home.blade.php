@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                    {{ session()->get('success') }}  
                    </div><br />
                @endif
                <div class="card-header">Welcome to the Dashboard <a class="font-weight-bold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a></div>
                <!-- Large modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Update Personal Info</button>

                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content container p-4">
                            <form id="submitForm">
                                <div class="form-group">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value={{ auth()->user()->first_name }}>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value={{ auth()->user()->last_name }}>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email :</label>
                                    <input type="email" class="form-control" name="email" id="email" value={{ auth()->user()->email }}>
                                </div>
                                <div onClick="submitForm()" class="btn btn-primary">update</div>
                            </form>
                        </div>
                    </div>
                </div>
                <h2 class="p-3">Last time logged into the platform: <a href="#" class=" ml-2 badge badge-success">{{ auth()->user()->last_login }}</a></h>
                <h3 class="p-3">Name: <a href="#" class=" ml-2 badge badge-info">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a></h3>
                <h3 class="p-3">Email: <a href="#" class=" ml-2 badge badge-info">{{ auth()->user()->email }}</a></h3>
                <div class="card-body d-flex flex-wrap">
                        @hasanyrole('blogger|supervisor')
                        <div class="card border-primary mb-3 col-md-3 m-2" style="max-width: 18rem;">
                            <div class="card-body text-primary">
                                <h5 class="card-title">My Blogs created</h5>
                                <p class="card-text">You have: {{$myBlogs}} blog/s created.</p>
                            </div>
                        </div>
                        <div class="card border-light mb-3 col-md-3 m-2" style="max-width: 18rem;">
                            <div class="card-body text-light">
                                <h5 class="card-title">Blogs created</h5>
                                <p class="card-text">The platform have: {{$blogs}} blog/s created.</p>
                            </div>
                        </div>
                        @endhasanyrole
                        @hasanyrole('supervisor')
                        <div class="card border-secondary mb-3 col-md-3 m-2" style="max-width: 18rem;">
                            <div class="card-body text-secondary">
                                <h5 class="card-title">Assigned Users</h5>
                                <p class="card-text">You have: 0 bloggers users assigned.</p>
                            </div>
                        </div>
                        @endhasanyrole
                        @hasanyrole('administrator')
                        <div class="card border-success mb-3 col-md-3 m-2" style="max-width: 18rem;">
                            <div class="card-body text-success">
                                <h5 class="card-title">Admin Users</h5>
                                <p class="card-text">The platform have: {{$administrators}} users with an admin role.</p>
                            </div>
                        </div>
                        @endhasanyrole
                        @hasanyrole('administrator')
                        <div class="card border-danger  mb-3 col-md-3 m-2" style="max-width: 18rem;">
                            <div class="card-body text-danger ">
                                <h5 class="card-title">Supervisor Users</h5>
                                <p class="card-text">The platform have: {{$supervisors}} users with an supervisor role.</p>
                            </div>
                        </div>
                        @endhasanyrole
                        @hasanyrole('administrator')
                        <div class="card border-info mb-3 col-md-3 m-2" style="max-width: 18rem;">
                            <div class="card-body text-info">
                                <h5 class="card-title">Bloggers Users</h5>
                                <p class="card-text">The platform have: {{$bloggers}} users with an blogger role.</p>
                            </div>
                        </div>
                        @endhasanyrole
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

<script>

function submitForm(){
    let first_name = $('#first_name').val();
    let last_name = $('#last_name').val();
    let email = $('#email').val();
    
    $.ajax({
      url: "/profile",
      type:"PUT",
      data:{
        "_token": "{{ csrf_token() }}",
        first_name:first_name,
        last_name:last_name,
        email:email,
      },
      success:function(response){
          console.log(response);
          location.reload()
      },
      error: function(response) {
          console.log(response);
          location.reload()
      },
      });
}
</script>
@endsection
