<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('service')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('code', 'like', "%{$request->q}%")
                  ->orWhere('customer_name', 'like', "%{$request->q}%");
            }))
            ->latest()->paginate(10)->withQueryString();

        return view('transactions.index', [
            'transactions' => $transactions,
            'statuses' => TransactionStatus::cases(),
        ]);
    }

    public function create()
    {
        return view('transactions.create', [
            'services' => Service::active()->orderBy('name')->get(),
            'clients' => User::where('role', 'client')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'client')],
            'customer_name' => ['required_without:customer_id', 'nullable', 'string', 'max:100'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'service_id' => ['required', Rule::exists('services', 'id')->where('is_active', true)],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:999'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $service = Service::findOrFail($data['service_id']);
        $customer = $data['customer_id'] ? User::find($data['customer_id']) : null;

        Transaction::create([
            'code' => Transaction::generateCode(),
            'customer_id' => $customer?->id,
            'customer_name' => $customer?->name ?? $data['customer_name'],
            'customer_phone' => $data['customer_phone'] ?? $customer?->phone,
            'service_id' => $service->id,
            'weight' => $data['weight'],
            'price' => $service->price,
            'total' => Transaction::calculateTotal($service->price, $data['weight']),
            'status' => TransactionStatus::Received,
            'payment_status' => 'unpaid',
            'source' => 'walk_in',
            'notes' => $data['notes'] ?? null,
            'created_by' => $request->user()->id,
            'due_at' => now()->addDays($service->estimated_days),
        ]);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function edit(Transaction $transaction)
    {
        $transaction->load('service');

        return view('transactions.edit', [
            'transaction' => $transaction,
            'statuses' => TransactionStatus::cases(),
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'status' => ['required', Rule::enum(TransactionStatus::class)],
            'weight' => ['required', 'numeric', 'min:0', 'max:999'],
            'payment_status' => ['required', Rule::in(['unpaid', 'paid'])],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // total dihitung ulang dari harga snapshot x berat hasil timbang
        $data['total'] = Transaction::calculateTotal($transaction->price, $data['weight']);

        $transaction->update($data);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

        public function destroy(Request $request, Transaction $transaction)
    {
        abort_unless($request->user()->isAdmin(), 403, 'Hanya admin yang boleh menghapus transaksi.');

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}