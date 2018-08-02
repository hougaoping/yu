<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\UserCoin;
use Auth;

class CoinsExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function __construct() {
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

    public function map($finances): array
    {
        return [
            $finances->id,
            $finances->type,
            $finances->change,
            $finances->coin,
            $finances->created_at,
        ];
    }


    public function collection()
    {
        return UserCoin::query()->withSearch(Auth::id())->get();
    }
}