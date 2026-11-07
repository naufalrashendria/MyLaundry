<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'code', 'customer_id', 'customer_name', 'customer_phone', 'service_id',
        'weight', 'price', 'total', 'status', 'payment_status', 'source',
        'notes', 'created_by', 'due_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => TransactionStatus::class,
            'weight' => 'decimal:2',
            'due_at' => 'datetime',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function generateCode(): string
    {
        $prefix = 'LDR-'.now()->format('Ymd').'-';

        $last = static::where('code', 'like', $prefix.'%')->orderByDesc('code')->value('code');
        $next = $last ? ((int) substr($last, -3)) + 1 : 1;

        return $prefix.str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    public static function calculateTotal(int $price, float|string $weight): int
    {
        return (int) ceil($price * (float) $weight);
    }
}