@extends('layouts.app')

@section('content')
    <h1 class="mb-4">إنشاء فاتورة جديدة</h1>

    <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="center_name" class="form-label">اسم المركز</label>
            <input type="text" class="form-control" id="center_name" name="center_name" required>
        </div>
        <div class="mb-3">
            <label for="customer_name" class="form-label">اسم العميل</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="logo" class="form-label">شعار الفاتورة</label>
            <input type="file" class="form-control" id="logo" name="logo">
        </div>
        <div id="invoice-items">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="items[0][product_id]" class="form-label">المنتج</label>
                    <select class="form-control" name="items[0][product_id]" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - {{ number_format($product->price, 2) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="items[0][quantity]" class="form-label">الكمية</label>
                    <input type="number" class="form-control" name="items[0][quantity]" required min="1">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger mt-4 remove-item" style="display: none;">حذف</button>
                </div>
            </div>
        </div>
        <button type="button" id="add-item" class="btn btn-secondary mb-3">إضافة منتج</button>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="discount_percentage" class="form-label">نسبة الخصم (%)</label>
                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" min="0" max="100" step="0.01">
            </div>
            <div class="col-md-6">
                <label for="tax_percentage" class="form-label">نسبة الضريبة (%)</label>
                <input type="number" class="form-control" id="tax_percentage" name="tax_percentage" min="0" max="100" step="0.01">
            </div>
        </div>

        <div class="mb-3">
            <label for="signature" class="form-label">التوقيع</label>
            <input type="file" class="form-control" id="signature" name="signature">
        </div>

        <button type="submit" class="btn btn-primary">إنشاء الفاتورة</button>
    </form>

    <script>
        let itemIndex = 1;
        document.getElementById('add-item').addEventListener('click', function() {
            const itemsContainer = document.getElementById('invoice-items');
            const newItem = document.createElement('div');
            newItem.className = 'row mb-3';
            newItem.innerHTML = `
                <div class="col-md-4">
                    <label for="items[${itemIndex}][product_id]" class="form-label">المنتج</label>
                    <select class="form-control" name="items[${itemIndex}][product_id]" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - {{ number_format($product->price, 2) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="items[${itemIndex}][quantity]" class="form-label">الكمية</label>
                    <input type="number" class="form-control" name="items[${itemIndex}][quantity]" required min="1">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger mt-4 remove-item">حذف</button>
                </div>
            `;
            itemsContainer.appendChild(newItem);
            itemIndex++;

            document.querySelectorAll('.remove-item').forEach(button => {
                button.style.display = 'block';
            });
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-item')) {
                e.target.closest('.row').remove();

                if (document.querySelectorAll('#invoice-items .row').length === 1) {
                    document.querySelector('.remove-item').style.display = 'none';
                }
            }
        });
    </script>
@endsection

