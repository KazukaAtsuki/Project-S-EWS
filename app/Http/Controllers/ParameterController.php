<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ParameterController extends Controller
{
    public function index()
    {
        return view('parameter.parameter');
    }

    public function getData()
    {
        $parameters = Parameter::query();

        return DataTables::of($parameters)
            ->addIndexColumn()
            ->addColumn('action', function ($parameter) {
                return '
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-sm btn-warning"
                            onclick="editParameter(' . $parameter->id . ', \'' . addslashes($parameter->name) . '\', \'' . addslashes($parameter->unit) . '\', ' . $parameter->max_threshold . ', \'' . addslashes($parameter->description) . '\')"
                            title="Edit">
                            <i class="bx bx-edit"></i>
                        </button>
                        <form action="' . route('master.parameter.destroy', $parameter->id) . '" method="POST" class="d-inline"
                            onsubmit="return confirm(\'Delete this parameter?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            // HAPUS editColumn 'max_threshold' disini agar data yang dikirim murni angka
            // Styling akan kita handle di View (Blade/JS)
            ->rawColumns(['action'])
            ->make(true);
    }

    // ... (function store, update, destroy biarkan tetap sama) ...
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:parameters,name',
            'unit' => 'required|string|max:20',
            'max_threshold' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
        Parameter::create($validated);
        return redirect()->route('master.parameter')->with('success', 'Parameter created successfully.');
    }

    public function update(Request $request, $id)
    {
        $parameter = Parameter::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:parameters,name,' . $id,
            'unit' => 'required|string|max:20',
            'max_threshold' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
        $parameter->update($validated);
        return redirect()->route('master.parameter')->with('success', 'Parameter updated successfully.');
    }

    public function destroy($id)
    {
        $parameter = Parameter::findOrFail($id);
        $parameter->delete();
        return redirect()->route('master.parameter')->with('success', 'Parameter deleted successfully.');
    }
}