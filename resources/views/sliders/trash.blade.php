@extends('layout.master')

@section('title', 'Sliders')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">اسلایدر ها</h4>
        <div>
            <a href="{{ route('slider.index') }}" class="btn btn-sm btn-outline-primary">بازگشت</a>
        </div>
    </div>

    @if (count($sliders) == 0)
        <div class="text-center">
            <p class="mt-5 mb-3">موردی یافت نشد !</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>عنوان لینک</th>
                        <th>آدرس لینک</th>
                        <th>متن</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                        <tr>
                            <td>{{ $slider->title }}</td>
                            <td>{{ $slider->title_url }}</td>
                            <td class="dir-ltr">{{ $slider->url }}</td>
                            <td>{{ $slider->body }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('slider.restore', ['slider' => $slider->id]) }}"
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
