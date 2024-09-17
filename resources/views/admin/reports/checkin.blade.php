@extends('layouts.admin')
@section('title', '人員管理')

@section('header', 'CheckIn report')

@section('content')
<div class="container">
    <h2>打卡報告</h2>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <form  class="form-inline" action="{{ route('admin.report.checkin') }}" method="GET">
    

            <div class="form-group col-md-4" style="display: -webkit-inline-box;">
                 <input type="month" id="date" style="padding: 6px;" name="date" min="2024-04" value="{{ request('date') }}"/> 
                      <select name="user_id" id="user_id" class="form-select">
                    <option value=""> - </option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                    @endforeach   
                    </select>      
                                <button type="submit" class="btn btn-primary ">篩選</button>

            </div>
      
        
    
    </form>
    
     <div style="display: flex;margin-top:8px;">
         <button  type="input" class="btn btn-danger" onclick="confirmDelete()">確認刪除</button>
         <form id="deleteForm" action="{{ route('admin.report.checkin.destroy') }}" method="POST">
                                <input type="hidden" name="date" value="{{ request('date') }}">
                        <input type="hidden" name="user_id" value="{{ request('user_id') }}">

  
                        @csrf
                        @method('DELETE')
                    
                       
                    </form>
                    <form action="{{ route('admin.checkins.export') }}" method="GET" class="d-inline">
    <input type="hidden" name="date" value="{{ request('date') }}">
                        <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                         <input type="hidden" name="name" value="{{ $user->username }}">
    <button style="margin-left: 5px"  type="submit" class="btn btn-success">匯出到 Excel</button>
</form>

     </div>
       
    <table class="table" style="margin-top:50px">
        <thead>
            <tr>
                <th>日期</th>
                <th>姓名</th>
                <th>地點</th>
                <th>地點 (經度,緯度)</th>
                <th>上班時間</th>
                <th>上班 (經度,緯度)</th>
                <th>上班距離工作地點</th>
                <th>下班時間</th>
                <th>下班 (經度,緯度)</th>
                <th>下班距離工作地點</th>
    
            </tr>
        </thead>
        <tbody>
        
        @foreach($attendances as $attendance)
            @php
                        $highlight = false;
                 
                        if($user->user_level==2){
                            if ($attendance->check_in_distance  > 100 || 
                            $attendance->check_in_time?->format('H:i') > '08:30') {
                            $highlight = true;
                         }
                        }elseif($user->user_level==3){
                            if ($attendance->check_in_distance  > 100 || 
                            $attendance->check_in_time?->format('H:i') > '08:00') {
                            $highlight = true;
                         }
                        }
            @endphp           
            <tr class="{{ $highlight ? 'table-warning' : '' }}">
          
                <td>{{ $attendance->date?->format('Y-m-d') }}</td>
                <td>{{ $attendance->user_name }}</td>
                <td>{{ $attendance->loc_name }}</td>
                <td>{{ $attendance->loc_latlong }}</td>
                <td class="checkin">{{ $attendance->check_in_time?->format('H:i:s') }}</td>
                <td>{{ $attendance->check_in_latlong }}</td>
                <td>{{ $attendance->check_in_distance }}</td>
                <td class="checkout">{{ $attendance->check_out_time?->format('H:i:s') }}</td>
                <td>{{ $attendance->check_out_latlong }}</td>
                <td>{{ $attendance->check_out_distance }}</td>
        
            </tr>
            @endforeach
        </tbody>
    </table>


</div>
<script>
function confirmDelete() {
    var user_id = document.getElementById('user_id').value;
      var selectElement = document.getElementById('user_id');
    
    // Get the selected option
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    
    // Get the text (name) of the selected option
    var selectedOptionName = selectedOption.text;
    var date = document.getElementById('date').value;


    if (!user_id || !user_id ) {
        alert('刪除前請選擇使用者、日期並點選篩選器。');
        return;
    }

    if (confirm('您確定要刪除' + selectedOptionName + '  ' +date + '的記錄嗎?')) {
   
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection

@section('styles')
<style>
    .table-warning {
        background-color: red;
    }
    .checkin {
        background-color: #98F5F9 !important;
    }
    .checkout {
        background-color: #D8F4CE !important;
    }
</style>
@endsection