@extends('layout.master')
@section('title', 'product create')

@section('link')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
@endsection


@section('script')
    <script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageViewer', (src = '') => ({
                imageUrl: src,

                fileChosen(event) {
                    if (event.target.files.length == 0) return;

                    let file = event.target.files[0];
                    let reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => this.imageUrl = e.target.result
                }
            }));

            jalaliDatepicker.startWatch({
                time: true
            });
        });
    </script>
@endsection


@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-b$product">ویرایش محصول</h4>
    </div>

    <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST" class="row gy-4"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-12 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-4" x-data="imageViewer('{{ asset('images/products/' . $product->primary_image) }}')">
                    <label class="form-label">تصویر اصلی</label>

                    <template x-if="imageUrl">
                        <img :src="imageUrl" class="rounded" width=350 height=220 alt="primary-image">
                    </template>

                    <input name="primary_image" @change="fileChosen" type="file" class="form-control mt-3" />

                    <div class="form-text text-danger">
                        @error('primary_image')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">تصاویر محصول</label>
            <input name="images[]" multiple type="file" class="form-control" />
        </div>

        <div class="col-md-3">
            <label class="form-label">نام</label>
            <input name="name" type="text" value="{{ $product->name }}" class="form-control" />
            <div class="form-text text-danger">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">دسته بندی</label>
            <select name="category_id" class="form-select">
                @foreach ($categories as $category)
                    <option {{ $product->category->id == $category->id ? 'selected' : '' }} value={{ $category->id }}>
                        {{ $category->name }}</option>
                @endforeach
            </select>
            <div class="form-text text-danger">
                @error('category_id')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option {{ $product->status == 1 ? 'selected' : '' }} value="1">فعال</option>
                <option {{ $product->status != 1 ? 'selected' : '' }} value="0">غیر فعال</option>
            </select>
            <div class="form-text text-danger">
                @error('status')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">قیمت</label>
            <input name="price" type="text" value="{{ $product->price }}" class="form-control" />
            <div class="form-text text-danger">
                @error('price')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">تعداد</label>
            <input name="quantity" type="text" value="{{ $product->quantity }}" class="form-control" />
            <div class="form-text text-danger">
                @error('quantity')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">قیمت حراجی</label>
            <input name="sale_price" type="text" value="{{ $product->sale_price }}" class="form-control" />
            <div class="form-text text-danger">
                @error('sale_price')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ شروع حراجی</label>
            <input data-jdp name="date_on_sale_from" type="text"
                value="{{ $product->date_on_sale_from != null ? getJalaliDate($product->date_on_sale_from) : '' }}"
                class="form-control" />
            <div class="form-text text-danger">
                @error('date_on_sale_from')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ پایان حراجی</label>
            <input data-jdp name="date_on_sale_to" type="text"
                value="{{ $product->date_on_sale_to != null ? getJalaliDate($product->date_on_sale_to) : '' }}"
                class="form-control" />
            <div class="form-text text-danger">
                @error('date_on_sale_to')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="col-md-12">
            <label class="form-label">توضیحات</label>
            <textarea name="description" rows="5" class="form-control">{{ $product->description }}</textarea>
            <div class="form-text text-danger">
                @error('description')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <hr>
        <div class="col-md-12">
            @foreach ($product->images as $image)
                <img class="rounded" width="200" src="{{ asset('/images/products/' . $image->image) }}" alt="images">
            @endforeach
        </div>
        <hr>
        <div class="mb-5">
            <a href="{{ route('product.index') }}" class="btn btn-warning mt-3 mx-3">
                برگشت
            </a>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش محصول
            </button>
        </div>

    </form>
@endsection
