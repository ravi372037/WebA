<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'customer')->get();
        $pending_users = User::where(['role' => 'customer', 'status' => '0'])->count();
        $verified_users = User::where(['role' => 'customer', 'status' => '1'])->count();
        $rejected_users = User::where(['role' => 'customer', 'status' => '2'])->count();

        return view('Admin.index', compact('users', 'pending_users', 'verified_users', 'rejected_users'));
    }
    public function change_status($status, $id)
    {
        try{
            User::find($id)->update(['status' => $status]);
            return back()->with('success', 'Status Update Successfull!');
        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }
    public function update_customer(UpdateCustomerRequest $request)
    {
        $user = User::findOrFail($request->input('user_id'));

        $user->update( $request->all());
        return redirect()->back()->with('success', 'Customer updated successfully');

    }
}
