@extends('layout.master')

@section('title', 'Slider create')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش اسلایدر</h4>
    </div>
    <p class="text-success">
        @if (session()->has('success'))
            <img src="{{ asset('svg/success.svg') }}" width="24" alt="">

            {{ session('success') }}
        @endif
    </p>

    <form action="{{ route('slider.update' , ['slider' => $slider->id]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">عنوان</label>
            <input name="title" value="{{ $slider->title }}" type="text" class="form-control" placeholder="عنوان ..." />
            <div class="form-text text-danger">
                @error('title')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">عنوان لینک</label>
            <input name="title_url" value="{{ $slider->title_url }}" type="text" class="form-control" placeholder="عنوان لینک ..." />
            <div class="form-text text-danger">
                @error('title_url')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">آدرس لینک</label>
            <input name="url" value="{{ $slider->url }}" type="text" class="form-control" placeholder="لینک ..." />
            <div class="form-text text-danger">
                @error('url')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <label class="form-label">متن</label>
            <textarea name="body" class="form-control" rows="3" placeholder="متن خود را وارد کنید ...">{{ $slider->body }}</textarea>
            <div class="form-text text-danger">
                @error('body')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <a href="{{ route('slider.index') }}" class="btn btn-warning mt-3 mx-3">
                برگشت
            </a>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش اسلایدر
            </button>
        </div>
    </form>
@endsection
