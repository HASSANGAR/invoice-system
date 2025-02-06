@extends('layouts.app')

@section('content')
    <h1 class="mb-4">تفاصيل الفاتورة</h1>

    <div class="card mb-4">
        <div class="card-body">
            @if($invoice->logo)
                <img src="{{ asset('storage/' . $invoice->logo) }}" alt="شعار المركز" class="img-thumbnail mb-3" style="max-width: 200px;">
            @endif
            <h5 class="card-title">{{ $invoice->center_name }}</h5>
            <p class="card-text">رقم الفاتورة: {{ $invoice->id }}</p>
            <p class="card-text">اسم العميل: {{ $invoice->customer_name }}</p>
            <p class="card-text">تاريخ الإنشاء: {{ $invoice->created_at->format('Y-m-d') }}</p>
        </div>
    </div>

    <h2 class="mb-3">تفاصيل المنتجات</h2>
    <table class="table">
        <thead>
            <tr>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>المجموع</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">ملخص الحساب</h5>
            <p class="card-text">المجموع الفرعي: {{ number_format($invoice->subtotal, 2) }}</p>
            @if($invoice->discount_percentage > 0)
                <p class="card-text">الخصم ({{ $invoice->discount_percentage }}%): {{ number_format($invoice->discount_amount, 2) }}</p>
            @endif
            @if($invoice->tax_percentage > 0)
                <p class="card-text">الضريبة ({{ $invoice->tax_percentage }}%): {{ number_format($invoice->tax_amount, 2) }}</p>
            @endif
            <p class="card-text"><strong>الإجمالي النهائي: {{ number_format($invoice->total_amount, 2) }}</strong></p>
        </div>
    </div>

    @if($invoice->signature)
        <div class="mt-4">
            <h5>التوقيع:</h5>
            <img src="{{ asset('storage/' . $invoice->signature) }}" alt="التوقيع" class="img-thumbnail" style="max-width: 150px;">
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">تعديل الفاتورة</a>
        <a href="{{ route('invoices.print', $invoice) }}" class="btn btn-secondary ms-2" target="_blank">طباعة الفاتورة</a>
        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger ms-2" onclick="return confirm('هل أنت متأكد؟')">حذف الفاتورة</button>
        </form>
    </div>
@endsection

