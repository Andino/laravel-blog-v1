@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-between card-header">
                    <div class="d-flex align-items-center">
                        <h1>Blog Module</h1>
                        <small class="badge badge-secondary ml-2">list</small>
                    </div>
                    @can('blog create')
                    <a href="{{ route('blogs.create') }}" type="button" class="btn btn-outline-primary d-flex align-items-center">
                        Add Blog
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                    {{ session()->get('success') }}  
                    </div><br />
                @endif
                <div class="w-full d-flex items-align-center justify-content-end">
                <form method="GET" action="{{ route('blogs.index') }}">
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
                        <th scope="col">Description</th>
                        @hasanyrole('administrator|supervisor')
                        <th scope="col">Owner</th>
                        @endhasanyrole
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $blog)
                        <tr>
                            <th scope="row">{{$blog->id}}</th>
                            <td>{{$blog->name}}</td>
                            <td>{{$blog->description}}</td>
                            @hasanyrole('administrator|supervisor')
                            <td>
                                @if(Auth::user()->id == $blog->user->id)
                                <p class="badge badge-primary p-2">You</p>
                                @else
                                <p class="badge badge-success p-2">{{$blog->user->first_name}} {{$blog->user->last_name}}</p>
                                @endif
                            </td>
                            @endhasanyrole

                            <td class="d-flex">
                                
                                @can('blog detail')
                                    <a href="{{ route('blogs.show', ['blog' => $blog->id]) }}" type="button" class="btn btn-outline-success mr-2">View</a>
                                @endcan
                                @can('blog edit')
                                    <a href="{{ route('blogs.edit', ['blog' => $blog->id]) }}" type="button" class="btn btn-outline-primary mr-2">Edit</a>
                                @endcan
                                @can('blog delete')
                                <form action="{{ route('blogs.destroy', ['blog' => $blog->id]) }}" method="post">
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
                        {{ $blogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
