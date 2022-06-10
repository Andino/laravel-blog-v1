@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-between card-header">
                    <div class="d-flex align-items-center">
                        <h1>Users Module</h1>
                        <small class="badge badge-secondary ml-2">list</small>
                    </div>
                    @can('users create')
                    <a href="{{ route('users.create') }}" type="button" class="btn btn-outline-primary d-flex align-items-center">
                        Add User
                    </a>
                    @endcan
                </div>
                @role('administrator|supervisor')
                <div class="card-body">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                        {{ session()->get('success') }}  
                        </div><br />
                    @endif
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
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{{$user->first_name}} {{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @php 
                                        $value = $user->last_login ? $user->last_login : 'Never';
                                    @endphp
                                    <a href="#" class="badge badge-success">
                                        {{$value}}
                                    </a>
                                </td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <a href="#" class="badge badge-secondary">{{$role->name}}</a>
                                    @endforeach
                                </td>
                                <td class="d-flex">
                                    
                                    @can('users detail')
                                        <a href="{{ route('users.show', ['user' => $user->id]) }}" type="button" class="btn btn-outline-success mr-2">View</a>
                                    @endcan
                                    @can('users edit')
                                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" type="button" class="btn btn-outline-primary mr-2">Edit</a>
                                    @endcan
                                    @can('users delete')
                                    <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="w-full d-flex items-align-center justify-content-end">
                        {{ $users->links() }}
                    </div>
                </div>
                @endrole
            </div>
        </div>
    </div>
</div>
@endsection
