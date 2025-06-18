<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'date',
        'status',
        'is_active',
        'note',
    ];

    // Cast 'date' to a Carbon instance for date handling in views/controllers
    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the invoice that owns the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
