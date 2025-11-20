<?php

namespace App\Http\Controllers;

use App\Models\Stack;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StackController extends Controller
{
    public function index()
    {
        // Ambil data companies untuk dropdown di Modal
        $companies = Company::all();
        return view('master.stacks', compact('companies'));
    }

    public function getData()
    {
        // Eager load companyRelation agar hemat query
        $stacks = Stack::with('companyRelation')->select('stacks.*');

        return DataTables::of($stacks)
            ->addIndexColumn()
            ->addColumn('action', function ($stack) {
                return '
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-warning" onclick="editStack(' . $stack->id . ', \'' . addslashes($stack->stack_name) . '\', \'' . addslashes($stack->government_code) . '\', ' . $stack->company_id . ', \'' . $stack->longitude . '\', \'' . $stack->latitude . '\', \'' . $stack->oxygen_reference . '\')" title="Edit">
                            <i class="bx bx-edit"></i>
                        </button>
                        <form action="' . route('master.stacks.destroy', $stack->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this stack?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->addColumn('company_name', function ($stack) {
                return $stack->companyRelation ? $stack->companyRelation->name : '-';
            })
            ->editColumn('created_at', function ($stack) {
                return $stack->created_at->format('d M Y H:i');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stack_name' => 'required|string|max:255',
            'government_code' => 'nullable|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'oxygen_reference' => 'nullable|string|max:50',
        ]);

        Stack::create($validated);

        return redirect()->route('master.stacks')->with('success', 'Stack created successfully.');
    }

    public function update(Request $request, $id)
    {
        $stack = Stack::findOrFail($id);

        $validated = $request->validate([
            'stack_name' => 'required|string|max:255',
            'government_code' => 'nullable|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'oxygen_reference' => 'nullable|string|max:50',
        ]);

        $stack->update($validated);

        return redirect()->route('master.stacks')->with('success', 'Stack updated successfully.');
    }

    public function destroy($id)
    {
        $stack = Stack::findOrFail($id);
        $stack->delete();

        return redirect()->route('master.stacks')->with('success', 'Stack deleted successfully.');
    }
}