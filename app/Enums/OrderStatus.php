<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'PENDING';
    case PREPARING = 'PREPARING';
    case OUT_FOR_DELIVERY = 'OUT_FOR_DELIVERY';
    case COMPLETED = 'COMPLETED';
    case CANCELED = 'CANCELED';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::PREPARING => 'Em preparo',
            self::OUT_FOR_DELIVERY => 'Saiu para entrega',
            self::COMPLETED => 'Entregue',
            self::CANCELED => 'Cancelado'
        };
    }
}
