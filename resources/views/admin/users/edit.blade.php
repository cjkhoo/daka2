@extends('layouts.admin')
@section('title', '修改員工資料')


@section('content')
<div class="container">
    <h2>修改員工資料</h2>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="username">ID</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required readonly>
        </div>
        <div class="form-group mb-3">
            <label for="name">姓名</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>        
        <div class="form-group mb-3">
            <label for="location" class="form-label">上班地點</label>
            <select name="loc_id" id="location" class="form-select select2">
                <option value="">選擇地點</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ $user->loc_id == $location->id ? 'selected' : '' }}>
                        {{ $location->loc_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="password">密碼（留空以保留目前密碼）</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group mb-3">
            <label for="user_level">等級</label>
            <select class="form-control" id="user_level" name="user_level" required>    
            <option value="1" {{ $user->user_level == 1 ? 'selected' : '' }}>A</option>            
                <option value="2" {{ $user->user_level == 2 ? 'selected' : '' }}>B</option>
                <option value="3" {{ $user->user_level == 3 ? 'selected' : '' }}>C</option>
            </select>
        </div>
        <div class="form-group mb-3" >
            <button type="submit" class="btn btn-primary">修改</button>
        </div>
    </form>
</div>
@endsection