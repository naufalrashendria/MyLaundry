<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case Pending = 'pending';
    case Received = 'received';
    case Washing = 'washing';
    case Ironing = 'ironing';
    case Ready = 'ready';
    case Done = 'done';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Konfirmasi',
            self::Received => 'Diterima',
            self::Washing => 'Dicuci',
            self::Ironing => 'Disetrika',
            self::Ready => 'Siap Diambil',
            self::Done => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }
}