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

                <div class="card-body">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                    {{ session()->get('success') }}  
                    </div><br />
                @endif
                <table class="table">
                    <caption>
                        <div class="d-flex justify-content-between">
                            <div>List of users</div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </caption>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
