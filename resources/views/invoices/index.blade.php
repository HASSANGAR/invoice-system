@extends('layouts.app')

@section('content')
    <h1 class="mb-4">الفواتير</h1>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">إنشاء فاتورة جديدة</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>رقم الفاتورة</th>
                <th>اسم العميل</th>
                <th>المبلغ الإجمالي</th>
                <th>تاريخ الإنشاء</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->customer_name }}</td>
                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info">عرض</a>
                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
