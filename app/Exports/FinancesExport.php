<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\UserFinance;
use Auth;

class FinancesExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct() {
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

    public function map($finances): array
    {
        return [
            $finances->id,
            $finances->type,
            $finances->change,
            $finances->amount,
            $finances->created_at,
        ];
    }

    public function collection()
    {
        return UserFinance::query()->withSearch(Auth::id())->get();
    }
}