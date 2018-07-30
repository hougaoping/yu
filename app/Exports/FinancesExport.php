<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\UserFinance;

class FinancesExport implements FromCollection, WithHeadings
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
            '资金变化',
            '余额',
            '时间',
        ];
    }

    public function collection()
    {
        return UserFinance::query()->withSearch($this->user)->get(['id', 'enum', 'change', 'amount', 'created_at']);
    }
}