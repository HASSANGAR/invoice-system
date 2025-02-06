@extends('layouts.app')

@section('content')
    <h1 class="mb-4">تفاصيل المنتج</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">الوصف: {{ $product->description }}</p>
            <p class="card-text">السعر: {{ number_format($product->price, 2) }}</p>
            <p class="card-text">المخزون: {{ $product->stock }}</p>
        </div>
    </div>

    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning mt-3">تعديل</a>
    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
    </form>
@endsection
