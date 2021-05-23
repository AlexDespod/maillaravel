<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankModel extends BaseModel
{
    use HasFactory;

    public $primaryKey = 'parcel_id';

    public $fillable = ["sender_name", "recipient", "endpoint", "product"];

    public $table = 'bank';

    public function parcels()
    {
        return $this->hasOne(ParcelModel::class, "id", "parcel_id");
    }
}
