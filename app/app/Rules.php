<?php

namespace App;

enum Rules:string
{
    case Checker1 = 'checker1';
    case Checker2 = 'checker2';
    case Checker3 = 'checker3';
    case Administrator = 'administrator';
    case AdminWarehouse = 'adminwarehouse';
    case AdminSales = 'adminsales';
    case Supervisor = 'supervisor';

    public function label(): string
    {
        return match($this) {
            self::Checker1 => 'Checker 1',
            self::Checker2 => 'Checker 2',
            self::Checker3 => 'Checker 3',
            self::Administrator => 'Administrator',
            self::AdminWarehouse => 'Admin Warehouse',
            self::AdminSales => 'Admin Sales',
            self::Supervisor => 'Supervisor',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
