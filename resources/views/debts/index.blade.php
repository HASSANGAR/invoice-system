@extends('layouts.app')

@section('content')
    <h1 class="mb-4">المديونيات</h1>
    <a href="{{ route('debts.create') }}" class="btn btn-primary mb-3">إضافة مديونية جديدة</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>اسم المدين</th>
                <th>المبلغ</th>
                <th>تاريخ الاستحقاق</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($debts as $debt)
                <tr>
                    <td>{{ $debt->debtor_name }}</td>
                    <td>{{ number_format($debt->amount, 2) }}</td>
                    <td>{{ $debt->due_date }}</td>
                    <td>
                        <a href="{{ route('debts.show', $debt) }}" class="btn btn-sm btn-info">عرض</a>
                        <a href="{{ route('debts.edit', $debt) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('debts.destroy', $debt) }}" method="POST" style="display: inline-block;">
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
