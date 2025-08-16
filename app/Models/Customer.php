<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = [
        'name',
        'dob',
        'phone_number',
        'email',
        'nationality_id',
    ];

    /**
     * Relasi: customer belongsTo nationality
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    /**
     * Relasi: customer hasMany family_list
     */
    public function familyLists()
    {
        return $this->hasMany(FamilyList::class, 'customer_id');
    }
}