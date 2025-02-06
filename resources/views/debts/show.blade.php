@extends('layouts.app')

@section('content')
    <h1 class="mb-4">تفاصيل المديونية</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $debt->debtor_name }}</h5>
            <p class="card-text">المبلغ: {{ number_format($debt->amount, 2) }}</p>
            <p class="card-text">تاريخ الاستحقاق: {{ $debt->due_date }}</p>
        </div>
    </div>

    <a href="{{ route('debts.edit', $debt) }}" class="btn btn-warning mt-3">تعديل</a>
    <form action="{{ route('debts.destroy', $debt) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
    </form>
@endsection
