@extends('layout.master')

@section('title', 'category')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">دسته بندی ها</h4>
        <div>
            <a href="{{ route('category.create') }}" class="btn btn-sm btn-outline-primary">ایجاد دسته</a>
            @if ($trash)
                <a href="{{ route('category.trash') }}" class="btn btn-sm btn-outline-danger mx-1">حذف شده ها</a>
            @endif
        </div>
    </div>

    @if (count($categories) == 0)
        <div class="text-center">
            <p class="mt-5 mb-3">موردی یافت نشد !</p>
            <a href="{{ route('category.create') }}" class="btn btn-sm btn-outline-primary">ایجاد دسته</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>نام دسته</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->status ? 'فعال' : 'غیرفعال' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('category.edit', ['category' => $category->id]) }}"
                                        class="btn btn-sm btn-outline-info me-2">ویرایش</a>
                                    <form action="{{ route('category.destroy', ['category' => $category->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>
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
