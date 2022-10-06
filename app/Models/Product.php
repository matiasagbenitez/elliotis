<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relationships
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function woodType()
    {
        return $this->belongsTo(WoodType::class);
    }

    public function ivaType()
    {
        return $this->belongsTo(IvaType::class);
    }

}
