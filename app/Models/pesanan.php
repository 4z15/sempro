<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsTO;


class pesanan extends Model
{
    use HasFactory;
    protected $fillable = [
    'customer_id',
    'sayuran_id',
    'pesanan',
    'total',
    'berat',
    'harga', 
    'catatan', // <-- new column name
    // <-- new column name
     // <-- new column name
    // .. other column names
];
public function sayuran(): HasMany
    {

        return $this->hasMany(sayuran::class);
    }

// public function customer(): HasMany
//     {

//         return $this->hasMany(customer::class);
//     }
}
