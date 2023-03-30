<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\DrugTransactionHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function home()
    {
        $users = User::where('id', '!=', 1)->orderBy('id')->get();
        $total_users = User::count();
        $total_drugs = Drug::count();
        $income_month = DrugTransactionHistory::selectRaw("sum(unit_price * quantity) as amount")
                                                ->where(DB::raw('EXTRACT(YEAR_MONTH FROM created_at)'), date('Ym'))
                                                ->first()->amount;
        $income_today = DrugTransactionHistory::selectRaw("sum(unit_price * quantity) as amount")
                                                ->where(DB::raw('DATE(created_at)'), date('Y-m-d'))
                                                ->first()->amount;

        $results = [
            'users' => $users,
            't_users' => $total_users - 1,
            't_drugs' => $total_drugs,
            'i_month' => $income_month,
            'i_today' => $income_today,
        ];
        return view('home', ['results' => $results]);
        
    }

    public function userList()
    {
        if(Auth()->user()->user_level === "Admin"){
            $users = User::where('id', '!=', 1)
                            ->where('user_level', 'Admin')
                            ->orWhere('user_level', 'User')
                            ->orderByDesc('id')->get();
        } else {
            $users = User::where('id', '!=', 1)
                            ->where('user_level', 'Accountant')
                            ->orWhere('user_level', 'Accounts Officer')
                            ->orderByDesc('id')->get();
        }
        
        return view('users', compact('users'));
        
    }

    public function index()
    {
        if (!Auth::check()) {
            return view('login');
        } else {
            return back();
        }
    }

    public function postLogin(Request $request)
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...dashboard

            Session::flash('success', 'Logged in Successfully!');
            return redirect()->intended('home');
        }

        return back()->with('error', 'Oppes! You have entered invalid credentials!');
    }

    public function postRegistration(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'username' => 'required',
            'user_level' => 'required',
            'password' => 'nullable|min:6|same:confirm_password',
            'confirm_password' => 'nullable|min:6|same:password'
        ]);

        // return redirect('users')->with('success', 'New User Successfully Created!!');
        if($request->has('id')) {
            if(isset($request->password)){
                User::updateOrCreate(
                    [
                        'username' => $request['username'],
                    ],
                    [
                        'name' => $request['name'],
                        'user_level' => $request['user_level'],
                        'password' => Hash::make($request['password'])
                    ]
                );
            } else {
                User::updateOrCreate(
                    [
                        'username' => $request['username']
                    ],
                    [
                        'name' => $request['name'],
                        'user_level' => $request['user_level'],
                    ]
                );
            }
            

            return back()->with('success', 'User Updated Successfully!!');
        }
        else{
            User::updateOrCreate(
                [
                    'username' => $request['username']
                ],
                [
                    'name' => $request['name'],
                    'user_level' => $request['user_level'],
                    'password' => Hash::make($request['password'])
                ]
            );

            return back()->with('success', 'New User Successfully Created!!');
        }
    }

    public function profile()
    {
        
        if (Auth()->user()->user_level != 'Super Admin') {
            $user = Auth()->user();
            return view('layouts.profile', compact('user'));
        } else {
            $user = Auth()->user();
            return view('profile', compact('user'));
        }
        
    }

    public function postProfile(Request $request)
    {
        //dd($request->all());

        if (isset($request->password)) {
            request()->validate([
                'name' => 'required',
                'username' => 'required',
                'contact' => 'required',
                'password' => 'required|min:6|same:confirm_password',
                'confirm_password' => 'required|min:6|same:password'
            ]);

            $user = User::find(Auth()->user()->user_id);
            $user->update([
                'name' => $request['name'],
                'username' => $request['username'],
                'contact' => $request['contact'],
                'password' => Hash::make($request['password'])
            ]);
        } else {
            request()->validate([
                'name' => 'required',
                'contact' => 'required',
                'username' => 'required',
            ]);

            $user = User::find(Auth()->user()->user_id);
            $user->update([
                'name' => $request['name'],
                'contact' => $request['contact'],
                'username' => $request['username'],
            ]);
        }

        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function destroy($id)
    {
        
        $user = User::find($id);

        $user->delete();
        return back()->with('success', 'User Account Deleted Successfully!!');
        
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
