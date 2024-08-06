<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class UserPackages extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'package_id',
        'start_date',
        'end_date',
        'credit',
        'actual_price',
        'discounted_price',
        'total_paid_amount',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
