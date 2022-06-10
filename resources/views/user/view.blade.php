@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper container">
  <div class="card-header">
    User Detail
  </div>
  <input type="hidden" class="form-control" id="user_id" value={{ $user->id }}>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form>
          <div class="form-group">
              <label for="first_name">First Name:</label>
              <input type="text" class="form-control" name="first_name" value={{ $user->first_name }} disabled>
          </div>
          <div class="form-group">
              <label for="last_name">Last Name:</label>
              <input type="text" class="form-control" name="last_name" value={{ $user->last_name }} disabled>
          </div>
          <div class="form-group">
              <label for="email">Email :</label>
              <input type="email" class="form-control" name="email" value={{ $user->email }} disabled>
          </div>
          <div class="form-group">
              <label for="role">Role:</label>
              <select disabled class="form-control" name="role" value={{ $user->role }}>
                @foreach($roles as $role)
                @if($role->name == "blogger")
                <option selected="selected">{{$role->name}}</option>
                @else
                <option>{{$role->name}}</option>
                @endif
                @endforeach
            </select>
          </div>
      </form>
    @role('administrator')
      <div class="card-body">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}  
            </div><br />
        @endif
        
        <div class="d-flex align-items-center">
            <h1>Assigned users</h1>
            <small class="badge badge-secondary ml-2">list</small>
            <button type="submit" class="btn btn-success m-2" data-toggle="modal" data-target=".bd-example-modal-lg">Assign User</button>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content container p-4">
                    <form id="submitForm">
                        <div class="form-group">
                            <label for="first_name">Select the users to assign:</label>
                            <select class="form-control" name="bloggers" id="bloggers" aria-label="Default select example" multiple>
                              @foreach ($bloggers as $item)
                              <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div onClick="submitForm()" class="btn btn-primary">assign</div>
                    </form>
                </div>
            </div>
        </div>
        <div class="w-full d-flex items-align-center justify-content-end">
        
        <form method="GET" action="{{ route('users.index') }}">
            <div class="form-group d-flex items-align-center justify-content-end">
                <button type="submit" class="btn btn-primary m-2">search</button>
                <input type="text" class="form-control m-2" name="search"/>
            </div>
        </form>
        </div>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Last Login</th>
                <th scope="col">Role</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                <tr>
                    <th scope="row">{{$item->id}}</th>
                    <td>{{$item->first_name}} {{$item->last_name}}</td>
                    <td>{{$item->email}}</td>
                    <td>
                        @php 
                            $value = $item->last_login ? $item->last_login : 'Never';
                        @endphp
                        <a href="#" class="badge badge-success">
                            {{$value}}
                        </a>
                    </td>
                    <td>
                        @foreach ($item->roles as $role)
                            <a href="#" class="badge badge-secondary">{{$role->name}}</a>
                        @endforeach
                    </td>
                    <td class="d-flex">
                        @can('users delete')
                        <form action="{{ route('supervisors.remove', ['user' => $item->id, 'id' => $user->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Remove</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($users)
          <div class="w-full d-flex items-align-center justify-content-end">
              {{ $users->links() }}
          </div>
        @endif
      </div>
    @endrole
  </div>
</div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

<script>

function submitForm(){
    let bloggers = $('#bloggers').val();
    let user_id = $('#user_id').val();
    $.ajax({
      url: `/user/${user_id}/assign`,
      type:"POST",
      data:{
        "_token": "{{ csrf_token() }}",
        bloggers:bloggers,
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