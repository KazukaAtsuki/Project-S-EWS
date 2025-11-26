<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('master.categories');
    }

    public function getData()
    {
        $categories = Category::query();

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                return '
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-warning"
                            onclick="editCategory(' . $category->id . ', \'' . addslashes($category->name) . '\', \'' . addslashes($category->description) . '\')"
                            title="Edit">
                            <i class="bx bx-edit"></i>
                        </button>
                        <form action="' . route('master.categories.destroy', $category->id) . '" method="POST" class="d-inline"
                            onsubmit="return confirm(\'Are you sure you want to delete this category?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->editColumn('created_at', function ($category) {
                return $category->created_at->format('d M Y H:i');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('master.categories')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('master.categories')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('master.categories')->with('success', 'Category deleted successfully.');
    }
}