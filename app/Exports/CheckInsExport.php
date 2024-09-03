<?php

namespace App\Exports;

use App\Models\CheckIn;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CheckInsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $user_id;
    protected $year;
    protected $month;

    public function __construct($user_id, $year, $month)
    {
        $this->user_id = $user_id;
        $this->year = $year;
        $this->month = $month;
    }

    public function query()
    {
        return CheckIn::query()
            ->where('user_id', $this->user_id)
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->where('is_delete', 0);
    }

    public function headings(): array
    {
        return [
            '日期',
            '姓名',
            '地點',
            '地點 (經度,緯度)',
            '上班時間',
            '上班 (經度,緯度)',
            '上班距離工作地點',
            '下班時間',
            '下班 (經度,緯度)',
            '下班距離工作地點',
        ];
    }

    public function map($checkIn): array
    {
        return [
            $checkIn->date,
            $checkIn->user_name,
            $checkIn->loc_name,
            $checkIn->loc_latlong,
            $checkIn->check_in_time,
            $checkIn->check_in_latlong,
            $checkIn->check_in_distance,
            $checkIn->check_out_time,
            $checkIn->check_out_latlong,
            $checkIn->check_out_distance,
        ];
    }
}