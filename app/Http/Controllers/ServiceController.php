<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);

        return view('services.index', compact('services'));
    }

    public function create()
    {
        $service = new Service(['unit' => 'kg', 'estimated_days' => 2, 'is_active' => true]);

        return view('services.create', compact('service'));
    }

    public function store(Request $request)
    {
        Service::create($this->validated($request));

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($this->validated($request));

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->transactions()->exists()) {
            return back()->with('error', 'Layanan sudah dipakai transaksi. Nonaktifkan saja, jangan dihapus.');
        }

        $service->delete();

        return back()->with('success', 'Layanan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'unit' => ['required', Rule::in(['kg', 'pcs'])],
            'price' => ['required', 'integer', 'min:0', 'max:10000000'],
            'estimated_days' => ['required', 'integer', 'min:0', 'max:60'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}