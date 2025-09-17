<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Antrean;
use App\Models\Jip;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPemesanan = Pemesanan::count();
        $totalAntrean = Antrean::where('status', '!=', 'selesai')->count();
        $totalJip = Jip::count();
        $totalPending = Pemesanan::where('status', 'pending')->count();
        $jipTersedia = Jip::where('status', 'tersedia')->count();
        $recentPemesanan = Pemesanan::with('paketWisata')->latest()->take(5)->get();

        // Chart: last 6 months
        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = Carbon::now()->subMonths($i);
            $chartLabels[] = $m->format('M Y');
            $chartData[] = Pemesanan::whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalPemesanan',
            'totalAntrean',
            'totalJip',
            'jipTersedia',
            'recentPemesanan',
            'chartLabels',
            'chartData',
            'totalPending'
        ));
    }
}
