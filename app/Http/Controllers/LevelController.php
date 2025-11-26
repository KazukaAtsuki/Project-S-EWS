<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    // Method Index (Sebelumnya levels)
    public function index()
    {
        // PERUBAHAN: Mengarah ke folder 'role'
        // Pastikan file view ada di resources/views/role/levels.blade.php
        return view('role.levels');
    }

    public function getData()
    {
        $levels = Level::query();

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('action', function ($level) {
                // Route tetap 'master.levels...' sesuai web.php
                $editUrl = route('master.levels.edit', $level->id);

                return '
                    <div class="d-flex gap-2">
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bx bx-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteLevel(' . $level->id . ')" title="Delete">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                ';
            })
            ->addColumn('code_badge', function ($level) {
                return '<span class="badge bg-primary">' . $level->code . '</span>';
            })
            ->addColumn('created_at_formatted', function ($level) {
                return $level->created_at->format('d F Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function ($level) {
                return $level->updated_at->diffForHumans();
            })
            ->rawColumns(['action', 'code_badge'])
            ->make(true);
    }

    public function create()
    {
        // PERUBAHAN: View create ada di folder 'role'
        return view('role.levels-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:levels,code'],
            'level' => ['required', 'string', 'max:100'],
        ]);

        Level::create($validated);

        return redirect()->route('master.levels')->with('success', 'Level berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $level = Level::findOrFail($id);
        // PERUBAHAN: View edit ada di folder 'role'
        return view('role.levels-edit', compact('level'));
    }

    public function update(Request $request, string $id)
    {
        $level = Level::findOrFail($id);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:levels,code,' . $id],
            'level' => ['required', 'string', 'max:100'],
        ]);

        $level->update($validated);

        return redirect()->route('master.levels')->with('success', 'Level berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $level = Level::findOrFail($id);
        $level->delete();

        return redirect()->route('master.levels')->with('success', 'Level berhasil dihapus!');
    }
}