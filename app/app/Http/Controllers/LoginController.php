<?php
namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $req)
    {
        $req->validate([
            'username' => 'required | max:10',
            'password' => 'required | min:4 max:10',
        ]);

        $id = $req->input('username');
        $password = $req->input('password');

        $data = User::where('emp_id', '=', $id)->first();

        $userdata = DB::table('users')
            ->where('emp_id', $id)
            ->get();

        if ($data) {

            if ($password == $data->password) {

                if ($data->type_of_user == "Normal") {
                    return view('userdashboard', ['data' => $userdata]);
                } else if ($data->type_of_user == "Manager") {

                    $issues = DB::table('issues')
                        ->join('emp_issue', 'emp_issue.emp_id', '=', 'issues.emp_id')
                        ->where('manager_id', $data->emp_id)
                        ->select('issues.*')
                        ->groupBy('issues.issue_id')
                        ->get();

                    $projects = DB::table('projects')
                        ->join('emp_proj', 'emp_proj.project_id', '=', 'projects.project_id')
                        ->where('manager_id', $data->emp_id)
                        ->select('projects.*')
                        ->groupBy('projects.project_id')
                        ->get();

                    $users = DB::table('users')
                        ->join('emp_proj', 'emp_proj.emp_id', '=', 'users.emp_id')
                        ->where('manager_id', $data->emp_id)
                        ->select('users.*')
                        ->get();

                    $array = ['userdata', 'users', 'issues', 'projects'];
                    return view('managerDashboard', compact($array));
                } else if ($data->type_of_user == "Admin") {

                    $normalUsers = DB::table('users')
                        ->where('type_of_user', 'Normal')
                        ->get()
                        ->count();

                    $managers =  DB::table('users')
                    ->where('type_of_user', 'Manager')
                    ->get()
                    ->count();

                    $NumberOfUsers = $normalUsers + $managers;

                    $Users = User::all();
                    $projects = Project::all();
                    $issues = Issue::all();

                    $array = ['Users', 'issues', 'projects', 'NumberOfUsers'];
                    return view('adminDashboard', compact($array));
                }

            } else {
                return back()->with('fail', 'invalid password');
            }

        } else {
            return back()->with('fail', 'invalid user name');
        }
    }

    public function updateMobile(Request $req)
    {
        $user = User::where('emp_id', $req->emp_id)->update(array('phone_number' => $req->newMobileNumber));
        if ($user > 0) {
            return redirect()->back()->with('message', 'mobile Number updated');
        }
    }
    public function updateAddress(Request $req)
    {
        $user = User::where('emp_id', $req->emp_id)->update(array('comm_address' => $req->newAddress));
        if ($user != 0) {
            return redirect()->back()->with('message', 'Address updated');
        }
    }

}
