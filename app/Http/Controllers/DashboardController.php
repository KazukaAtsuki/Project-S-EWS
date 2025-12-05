<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Level;
use App\Models\Industry; // [BARU] Import Industry untuk filter dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request) // [BARU] Tambahkan Request $request
    {
        // --- 1. STATISTIK (Tetap Sama) ---
        $totalCompanies = Company::count();
        $totalUsers = User::count();
        $totalLevels = Level::count();
        $activeUsers = User::where('is_active', true)->count();

        // --- 2. LOGIKA FILTER COMPANIES (Baru) ---
        // Mulai query builder
        $query = Company::with('industryRelation')
            ->orderBy('created_at', 'desc');

        // A. Filter Pencarian (Nama atau Kode)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_code', 'like', "%{$search}%");
            });
        }

        // B. Filter Berdasarkan Industry
        if ($request->filled('industry_id')) {
            $query->where('industry_id', $request->industry_id);
        }

        // Eksekusi Query (Get Data)
        $companies = $query->get();

        // --- 3. DATA PENDUKUNG ---
        // Ambil semua industri untuk isi dropdown di Modal Filter
        $industries = Industry::all();

        // Get current user
        $user = Auth::user();

        return view('dashboard', compact(
            'companies',
            'totalCompanies',
            'totalUsers',
            'totalLevels',
            'activeUsers',
            'user',
            'industries' // [BARU] Kirim variabel industries ke view
        ));
    }
}