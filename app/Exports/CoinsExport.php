<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\UserCoin;

class CoinsExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function __construct($user) {
        $this->user = $user;
    }

    // 添加表头
    public function headings(): array {
        return [
            'ID',
            '项目',
            '金币变化',
            '金币',
            '时间',
        ];
    }

    public function collection()
    {
        return UserCoin::query()->withSearch($this->user)->get(['id', 'enum', 'change', 'coin', 'created_at']);
    }
}