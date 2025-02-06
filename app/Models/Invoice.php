<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_name',
        'center_name',
        'total_amount',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'tax_percentage',
        'tax_amount',
        'logo',
        'signature'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->items->sum(function($item) {
            return $item->quantity * $item->price;
        });

        $this->discount_amount = $this->subtotal * ($this->discount_percentage / 100);

        $this->tax_amount = ($this->subtotal - $this->discount_amount) * ($this->tax_percentage / 100);

        $this->total_amount = $this->subtotal - $this->discount_amount + $this->tax_amount;

        $this->save();

        return $this;
    }
}
