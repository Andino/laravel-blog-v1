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
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $blog)
                        <tr>
                            <th scope="row">{{$blog->id}}</th>
                            <td>{{$blog->name}}</td>
                            <td>{{$blog->description}}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
