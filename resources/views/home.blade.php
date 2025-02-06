@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">مرحبًا بك في نظام الفواتير</h1>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">المديونيات</h5>
                    <p class="card-text">إدارة المديونيات وتتبع الديون المستحقة</p>
                    <a href="{{ route('debts.index') }}" class="btn btn-primary">عرض المديونيات</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">المنتجات</h5>
                    <p class="card-text">إدارة قائمة المنتجات والمخزون</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">عرض المنتجات</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">الفواتير</h5>
                    <p class="card-text">إنشاء وإدارة الفواتير للعملاء</p>
                    <a href="{{ route('invoices.index') }}" class="btn btn-primary">عرض الفواتير</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
