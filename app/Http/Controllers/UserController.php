<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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
     * Instantiate a new controller instance.
     * @param User $user
     * @return void
     */
    public function __construct(User $user, Role $role)
    {
        $this->users = $user;
        $this->roles = $role;
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
        $users = $this->listfilters($request, '');
        return view('user.list', compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listByRole(Request $request, $role)
    {

        $loggedUser = auth()->user();
        $search = $request->search;
        $users = $this->listfilters($request, $role);
        return view('user.supervisor.list', compact('users'));
    }

    public function listfilters($request, $role)
    {
        $loggedUser = auth()->user();
        $search = $request->search;
        return $this->users
            ->when($search, function ($query, $role) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->when($search, function ($query, $role) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->when($loggedUser->hasRole('supervisor'), function ($query, $role) use ($loggedUser) {
                $query->where('parent', $loggedUser->id);
            })
            ->when($role, function ($q) use ($role) {
                $q->whereHas('roles', function ($query) use ($role) {
                    $query->where("name", $role);
                });
            })
            ->with('roles')
            ->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roles->all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = $this->users->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->save();

        $user->syncRoles(array($request->role));

        return redirect('/users')->with('success', 'User has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = $this->roles->all();
        $users = [];
        $bloggers = [];
        if ($user->hasRole('supervisor')) {
            $users = $this->users->where('parent', $user->id)->paginate(20);
            $bloggers = $this->users->whereHas('roles', function ($query) {
                $query->where("name", 'blogger');
            })->where('parent', 0)->get();
        }
        return view('user.view', compact('user', 'users', 'roles', 'bloggers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = $this->roles->all();
        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->update();
        $user->syncRoles(array($request->role));
        return redirect('/users')->with('success', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/users')->with('success', 'User has been deleted Successfully');
    }

    /**
     * Assign a user to the selected supervisor
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function assign(User $user, Request $request)
    {
        $this->users->whereIn('id', $request->bloggers)->update([
            "parent" => $user->id
        ]);

        return redirect('/user/supervisor')->with('success', 'Blogger has been assigned Successfully');
    }

    /**
     * Remove a user from the selected supervisor
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function remove($id, $user)
    {
        $user = $this->users->find($user);
        $user->parent = 0;
        $user->update();

        return redirect('/user/supervisor')->with('success', 'Blogger has been removed Successfully');
    }
}
