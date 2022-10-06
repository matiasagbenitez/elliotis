<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function payment_condition()
    {
        return $this->belongsTo(PaymentConditions::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethods::class);
    }

    public function voucher_type()
    {
        return $this->belongsTo(VoucherTypes::class);
    }

    // Falta el id_supplier
}
