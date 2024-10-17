@extends('layout.master')

@section('title', 'Feature')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویژگی ها</h4>
        <div>
            <a href="{{ route('feature.create') }}" class="btn btn-sm btn-outline-primary">ایجاد ویژگی</a>
        </div>
    </div>

    @if (count($features) == 0)
        <div class="text-center">
            <p class="mt-5 mb-3">موردی یافت نشد !</p>
            <a href="{{ route('feature.create') }}" class="btn btn-sm btn-outline-primary">ایجاد اسلایدر</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>آیکن</th>
                        <th>متن</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($features as $feature)
                        <tr>
                            <td>{{ $feature->title }}</td>
                            <td>{{ $feature->icon }}</td>
                            <td>{{ $feature->body }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('feature.edit', ['feature' => $feature->id]) }}"
                                        class="btn btn-sm btn-outline-info me-2">ویرایش</a>
                                    <form action="{{ route('feature.destroy', ['feature' => $feature->id]) }}" method="post">
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
