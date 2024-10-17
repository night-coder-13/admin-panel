@extends('layout.master')

@section('title', 'feature create')

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

    <form action="{{ route('feature.update' , ['feature' => $feature->id]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input name="title" value="{{ $feature->title }}" type="text" class="form-control" placeholder="عنوان ..." />
            <div class="form-text text-danger">
                @error('title')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">آیکن</label>
            <input name="icon" value="{{ $feature->icon }}" type="text" class="form-control" placeholder="کلاس آیکن ..." />
            <div class="form-text text-danger">
                @error('icon')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" class="form-control" rows="3" placeholder="متن خود را وارد کنید ...">{{ $feature->body }}</textarea>
            <div class="form-text text-danger">
                @error('body')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <a href="{{ route('feature.index') }}" class="btn btn-warning mt-3 mx-3">
                برگشت
            </a>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش ویژگی
            </button>
        </div>
    </form>
@endsection
