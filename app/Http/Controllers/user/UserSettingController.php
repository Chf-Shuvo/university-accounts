<?php

namespace App\Http\Controllers\user;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\AppAudit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserSettingController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            $companies = Company::all();
            return view(
                "backend.content.user.index",
                compact("users", "companies")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            User::create([
                "name" => $request->name,
                "email" => $request->email,
                "contact" => $request->contact,
                "password" => Hash::make($request->password),
                "company" => $request->company,
            ]);
            toast("User added successfully", "success");
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $companies = Company::all();
            $user = User::find($id);
            $current_company = Company::find($user->company);
            return view(
                "backend.content.user.profile",
                compact("user", "companies", "current_company")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            User::find($id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "contact" => $request->contact,
                "password" => Hash::make($request->password),
            ]);
            toast("Update Successful", "success");
            return redirect()->route("home");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            if (auth()->user()->id == $id) {
                toast("You cannot delete yourself!", "error");
                return redirect()->back();
            }
            User::destroy($id);
            toast("User deleted successfully", "success");
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function auditSettings()
    {
        try {
            $models = [];
            $modelsPath = app_path("Models");
            $modelFiles = File::allFiles($modelsPath);
            foreach ($modelFiles as $modelFile) {
                $models[] = $modelFile->getFilenameWithoutExtension();
            }

            return view("backend.content.audit.index", compact("models"));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getAudits(Request $request)
    {
        try {
            // return $request;
            $startDate = Carbon::parse($request->from)->format("Y-m-d");
            $endDate = Carbon::parse($request->to)->format("Y-m-d");
            $model = "App\\Models\\" . $request->model;
            $audits = AppAudit::with("user:id,name,company")
                ->where("auditable_type", $model)
                ->whereBetween("created_at", [$startDate, $endDate])
                ->get();
            $model = $request->model;
            $models = [];
            $modelsPath = app_path("Models");
            $modelFiles = File::allFiles($modelsPath);
            foreach ($modelFiles as $modelFile) {
                $models[] = $modelFile->getFilenameWithoutExtension();
            }
            // return $audits;
            return view(
                "backend.content.audit.index",
                compact("audits", "model", "models")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
