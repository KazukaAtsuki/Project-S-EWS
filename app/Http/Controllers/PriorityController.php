<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PriorityController extends Controller
{
    public function index()
    {
        return view('master.priorities');
    }

    public function getData()
    {
        $priorities = Priority::query();

        return DataTables::of($priorities)
            ->addIndexColumn()
            ->addColumn('action', function ($priority) {
                return '
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-warning"
                            onclick="editPriority(' . $priority->id . ', \'' . addslashes($priority->name) . '\', \'' . addslashes($priority->description) . '\')"
                            title="Edit">
                            <i class="bx bx-edit"></i>
                        </button>
                        <form action="' . route('master.priorities.destroy', $priority->id) . '" method="POST" class="d-inline"
                            onsubmit="return confirm(\'Are you sure you want to delete this priority?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->addColumn('name_badge', function ($priority) {
                // Opsional: Memberikan warna badge berbeda
                $color = match($priority->name) {
                    'Critical' => 'danger',
                    'High' => 'warning',
                    'Medium' => 'primary',
                    'Low' => 'secondary',
                    default => 'info'
                };
                return '<span class="badge bg-label-'.$color.'">'.$priority->name.'</span>';
            })
            ->editColumn('created_at', function ($priority) {
                return $priority->created_at->format('d M Y H:i');
            })
            ->rawColumns(['action', 'name_badge'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:priorities,name',
            'description' => 'nullable|string',
        ]);

        Priority::create($validated);

        return redirect()->route('master.priorities')->with('success', 'Priority created successfully.');
    }

    public function update(Request $request, $id)
    {
        $priority = Priority::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:priorities,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $priority->update($validated);

        return redirect()->route('master.priorities')->with('success', 'Priority updated successfully.');
    }

    public function destroy($id)
    {
        $priority = Priority::findOrFail($id);
        $priority->delete();

        return redirect()->route('master.priorities')->with('success', 'Priority deleted successfully.');
    }
}