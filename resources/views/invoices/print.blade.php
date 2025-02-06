<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 15px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border-top: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        .total-section {
            margin-top: 20px;
            text-align: left;
        }
        .logo {
            max-width: 200px;
            max-height: 100px;
            margin-bottom: 20px;
        }
        .signature {
            max-width: 150px;
            max-height: 75px;
            margin-top: 20px;
        }
        .signature-section {
            margin-top: 40px;
            text-align: center;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        @if($invoice->logo)
            <img src="{{ asset('storage/' . $invoice->logo) }}" alt="شعار المركز" class="logo">
        @endif
        <b><h1>{{ $invoice->center_name }}</h1></b>
        <h1>فاتورة</h1>
        <p>رقم الفاتورة: {{ $invoice->id }}</p>
    </div>

    <div class="invoice-details">
        <b><h3><p><strong>اسم العميل:</strong> {{ $invoice->customer_name }}</p></h3> </b>
        <p><strong>التاريخ:</strong> {{ $invoice->created_at->format('Y-m-d') }}</p>
       
    </div>

    <table>
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

    <div class="total-section">
        <p><strong>المجموع الفرعي:</strong> {{ number_format($invoice->subtotal, 2) }}</p>
        @if($invoice->discount_percentage > 0)
            <p><strong>الخصم ({{ $invoice->discount_percentage }}%):</strong> {{ number_format($invoice->discount_amount, 2) }}</p>
        @endif
        @if($invoice->tax_percentage > 0)
            <p><strong>الضريبة ({{ $invoice->tax_percentage }}%):</strong> {{ number_format($invoice->tax_amount, 2) }}</p>
        @endif
        <p><strong>الإجمالي النهائي:</strong> {{ number_format($invoice->total_amount, 2) }}</p>
    </div>

    <div class="signature-section">
        @if($invoice->signature)
            <img src="{{ asset('storage/' . $invoice->signature) }}" alt="التوقيع" class="signature">
        @endif
        <p>التوقيع</p>
    </div>

    <div class="no-print">
        <button onclick="window.print()">طباعة الفاتورة</button>
    </div>
</body>
</html>

