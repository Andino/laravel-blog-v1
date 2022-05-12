@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper container">
  <div class="card-header">
    Blog Detail
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
      <form>
          <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" name="name" value={{ $blog->name }} disabled>
          </div>
          <div class="form-group">
              <label for="description">Description:</label>
              <input type="text" class="form-control" name="description" value={{ $blog->description }} disabled>
          </div>
      </form>
  </div>
</div>
@endsection