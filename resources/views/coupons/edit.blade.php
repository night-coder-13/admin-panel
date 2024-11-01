@extends('layout.master')

@section('title', 'coupon create')

@section('link')
    <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
@endsection

@section('script')
    <script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
    <script>
        jalaliDatepicker.startWatch({
            time: true
        });
    </script>
@endsection

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

    <form action="{{ route('coupon.update', ['coupon' => $coupon->id]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')
        <div class="col-md-3">
            <label class="form-label">کد تخفیف</label>
            <input name="code" value="{{ $coupon->code }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('code')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">درصد تخفیف</label>
            <input name="percentage" value="{{ $coupon->percentage }}" type="text" class="form-control" />
            <div class="form-text text-danger">
                @error('percentage')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ انقضا</label>
            <input data-jdp name="expired_at"  type="text" class="form-control" value="{{ getJalaliDate($coupon->expired_at) }}" />
            <div class="form-text text-danger">
                @error('expired_at')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div>
            <a href="{{ route('coupon.index') }}" class="btn btn-warning mt-3 mx-3">
                برگشت
            </a>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش کد تخفیف
            </button>
        </div>
    </form>
@endsection
