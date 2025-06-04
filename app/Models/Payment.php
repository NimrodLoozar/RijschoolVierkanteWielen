<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Table name (optional if Laravel conventions match)
    protected $table = 'payments';

    // Primary key (optional if 'id')
    protected $primaryKey = 'id';

    // Allow mass assignment on these fields (adjust as needed)
    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'amount',
        'date',
        'status',
        'description',
        'is_active'
    ];

    // Cast 'date' to a Carbon instance for date handling in views/controllers
    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
    ];

    // If you want, add relationships here, for example, to Invoice:
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
