<?php

namespace App\Http\Controllers;

use App\Models\ReceiverNotification;
use App\Models\Company;
use App\Models\NotificationMedia;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ReceiverNotificationController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        $medias = NotificationMedia::all();
        return view('master.receiver-notification', compact('companies', 'medias'));
    }

    public function getData()
    {
        // Eager load relasi company dan media
        $receivers = ReceiverNotification::with(['company', 'media'])->select('receiver_notifications.*');

        return DataTables::of($receivers)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-warning"
                            onclick="editReceiver(' . $row->id . ', ' . $row->company_id . ', ' . $row->notification_media_id . ', \'' . $row->contact_value . '\', ' . $row->is_active . ')"
                            title="Edit">
                            <i class="bx bx-edit"></i>
                        </button>
                        <form action="' . route('master.receiver-notification.destroy', $row->id) . '" method="POST" class="d-inline"
                            onsubmit="return confirm(\'Delete this receiver?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->editColumn('media_name', function($row){
                return $row->media ? $row->media->name : '-';
            })
            ->editColumn('company_name', function($row){
                return $row->company ? $row->company->name : '-';
            })
            ->editColumn('status', function($row){
                return $row->is_active
                    ? '<span class="badge bg-label-success">Active</span>'
                    : '<span class="badge bg-label-danger">Disabled</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->diffForHumans();
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'notification_media_id' => 'required|exists:notification_medias,id',
            'contact_value' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        // Generate Code Otomatis
        $validated['code'] = Str::upper(Str::random(12));

        ReceiverNotification::create($validated);

        return redirect()->route('master.receiver-notification')->with('success', 'Receiver created successfully.');
    }

    public function update(Request $request, $id)
    {
        $receiver = ReceiverNotification::findOrFail($id);

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'notification_media_id' => 'required|exists:notification_medias,id',
            'contact_value' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $receiver->update($validated);

        return redirect()->route('master.receiver-notification')->with('success', 'Receiver updated successfully.');
    }

    public function destroy($id)
    {
        $receiver = ReceiverNotification::findOrFail($id);
        $receiver->delete();

        return redirect()->route('master.receiver-notification')->with('success', 'Receiver deleted successfully.');
    }
}