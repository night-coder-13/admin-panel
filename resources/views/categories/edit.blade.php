@extends('layout.master')

@section('title', 'category create')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش ویژگی</h4>
    </div>
    <p class="text-success">
        @if (session()->has('success'))
            <img src="{{ asset('svg/success.svg') }}" width="24" alt="">

            {{ session('success') }}
        @endif
    </p>

    <form action="{{ route('category.update', ['category' => $category->id]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">نام دسته</label>
            <input name="name" value="{{ $category->name }}" type="text" class="form-control"
                placeholder="عنوان ..." />
            <div class="form-text text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option {{ $category->status ? 'selected' : '' }} value="1">فعال</option>
                <option {{ $category->status ? 'selected' : '' }} value="0">غیر فعال</option>
            </select>
            <div class="form-text text-danger">
                @error('icon')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <a href="{{ route('category.index') }}" class="btn btn-warning mt-3 mx-3">
                برگشت
            </a>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش دسته
            </button>
        </div>
    </form>
@endsection
