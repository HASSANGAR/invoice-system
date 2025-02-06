<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $products = Product::all();
        return view('invoices.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'center_name' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $invoice = Invoice::create([
            'customer_name' => $validated['customer_name'],
            'center_name' => $validated['center_name'],
            'discount_percentage' => $validated['discount_percentage'] ?? 0,
            'tax_percentage' => $validated['tax_percentage'] ?? 0,
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $invoice->update(['logo' => $path]);
        }

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures', 'public');
            $invoice->update(['signature' => $path]);
        }

        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            $invoice->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        $invoice->calculateTotals();

        return redirect()->route('invoices.index')->with('success', 'تم إنشاء الفاتورة بنجاح.');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $products = Product::all();
        return view('invoices.edit', compact('invoice', 'products'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'center_name' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $invoice->update([
            'customer_name' => $validated['customer_name'],
            'center_name' => $validated['center_name'],
            'discount_percentage' => $validated['discount_percentage'] ?? 0,
            'tax_percentage' => $validated['tax_percentage'] ?? 0,
        ]);

        if ($request->hasFile('logo')) {
            if ($invoice->logo) {
                Storage::disk('public')->delete($invoice->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $invoice->update(['logo' => $path]);
        }

        if ($request->hasFile('signature')) {
            if ($invoice->signature) {
                Storage::disk('public')->delete($invoice->signature);
            }
            $path = $request->file('signature')->store('signatures', 'public');
            $invoice->update(['signature' => $path]);
        }

        $invoice->items()->delete();
        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            $invoice->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        $invoice->calculateTotals();

        return redirect()->route('invoices.show', $invoice)->with('success', 'تم تحديث الفاتورة بنجاح.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة بنجاح.');
    }

    public function print(Invoice $invoice)
    {
        return view('invoices.print', compact('invoice'));
    }
}

