<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('master.users');
    }

    public function getData()
    {
        $users = User::query();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                $editUrl = route('master.users.edit', $user->id);
                $toggleUrl = route('master.users.toggle', $user->id);

                $toggleIcon = $user->is_active ? 'bx-toggle-right' : 'bx-toggle-left';
                $deleteButton = '';

                if ($user->id !== auth()->id()) {
                    $deleteButton = '
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(' . $user->id . ')" title="Delete">
                            <i class="bx bx-trash"></i>
                        </button>
                    ';
                }

                return '
                    <div class="d-flex gap-2">
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bx bx-edit"></i>
                        </a>
                        <form action="' . $toggleUrl . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            <button type="submit" class="btn btn-sm btn-info" title="Toggle Status">
                                <i class="bx ' . $toggleIcon . '"></i>
                            </button>
                        </form>
                        ' . $deleteButton . '
                    </div>
                ';
            })
            ->addColumn('role_badge', function ($user) {
                if ($user->role === 'Admin') {
                    return '<span class="badge bg-success">Administrator</span>';
                } elseif ($user->role === 'NOC') {
                    return '<span class="badge bg-info">NOC</span>';
                } else {
                    return '<span class="badge bg-primary">CEMS Operator</span>';
                }
            })
            ->addColumn('status_badge', function ($user) {
                return $user->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-secondary">Inactive</span>';
            })
            ->addColumn('created_at_formatted', function ($user) {
                return $user->created_at->format('d-m-Y H:i');
            })
            ->addColumn('updated_at_formatted', function ($user) {
                return $user->updated_at->diffForHumans();
            })
            ->rawColumns(['action', 'role_badge', 'status_badge'])
            ->make(true);
    }

    public function create()
    {
        $companies = $this->getCompanies();
        return view('master.users-create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
            'company' => ['required', 'string'],
            'role' => ['required', 'in:Admin,NOC,CEMS Operator'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'company' => $validated['company'],
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()->route('master.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $companies = $this->getCompanies();
        return view('master.users-edit', compact('user', 'companies'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'phone' => ['required', 'string', 'max:20'],
            'company' => ['required', 'string'],
            'role' => ['required', 'in:Admin,NOC,CEMS Operator'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('master.users')->with('success', 'User berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('master.users')->with('success', 'User berhasil dihapus!');
    }

    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return redirect()->back()->with('success', 'Status user berhasil diubah!');
    }

    public function generatePassword()
    {
        $password = Str::random(12);

        return response()->json([
            'password' => $password
        ]);
    }

    private function getCompanies(): array
    {
        return [
            'PT Trusur Unggul Teknusa',
            'PT Bhumi Jepara Service TJB-U5',
            'PT Bhumi Jepara Service TJB-U6',
            'PT. Freeport Indonesia CPP-1.1',
            'PT. Freeport Indonesia CPP-1.2',
            'PT. Freeport Indonesia CPP-2.3',
            'PT Badak NGL Stack 28',
        ];
    }
}