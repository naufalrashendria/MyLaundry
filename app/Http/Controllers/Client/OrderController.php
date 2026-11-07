<?php

namespace App\Http\Controllers\Client;

use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Transaction::with('service')
            ->where('customer_id', $request->user()->id)
            ->latest()->paginate(10);

        return view('client.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('client.orders.create', [
            'services' => Service::active()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => ['required', Rule::exists('services', 'id')->where('is_active', true)],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:999'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = $request->user();
        $service = Service::findOrFail($data['service_id']);

        Transaction::create([
            'code' => Transaction::generateCode(),
            'customer_id' => $user->id,
            'customer_name' => $user->name,
            'customer_phone' => $user->phone,
            'service_id' => $service->id,
            'weight' => $data['weight'], // estimasi, nanti dikoreksi admin setelah ditimbang
            'price' => $service->price,
            'total' => Transaction::calculateTotal($service->price, $data['weight']),
            'status' => TransactionStatus::Pending,
            'payment_status' => 'unpaid',
            'source' => 'online',
            'notes' => $data['notes'] ?? null,
            'created_by' => $user->id,
            'due_at' => now()->addDays($service->estimated_days),
        ]);

        return redirect()->route('client.orders.index')->with('success', 'Pesanan berhasil dibuat. Tunggu konfirmasi dari kami.');
    }

    public function cancel(Request $request, Transaction $transaction)
    {
        // Pelanggan hanya boleh membatalkan pesanannya sendiri
        abort_unless($transaction->customer_id === $request->user()->id, 403);

        if ($transaction->status !== TransactionStatus::Pending) {
            return back()->with('error', 'Pesanan yang sudah diproses tidak bisa dibatalkan.');
        }

        $transaction->update(['status' => TransactionStatus::Cancelled]);

        return back()->with('success', 'Pesanan dibatalkan.');
    }
}