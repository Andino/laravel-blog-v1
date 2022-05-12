@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper container">
  <div class="card-header">
    Edit User
  </div>
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
      <form method="post" action="{{ route('users.update', ['user' => $user->id]) }}">
          @method('PUT')
          @csrf
          <div class="form-group">
              <label for="first_name">First Name:</label>
              <input type="text" class="form-control" name="first_name" value={{ $user->first_name }}>
          </div>
          <div class="form-group">
              <label for="last_name">Last Name:</label>
              <input type="text" class="form-control" name="last_name" value={{ $user->last_name }}>
          </div>
          <div class="form-group">
              <label for="email">Email :</label>
              <input type="email" class="form-control" name="email" value={{ $user->email }}>
          </div>
          <div class="form-group">
              <label for="role">Role:</label>
              <select class="form-control" name="role" value={{ $user->role }}>
                @foreach($roles as $role)
                @if($role->name == "blogger")
                <option selected="selected">{{$role->name}}</option>
                @else
                <option>{{$role->name}}</option>
                @endif
                @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
@endsection