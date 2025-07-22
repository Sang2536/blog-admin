<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    public function index()
    {
        $admins = Administrator::latest()->paginate(10);
        return view('admin.administrators.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.administrators.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:administrators,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Administrator::create($validated);

        return redirect()->route('admin.administrators.index')->with('success', 'Thêm admin thành công.');
    }

    public function edit(Administrator $administrator)
    {
        return view('admin.administrators.form', compact('administrator'));
    }

    public function update(Request $request, Administrator $administrator)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:administrators,email,' . $administrator->id,
            'role'  => 'required|string|max:255',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->input('password'));
        }

        $administrator->update($validated);

        return redirect()->route('admin.administrators.index')->with('success', 'Cập nhật admin thành công.');
    }

    public function destroy(Administrator $administrator)
    {
        $administrator->delete();

        return redirect()->back()->with('success', 'Xoá admin thành công.');
    }
}
