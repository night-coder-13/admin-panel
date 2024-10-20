@extends('layout.master')

@section('title', 'product')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">محصولات حذف شده</h4>
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">بازگشت</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>تصویر</th>
                    <th>نام</th>
                    <th>دسته بندی</th>
                    <th>قیمت</th>
                    <th>تعداد</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset('images/products/' . $product->primary_image) }}" class="rounded" width="100"
                                alt="product-image">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ number_format($product->price) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->status ? 'فعال' : 'غیر فعال' }}</td>

                        <td>
                            <div class="d-flex">
                                <a href="{{ route('product.restore', ['product' => $product->id]) }}"
                                    class="btn btn-sm btn-outline-primary me-2">بازیابی</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{-- {{ $products->links('layout.paginate') }} --}}
    </div>
@endsection
