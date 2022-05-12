<?php

namespace App\Http\Controllers;

use App\User;
use App\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\UserUpdateRequest;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * User Model instance
    */
    protected $user;

    /**
     * Role Model instance
    */
    protected $role;

    /**
     * Blog Model instance
    */
    protected $blog;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Blog $blog, Role $role, User $user)
    {
        $this->blog = $blog;
        $this->role = $role;
        $this->user = $user;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $loggedUser = auth()->user();
        $blogs = $this->blog->count();
        $myBlogs = $this->blog->where("user_id", $loggedUser->id)->count();
        $administrators = $this->user->whereHas("roles", function ($q) {
            $q->where("name", "administrator");
        })->count();

        $supervisors = $this->user->whereHas("roles", function ($q) {
            $q->where("name", "supervisor");
        })->count();

        $bloggers = $this->user->whereHas("roles", function ($q) {
            $q->where("name", "blogger");
        })->count();
        return view('home', compact('blogs', 'myBlogs', 'administrators', 'supervisors', 'bloggers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $this->user->find(auth()->user()->id);
        $user->fill($request->all());
        $user->update();
        return redirect('/')->with('success', 'Personal info has been updated');
    }
}
