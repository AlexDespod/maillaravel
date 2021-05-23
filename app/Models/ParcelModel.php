<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParcelModel extends BaseModel
{
    use HasFactory;

    public $fillable = ["price", "phone"];

    public $table = 'parcel';

    public function bank()
    {
        return $this->belongsTo(BankModel::class, "id", "parcel_id");
    }
}
