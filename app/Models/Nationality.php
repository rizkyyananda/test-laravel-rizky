<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $table = 'nationality';

    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * Relasi: satu nationality bisa punya banyak customer
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'nationality_id');
    }
}
