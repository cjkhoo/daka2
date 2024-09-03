@extends('layouts.admin')
@section('title', '新增工作地點')


@section('content')
<div class="container">
    <h1>新增工作地點</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.locations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="loc_name">地點名稱</label>
            <input type="text" class="form-control" id="loc_name" name="loc_name" value="{{ old('loc_name') }}" required>
        </div>
        <div class="form-group">
            <label for="code">代號</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
        </div>
        <div class="form-group">
            <label for="latitude">經度</label>
            <input type="number" step="any" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}" required>
        </div>
        <div class="form-group">
            <label for="longitude">緯度</label>
            <input type="number" step="any" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}" required>
        </div>
        <div class="form-group">
            <label for="start_date">建立日期</label>
            <input type="date" class="form-control datepicker" id="start_date" name="start_date" value="{{ old('start_date') }}" >
        </div>
        <div class="form-group">
            <label for="end_date">結束日期</label>
            <input type="date" class="form-control datepicker" id="end_date" name="end_date" value="{{ old('end_date') }}" >
        </div>
         <div class="form-group">
        <button type="submit" class="btn btn-primary">新增地點</button>
        </div>
    </form>
</div>
@endsection

