<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Blog Model instance
    */
    protected $blog;

    /**
     * Instantiate a new controller instance.
     * @param User $user
     * @return void
     */
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $loggedUser = auth()->user();
        $search = $request->search;
        $blogs = $this->blog
            ->when($search, function ($query, $role) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->when(!$loggedUser->hasRole('administrator'), function ($query, $role) use ($loggedUser) {
                $query->where('user_id', $loggedUser->id);
            })
            ->paginate(20);
        return view('blog.list', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $blog = $this->blog->fill($request->all());
        $blog->user_id = auth()->user()->id;
        $blog->save();

        return redirect('/blogs')->with('success', 'Blog has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return view('blog.view', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->fill($request->all());
        $blog->user_id = auth()->user()->id;
        $blog->update();
        return redirect('/blogs')->with('success', 'Blog has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect('/blogs')->with('success', 'Blog has been deleted Successfully');
    }
}

