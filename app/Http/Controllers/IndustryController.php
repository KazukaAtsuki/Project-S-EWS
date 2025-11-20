<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IndustryController extends Controller
{
    public function index()
    {
        return view('master.industry');
    }

    public function getData()
    {
        $industries = Industry::query();

        return DataTables::of($industries)
            ->addColumn('action', function ($industry) {
                return '
                    <button type="button" class="btn btn-sm btn-icon btn-label-primary me-1"
                        onclick="editIndustry(' . $industry->id . ', \'' . addslashes($industry->code) . '\', \'' . addslashes($industry->name) . '\', \'' . addslashes($industry->description) . '\')"
                        title="Edit">
                        <i class="bx bx-pencil"></i>
                    </button>
                    <form action="' . route('master.industry.destroy', $industry->id) . '" method="POST" class="d-inline"
                        onsubmit="return confirm(\'Are you sure?\');">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-icon btn-label-danger" title="Delete">
                            <i class="bx bx-trash"></i>
                        </button>
                    </form>
                ';
            })
            ->editColumn('created_at', function ($industry) {
                return $industry->created_at->format('d F Y H:i:s');
            })
            ->editColumn('updated_at', function ($industry) {
                return $industry->updated_at->diffForHumans();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:industries,code',
            'name' => 'required|string|max:255|unique:industries,name',
            'description' => 'nullable|string',
        ]);

        Industry::create($validated);

        return redirect()->route('master.industry')
            ->with('success', 'Industry created successfully.');
    }

    public function update(Request $request, $id)
    {
        $industry = Industry::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|unique:industries,code,' . $id,
            'name' => 'required|string|max:255|unique:industries,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $industry->update($validated);

        return redirect()->route('master.industry')
            ->with('success', 'Industry updated successfully.');
    }

    public function destroy($id)
    {
        $industry = Industry::findOrFail($id);
        $industry->delete();

        return redirect()->route('master.industry')
            ->with('success', 'Industry deleted successfully.');
    }
}