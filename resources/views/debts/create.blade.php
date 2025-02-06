@extends('layouts.app')

@section('content')
    <h1 class="mb-4">إضافة مديونية جديدة</h1>

    <form action="{{ route('debts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="debtor_name" class="form-label">اسم المدين</label>
            <input type="text" class="form-control" id="debtor_name" name="debtor_name" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">المبلغ</label>
            <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">تاريخ الاستحقاق</label>
            <input type="date" class="form-control" id="due_date" name="due_date" required>
        </div>
        <button type="submit" class="btn btn-primary">إضافة</button>
    </form>
@endsection
