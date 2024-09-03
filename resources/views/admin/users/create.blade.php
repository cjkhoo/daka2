@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create New User</h1>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="name">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
         <div class="form-group mb-3">
            <label for="location" class="form-label">地点</label>
            <select name="loc_id" id="location" class="form-select select2">
                <option value="">选择地点</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" }}>
                        {{ $location->loc_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="form-group">
            <label for="user_level">User Level</label>
            <select class="form-control" id="user_level" name="user_level" required>               
                <option value="2">Staff In</option>
                <option value="3">Staff Out</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection