@extends('layouts.web')
@section('title', '更换工作地点')

@section('content')
<div class="containe  mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        	 <p><h2><a href="{{route('checkin')}}">{{config('view.company.name')}}</a></h2></p>
            <div class="card">
                <div class="card-header">{{ __('更换工作地点') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('location.change.post') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('目前上班地點') }}</label>

                            <div class="col-md-6">
                        
					   <select name="loc_id" id="location" class="custom-select">
						    <option value="">選擇地點</option>
						    @foreach($locations as $location)
						        <option value="{{ $location->id }}" {{ $user->loc_id == $location->id ? 'selected' : '' }}>
						            {{ $location->loc_name }}
						        </option>
						    @endforeach
						</select>


                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                   


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('提交') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
