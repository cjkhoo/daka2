@extends('layouts.admin')
@section('title', '人員管理')

@section('header', 'Dashboard')

@section('content')
<div class="container">
    <h2>人員管理</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">創建新人員</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>姓名</th>
                <th>等級</th>
                <th>上班地點</th>
                <th>變動</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @foreach($users as $user)
            <tr>
                <td>{{ $counter }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->name }}</td>                
                <td>
                    @if($user->user_level == 1)
                        A
                    @elseif($user->user_level == 2)
                       B
                    @else
                        C
                    @endif
                </td>
                <td>{{ $user->loc_name ?? '' }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">修改</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">刪除</button>
                    </form>
                </td>
            </tr>
            @php $counter++; @endphp
            @endforeach
        </tbody>
    </table>
     <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
      {{ $users->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection