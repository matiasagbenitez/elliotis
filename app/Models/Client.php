<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relationships
    public function iva_condition()
    {
        return $this->belongsTo(IvaCondition::class);
    }

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }
}
