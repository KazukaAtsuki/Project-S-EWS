<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Stack;
use App\Models\Priority;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    // Halaman List Data (Data Table)
    // Di dalam TicketController.php

    public function index()
    {
        // Hitung Total Tiket
        $totalTickets = Ticket::count();

        // Hitung Tiket dengan Status 'Open'
        $openTickets = Ticket::where('status', 'Open')->count();

        // Kirim data ke view
        return view('support.tickets', compact('totalTickets', 'openTickets'));
    }

    // Halaman Form Create Ticket
    public function create()
    {
        $stacks = Stack::all();
        $priorities = Priority::all();
        $categories = Category::all();
        $user = Auth::user(); // Untuk auto-fill Issuer & Email

        return view('support.tickets-create', compact('stacks', 'priorities', 'categories', 'user'));
    }

    // Logic DataTables Yajra
    public function getData()
{
    // 1. Ambil data ticket beserta relasinya
    $tickets = Ticket::with(['user', 'stack', 'priority', 'category'])->select('tickets.*');

    return DataTables::of($tickets)
        ->addIndexColumn()
        ->addColumn('action', function ($ticket) {

            // --- BAGIAN PENTING (FIX) ---
            // Kita generate URL lengkap menggunakan ID ticket
            // Hasilnya nanti jadi: http://127.0.0.1:8000/support/ticket/1/show
            $showUrl = route('support.tickets.show', $ticket->id);
            $deleteUrl = route('support.tickets.destroy', $ticket->id);

            return '
                <div class="d-flex gap-2">
                     <!-- Perhatikan href mengambil variable $showUrl -->
                     <a href="' . $showUrl . '" class="btn btn-sm btn-info" title="Detail">
                        <i class="bx bx-show"></i>
                     </a>

                     <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Delete ticket?\')">
                        ' . csrf_field() . ' ' . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger" title="Delete">
                            <i class="bx bx-trash"></i>
                        </button>
                     </form>
                </div>
            ';
        })
        ->addColumn('issuer', function ($ticket) {
            return $ticket->user->name;
        })
        ->addColumn('stack_name', function ($ticket) {
            return $ticket->stack->stack_name;
        })
        ->addColumn('priority_badge', function ($ticket) {
            $color = match($ticket->priority->name) {
                'Critical' => 'danger',
                'High' => 'warning',
                'Medium' => 'primary',
                'Low' => 'secondary',
                default => 'info'
            };
            return '<span class="badge bg-label-'.$color.'">'.$ticket->priority->name.'</span>';
        })
        ->editColumn('created_at', function ($ticket) {
            return $ticket->created_at->format('d M Y H:i');
        })
        ->editColumn('status', function ($ticket) {
            $bg = $ticket->status == 'Open' ? 'success' : 'secondary';
            return '<span class="badge bg-'.$bg.'">'.$ticket->status.'</span>';
        })
        ->rawColumns(['action', 'priority_badge', 'status'])
        ->make(true);
}

    // Simpan Ticket Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'stack_id' => 'required|exists:stacks,id',
            'priority_id' => 'required|exists:priorities,id',
            'category_id' => 'required|exists:categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $data = $validated;
        $data['user_id'] = Auth::id(); // Ambil ID user yang login
        $data['status'] = 'Open';

        // Handle File Upload
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('ticket-attachments', 'public');
            $data['attachment'] = $path;
        }

        Ticket::create($data);

        return redirect()->route('support.tickets')->with('success', 'Ticket created successfully!');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        // Hapus file jika ada
        if ($ticket->attachment) {
            Storage::disk('public')->delete($ticket->attachment);
        }
        $ticket->delete();
        return redirect()->route('support.tickets')->with('success', 'Ticket deleted.');
    }

    public function show($id)
{
    $ticket = Ticket::with(['user', 'stack.companyRelation', 'priority', 'category'])->findOrFail($id);
    return view('support.tickets-show', compact('ticket'));
}
}