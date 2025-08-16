<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyList extends Model
{
    use HasFactory;

    protected $table = 'family_list';

    protected $fillable = [
        'customer_id',
        'name',
        'dob',
    ];

    /**
     * Relasi: family_list belongsTo customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
