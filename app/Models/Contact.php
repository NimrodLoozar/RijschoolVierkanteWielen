<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory;

    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'street',
        'house_number',
        'addition',
        'postal_code',
        'city',
        'mobile',
        'email',
        'is_active',
        'note',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getFullAddressAttribute()
    {
        return "{$this->street} {$this->house_number} {$this->addition}, {$this->postal_code} {$this->city}";
    }
    public function getFullNameAttribute()
    {
        return "{$this->user->first_name} {$this->user->middle_name} {$this->user->last_name}";
    }
    public function getFullNameWithEmailAttribute()
    {
        return "{$this->user->first_name} {$this->user->middle_name} {$this->user->last_name} ({$this->email})";
    }
}
