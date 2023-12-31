<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class customer extends Model
{
    use HasFactory;
    protected $fillable = [
    'status',
    'nama',
    'telp',
    'tanggal', // <-- new column name
    // .. other column names
];
    public function pesanan(): HasMany
    {

        return $this->hasMany(pesanan::class,'customer_id');
    }
}


