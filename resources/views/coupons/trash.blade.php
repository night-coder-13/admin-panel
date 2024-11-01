@extends('layout.master')

@section('title', 'coupons')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">دسته های حذف شده</h4>
        <div>
            <a href="{{ route('coupon.index') }}" class="btn btn-sm btn-outline-primary">بازگشت</a>
        </div>
    </div>

    @if (count($coupons) == 0)
        <div class="text-center">
            <p class="mt-5 mb-3">موردی یافت نشد !</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>کد تخفیف</th>
                        <th>درصد تخفیف</th>
                        <th>تاریخ انقضاء</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->percentage }}</td>
                            <td>{{ $coupon->expired_at }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('coupon.restore', ['coupon' => $coupon->id]) }}"
                                        class="btn btn-sm btn-outline-info me-2">بازیابی</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="navigation">
                <ul class="pagination">
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                </ul>
            </nav>
        </div>
    @endif
@endsection
