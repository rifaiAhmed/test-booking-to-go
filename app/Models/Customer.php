<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'cst_id';

    public function nationality()
    {
        return $this->belongsTo(
            Nationality::class,
            'nationality_id',
            'nationality_id'
        );
    }
}
