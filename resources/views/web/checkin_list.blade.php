<!-- resources/views/checkin/list.blade.php -->
@extends('layouts.web')
@section('title', '登入頁面')
@section('content')



@section('content')
<div class="container mt-4">
     <p><h2><a href="{{route('checkin')}}">{{config('view.company.name')}}</a></h2></p>


@php
    $monthNames = [
        'January' => '一月',
        'February' => '二月',
        'March' => '三月',
        'April' => '四月',
        'May' => '五月',
        'June' => '六月',
        'July' => '七月',
        'August' => '八月',
        'September' => '九月',
        'October' => '十月',
        'November' => '十一月',
        'December' => '十二月',
    ];
@endphp
<a href="http://daka.test/logout" style="float: right">登出</a>
<form action="{{ route('checkin.list') }}" method="GET" class="mb-4">
    <div class="form-group">
        <label for="month">選擇月份:</label>

        <select name="month" id="month" class="form-control" onchange="this.form.submit()">
            @foreach ($months as $month)
                @php
                    $monthName = Carbon\Carbon::parse($month)->format('F');
                    $chineseMonthName = $monthNames[$monthName];
                @endphp
                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                    {{ $chineseMonthName . ' ' . Carbon\Carbon::parse($month)->format('Y年') }}
                </option>
            @endforeach
        </select>
    </div>
</form>

  

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>日期</th>
                    <th>地點</th>
                    <th>上班時間</th>
                    <th>上班 (經度,緯度)</th>
                    <th>上班距離工作地點</th>
                    <th>下班時間</th>
                    <th>下班 (經度,緯度)</th>
                    <th>下班距離工作地點</th>
                </tr>
            </thead>
            <tbody>
<!--                     if ($checkin->check_in_distance > 100 || 
                            $checkin->check_out_distance > 100 ||
                            $checkInTime->format('H:i') > '09:00' ||
                            $checkOutTime->format('H:i') < '18:00')  -->
                @foreach ($checkins as $checkin)
                    @php
                        $highlight = false;
                 
                        if($user->user_level==2){
                            if ($checkin->check_in_distance > 100 || 
                            $checkin->check_in_time?->format('H:i') > '08:30') {
                            $highlight = true;
                         }
                        }elseif($user->user_level==3){
                            if ($checkin->check_in_distance > 100 || 
                            $checkin->check_in_time?->format('H:i') > '08:00') {
                            $highlight = true;
                         }
                        }
                        
                    @endphp
                    <tr class="{{ $highlight ? 'warning' : '' }}">
                        <td>{{ $checkin->date->format('Y-m-d') }}</td>
                        <td>{{ $checkin->loc_name }}</td>
                        <td>{{ $checkin->check_in_time->format('H:i') }}</td>
                       <td>{{ $checkin->check_in_latlong }}</td>
                        <td>{{ $checkin->check_in_distance }}m</td>
                         <td>{{$checkin->check_out_time?->format('H:i') }}</td>
                         <td>{{ $checkin->check_out_latlong }}</td>
                        <td>{{ $checkin->check_out_distance }}m</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
<style>
    .warning {
        background-color: red !important;
    }
</style>
@endsection