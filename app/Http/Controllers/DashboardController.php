<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isClient()) {
            $orders = Transaction::with('service')
                ->where('customer_id', $user->id)
                ->latest()->take(5)->get();

            $active = Transaction::where('customer_id', $user->id)
                ->whereNotIn('status', ['done', 'cancelled'])->count();

            return view('dashboard.client', compact('orders', 'active'));
        }

        $stats = [
            'pending' => Transaction::where('status', 'pending')->count(),
            'in_progress' => Transaction::whereIn('status', ['received', 'washing', 'ironing'])->count(),
            'ready' => Transaction::where('status', 'ready')->count(),
            'revenue' => Transaction::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total'),
        ];

        $latest = Transaction::with('service')->latest()->take(5)->get();

        return view('dashboard.admin', compact('stats', 'latest'));
    }
}