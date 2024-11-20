@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>建立新用戶</h1>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
           <div class="form-group">
                <label for="username">帳號</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">姓名</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">密碼</label>
                <input type="text" name="password" value="qwert1234" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>           
      
             <div class="form-group mb-3">
                <label for="location" class="form-label">地点</label>
                <select name="loc_id" id="location" class="form-select select2">
                    <option value="">选择地点</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" >
                            {{ $location->loc_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="form-group  mb-3">
                <label for="user_level">用戶類別</label>
                <select class="form-control" id="user_level" name="user_level" required>               
                    <option value="2">B 工地班</option>
                    <option value="3">C 公司班</option>
                </select>
            </div>
        <button type="submit" class="btn btn-primary">建立新用戶</button>
    </form>
</div>
@endsection