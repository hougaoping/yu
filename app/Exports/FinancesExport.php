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

    public function __construct($user, $enum, $start_time, $end_time) {
        $this->user       = $user;
        $this->enum       = $enum;
        $this->start_time = $start_time;
        $this->end_time   = $end_time;
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
        return UserFinance::query()->withSearch($this->user, $this->enum, $this->start_time, $this->end_time)->get(['id', 'enum', 'change', 'amount', 'created_at']);
    }
}