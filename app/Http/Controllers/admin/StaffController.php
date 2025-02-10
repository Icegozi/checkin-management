<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(){
        $staffs = User::where('role', 0)->paginate(5);
        return view('admin.pages.staff.index', compact('staffs'));
    }
    

    public function create()
    {
        return view('admin.pages.staff.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'address' => 'required|string|max:255',
            'status' => 'required|integer',
        ]);
    
        User::create([
            'name' => trim(ucwords(strtolower($request->name))),
            'email' =>trim( $request->email),
            'password' => Hash::make($request->password),
            'address' => trim($request->address),
            'status' => trim($request->status),
            'role' => 0,
        ]);
    
        return redirect()->route('staff.index')->with('success', 'Thêm nhân viên mới thành công!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $staffs = User::findOrFail($id);
        return view('admin.pages.staff.edit', compact('staffs'));
    }
    
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'address' => 'required|string|max:255',
            'status' => 'required|integer',
        ]);
    
        $user = User::findOrFail($id);
    
        $updateData = [
            'name' => trim(ucwords(strtolower($request->name))),
            'email' => trim($request->email),
            'address' => trim($request->address),
            'status' => trim($request->status),
            'role' => 0,
        ];
    
        if (!empty($request->password)) {
            $updateData['password'] = Hash::make($request->password);
        }
    
        $user->update($updateData);
    
        return redirect()->route('staff.index')->with('success', 'User updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $staff = User::findOrFail($id);
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'User deleted successfully!');
    }
    
}
