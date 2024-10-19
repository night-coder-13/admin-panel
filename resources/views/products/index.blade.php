@extends('layout.master')

@section('title', 'product')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">محصولات ها</h4>
        <div>
            <a href="{{ route('product.create') }}" class="btn btn-sm btn-outline-primary">ایجاد محصول</a>
            @if ($trash)
                <a href="{{ route('product.trash') }}" class="btn btn-sm btn-outline-danger mx-1">حذف شده ها</a>
            @endif
        </div>
    </div>

    @if (count($products) == 0)
        <div class="text-center">
            <p class="mt-5 mb-3">موردی یافت نشد !</p>
            <a href="{{ route('product.create') }}" class="btn btn-sm btn-outline-primary">ایجاد محصول</a>
        </div>
    @else
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
                                <img src="{{ asset('images/products/' . $product->primary_image) }}" class="rounded" width="100" alt="product-image">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ number_format($product->price) }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->status ? 'فعال' : 'غیر فعال' }}</td>
    
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('product.show', ['product' => $product->id]) }}"
                                        class="btn btn-sm btn-outline-primary me-2">نمایش</a>
    
                                    <a href="{{ route('product.edit', ['product' => $product->id]) }}"
                                        class="btn btn-sm btn-outline-info me-2">ویرایش</a>
    
                                    <form action="{{ route('product.destroy', ['product' => $product->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                </div>
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
