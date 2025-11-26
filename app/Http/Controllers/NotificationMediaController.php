<?php

namespace App\Http\Controllers;

use App\Models\NotificationMedia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationMediaController extends Controller
{
    public function index()
    {
        return view('master.notification-medias');
    }

    public function getData()
    {
        $medias = NotificationMedia::query();

        return DataTables::of($medias)
            ->addIndexColumn()
            ->addColumn('action', function ($media) {
                return '
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-warning"
                            onclick="editMedia(' . $media->id . ', \'' . addslashes($media->code) . '\', \'' . addslashes($media->name) . '\', \'' . addslashes($media->description) . '\')"
                            title="Edit">
                            <i class="bx bx-edit"></i>
                        </button>
                        <form action="' . route('master.notification-medias.destroy', $media->id) . '" method="POST" class="d-inline"
                            onsubmit="return confirm(\'Delete this media?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->editColumn('code', function($media){
                return '<span class="badge bg-label-primary">' . $media->code . '</span>';
            })
            ->editColumn('created_at', function ($media) {
                return $media->created_at->format('d M Y H:i');
            })
            ->rawColumns(['action', 'code'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:notification_medias,code',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        NotificationMedia::create($validated);

        return redirect()->route('master.notification-medias')->with('success', 'Media created successfully.');
    }

    public function update(Request $request, $id)
    {
        $media = NotificationMedia::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:notification_medias,code,' . $id,
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $media->update($validated);

        return redirect()->route('master.notification-medias')->with('success', 'Media updated successfully.');
    }

    public function destroy($id)
    {
        $media = NotificationMedia::findOrFail($id);
        $media->delete();

        return redirect()->route('master.notification-medias')->with('success', 'Media deleted successfully.');
    }
}