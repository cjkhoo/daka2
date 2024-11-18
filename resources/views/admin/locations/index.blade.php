@extends('layouts.admin')

@section('content')
<div class="container">
    <h1> 工作地點</h1>
    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary mb-3">新增工作地點</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>地點名稱</th>
                <th>代號</th>
                <th>緯度,經度</th>
                <th>建立日期</th>
                <th>結束日期</th>
                <th>變動</th>
            </tr>
        </thead>
        <tbody>
            @foreach($locations as $location)
                <tr>
                    <td>{{ $location->loc_name }}</td>
                    <td>{{ $location->code }}</td>
                    <td>{{ $location->latitude }}, {{ $location->longitude }}</td>
                    <td>{{ $location->start_date?->format('Y-m-d'); }}</td>
                    <td>{{ $location->end_date?->format('Y-m-d'); }}</td>
                    <td>
                        <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-sm btn-primary">修改</a>
                        <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this location?')">刪除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection