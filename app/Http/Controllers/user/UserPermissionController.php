<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::orderBy("name")->get();
            return view(
                "backend.content.user.permission",
                compact("permissions")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function create($id)
    {
        try {
            $permissions = Permission::all();
            $user = User::find($id);
            return view(
                "backend.content.user.permissionCreate",
                compact("permissions", "user")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            Permission::create([
                "name" => $request->name,
            ]);
            toast("Permission Created!", "success");
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $permission = Permission::find($id);
            return view(
                "backend.content.user.permission",
                compact("permission")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Permission::find($id)->update([
                "name" => $request->name,
            ]);
            toast("Permission updated successfully", "success");
            return redirect()->route("permission.index");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            Permission::destroy($id);
            toast("Permission deleted!", "success");
            return redirect()->route("permission.index");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function permissionUpdate(Request $request, $userID)
    {
        // return $request;
        try {
            $user = User::find($userID);
            $user->syncPermissions($request->permissions);
            toast("Permissions updates successfully", "success");
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
