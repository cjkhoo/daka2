<?php

namespace App\Exports;

use App\Models\User;
use App\Models\CheckIn;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class CheckInsExportAll implements WithMultipleSheets
{
    protected $year;
    protected $month;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        
        // Get all active users
        $users = User::where('is_delete', 0)->get();
        
        // Create a sheet for each user
        foreach ($users as $user) {
            $sheets[] = new UserCheckInSheet($user, $this->year, $this->month);
        }
        
        return $sheets;
    }
}

class UserCheckInSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    protected $user;
    protected $year;
    protected $month;
    protected $checkInCount;

    public function __construct(User $user, $year, $month)
    {
        $this->user = $user;
        $this->year = $year;
        $this->month = $month;
        $this->checkInCount = 0;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Date range for the month
        $startDate = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($this->year, $this->month, 1)->endOfMonth();
        
        // Get all check-ins for this user in the specified month
           $checkIns = CheckIn::where('user_id', $this->user->id)
            ->where('is_delete', 0)
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->when($this->user->user_level != 1, function ($query) {
                return $query->orderBy('date');
            })
            ->get();
        
        $this->checkInCount = $checkIns->count();
        
        // Determine shift times based on user level
        $shift = $this->user->user_level == 2 ? 'A' : 'B';
        $startTime = $this->user->user_level == 2 ? '08:00:00' : '08:30:00';
        $endTime = $this->user->user_level == 2 ? '17:00:00' : '17:30:00';
        
        // Transform data for the Excel sheet
        return $checkIns->map(function ($checkIn) use ($shift) {
            $checkInTime = $checkIn->check_in_time ? Carbon::parse($checkIn->check_in_time) : null;
            $checkOutTime = $checkIn->check_out_time ? Carbon::parse($checkIn->check_out_time) : null;
            
            // Calculate total work hours when both check-in and check-out times exist
            $workHours = '';
            if ($checkInTime && $checkOutTime) {
                $minutes = $checkOutTime->diffInMinutes($checkInTime);
                $hours = floor($minutes / 60);
                $remainingMinutes = $minutes % 60;
                $workHours = $hours . ':' . str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT);
            }
            
            return [
                '日期' => $checkIn->date,
                '姓名' => $this->user->name,
                '班別' => $shift,
                '上班地點' => $checkIn->check_in_loc_name,
                '上班地點 (經度,緯度)' => $checkIn->check_in_loc_latlong,
                '上班時間' => $checkIn->check_in_time,
                '上班 (經度,緯度)' => $checkIn->check_in_latlong,
                '上班距離工作地點' => $checkIn->check_in_distance,
                '下班地點' => $checkIn->check_out_loc_name,
                '下班地點 (經度,緯度)' => $checkIn->check_out_loc_latlong,
                '下班時間' => $checkIn->check_out_time,
                '下班 (經度,緯度)' => $checkIn->check_out_latlong,
                '下班距離工作地點' => $checkIn->check_out_distance,
                '上班總時間' => $workHours,
                
            ];
        });
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->user->name;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '日期',
            '姓名',
            '班別',
            '上班地點',
            '上班地點 (經度,緯度)',
            '上班時間',
            '上班 (經度,緯度)',
            '上班距離工作地點',
            '下班地點',
            '下班地點 (經度,緯度)',
            '下班時間',
            '下班 (經度,緯度)',
            '下班距離工作地點',
            '上班總時間',
            
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
{
    // Bold headings
    $styles = [
        1 => ['font' => ['bold' => true]],
    ];
    
    // Add total row after the data
    $totalRow = $this->checkInCount + 2;
    $sheet->setCellValue('A' . $totalRow, '總工作天數:');
    $sheet->setCellValue('B' . $totalRow, $this->checkInCount);
    $styles[$totalRow] = ['font' => ['bold' => true]];
    
    // Determine standard times based on shift type (A or B)
    $requiredStartTime = $this->user->user_level == 2 ? '08:00:00' : '08:30:00';
    $requiredEndTime = $this->user->user_level == 2 ? '17:00:00' : '17:30:00';
    
    // Create conditional formatting rules
    $conditionalStyles = [];
    
    // Late check-in (column F)
    $conditionalStyles['F'] = new Conditional();
    $conditionalStyles['F']->setConditionType(Conditional::CONDITION_EXPRESSION)
        ->setOperatorType(Conditional::OPERATOR_NONE)
        ->addCondition('AND(NOT(ISBLANK(F2)),TIMEVALUE(F2)>TIMEVALUE("' . $requiredStartTime . '"))')
        ->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
    
    // Early check-out (column K)
    $conditionalStyles['K'] = new Conditional();
    $conditionalStyles['K']->setConditionType(Conditional::CONDITION_EXPRESSION)
        ->setOperatorType(Conditional::OPERATOR_NONE)
        ->addCondition('AND(NOT(ISBLANK(K2)),TIMEVALUE(K2)<TIMEVALUE("' . $requiredEndTime . '"))')
        ->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
    
    // Check-in distance > 500 (column H)
    $conditionalStyles['H'] = new Conditional();
    $conditionalStyles['H']->setConditionType(Conditional::CONDITION_EXPRESSION)
        ->setOperatorType(Conditional::OPERATOR_NONE)
        ->addCondition('AND(NOT(ISBLANK(H2)),H2>500)')
        ->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
    
    // Check-out distance > 500 (column M)
    $conditionalStyles['M'] = new Conditional();
    $conditionalStyles['M']->setConditionType(Conditional::CONDITION_EXPRESSION)
        ->setOperatorType(Conditional::OPERATOR_NONE)
        ->addCondition('AND(NOT(ISBLANK(M2)),M2>500)')
        ->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
    
    // Apply conditional formatting to relevant columns for all data rows
    foreach (['F', 'K', 'H', 'M'] as $column) {
        $columnRange = $column . '2:' . $column . ($this->checkInCount + 1);
        $sheet->getStyle($columnRange)->setConditionalStyles([$conditionalStyles[$column]]);
    }
    
    return $styles;
}
}