<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'drug_name' => 'array',
        'quantity' => 'array',
        'unit_price' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
