<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    use HasFactory;
    public static function splitInputs(array $arr)
    {
        $bankSchema   = Schema::getColumnListing("bank");
        $parcelSchema = Schema::getColumnListing("parcel");
        $effected     = [];
        foreach ($arr as $key => $value) {
            in_array($key, $bankSchema) && ($effected["bank"][$key] = $value);
            in_array($key, $parcelSchema) && ($effected["parcel"][$key] = $value);
        }

        return $effected;
    }
}
