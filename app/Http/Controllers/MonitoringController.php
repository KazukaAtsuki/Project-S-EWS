<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonitoringLog;
use App\Models\Stack;
use App\Models\Parameter;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    public function index()
    {
        $stacks = Stack::all();
        $parameters = Parameter::all();

        return view('master.monitoring.index', compact('stacks', 'parameters'));
    }

    // 1. Data untuk Tabel (Yajra)
    public function getData(Request $request)
    {
        $query = MonitoringLog::with(['stack', 'parameter'])
            ->select('monitoring_logs.*');

        // --- FILTER LOGIC ---
        if ($request->stack_id) {
            $query->where('stack_id', $request->stack_id);
        }
        if ($request->parameter_id) {
            $query->where('parameter_id', $request->parameter_id);
        }
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->period) {
            // Filter tombol cepat (Today, Last Week, etc)
            $this->applyPeriodFilter($query, $request->period);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('stack_name', function ($row) {
                return $row->stack->stack_name ?? '-';
            })
            ->addColumn('parameter_name', function ($row) {
                return $row->parameter->name ?? '-';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('data_status', function ($row) {
                // Logic Status: Jika Value > Threshold Parameter = Abnormal
                $threshold = $row->parameter->max_threshold ?? 0;
                if ($row->value > $threshold) {
                    return '<span class="badge bg-danger">Abnormal</span>';
                }
                return '<span class="badge bg-success">Normal</span>';
            })
            ->addColumn('measured', function ($row) {
                return $row->value . ' ' . ($row->parameter->unit ?? '');
            })
            ->addColumn('corrective', function ($row) {
                // Dummy data karena belum ada kolom ini di DB log
                return $row->value > 100 ? '-0.13 mg/Nm³' : '-';
            })
            ->addColumn('problem', function ($row) {
                // Dummy data visual
                $threshold = $row->parameter->max_threshold ?? 0;
                return $row->value > $threshold ? '<span class="badge bg-label-danger">High Value</span>' : '-';
            })
            ->rawColumns(['data_status', 'problem'])
            ->make(true);
    }

    // 2. Data untuk Chart (Analytics)
    public function getChartData(Request $request)
    {
        $query = MonitoringLog::with('parameter');

        // Apply Filter yang sama dengan tabel
        if ($request->stack_id) $query->where('stack_id', $request->stack_id);
        if ($request->parameter_id) $query->where('parameter_id', $request->parameter_id);
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->period) {
            $this->applyPeriodFilter($query, $request->period);
        }

        $logs = $query->get();

        // Hitung Statistik
        $abnormal = 0;
        $normal = 0;

        foreach ($logs as $log) {
            $threshold = $log->parameter->max_threshold ?? 0;
            if ($log->value > $threshold) {
                $abnormal++;
            } else {
                $normal++;
            }
        }

        return response()->json([
            'abnormal' => $abnormal,
            'overrange' => 0, // Dummy (bisa dikembangkan logicnya)
            'not_recorded' => 0, // Dummy
            'not_sent' => 0 // Dummy
        ]);
    }

    // Helper Filter Tanggal
    private function applyPeriodFilter($query, $period)
    {
        switch ($period) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()]);
                break;
            case 'month':
                $query->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]);
                break;
        }
    }
}