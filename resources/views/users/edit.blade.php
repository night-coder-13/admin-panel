@extends('layout.master')
@section('title', 'User Edit')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش کاربر</h4>
    </div>

    <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')
        <div class="col-md-3">
            <label class="form-label">نام</label>
            <input name="name" type="text" value="{{ $user->name }}" class="form-control" />
            <div class="form-text text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">شماره تلفن</label>
            <input name="cellphone" type="text" value="{{ $user->cellphone }}" class="form-control" />
            <div class="form-text text-danger">
                @error('cellphone')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">ایمیل</label>
            <input name="email" type="text" value="{{ $user->email }}" class="form-control" />
            <div class="form-text text-danger">
                @error('email')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">پسورد</label>
            <input name="password" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('password')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">نقش ها</label>
            <select name="role_ids[]" multiple class="form-select">
                @php
                    $userRoleIds = $user->roles()->pluck('id')->toArray();
                @endphp
                @foreach ($roles as $role)
                    <option {{ in_array($role->id, $userRoleIds) ? 'selected' : '' }} value={{ $role->id }}>
                        {{ $role->name }}</option>
                @endforeach
            </select>
            <div class="form-text text-danger">
                @error('role_ids')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش کاربر
            </button>
        </div>
    </form>
@endsection
