<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalCompanies = Company::count();
        $totalUsers = User::count();
        $totalLevels = Level::count();
        $activeUsers = User::where('is_active', true)->count();

        // Get companies with their industry
        $companies = Company::with('industryRelation')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get current user
        $user = Auth::user();

        return view('dashboard', compact(
            'companies',
            'totalCompanies',
            'totalUsers',
            'totalLevels',
            'activeUsers',
            'user'
        ));
    }
}