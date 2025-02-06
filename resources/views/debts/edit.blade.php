@extends('layouts.app')

@section('content')
    <h1 class="mb-4">تعديل المديونية</h1>

    <form action="{{ route('debts.update', $debt) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="debtor_name" class="form-label">اسم المدين</label>
            <input type="text" class="form-control" id="debtor_name" name="debtor_name" value="{{ $debt->debtor_name }}" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">المبلغ</label>
            <input type="number" class="form-control" id="amount" name="amount" step="0.01" value="{{ $debt->amount }}" required>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">تاريخ الاستحقاق</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $debt->due_date }}" required>
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
@endsection
