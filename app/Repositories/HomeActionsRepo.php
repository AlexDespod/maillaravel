<?php
namespace App\Repositories;

use App\Models\BankModel;
use App\Models\ParcelModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeActionsRepo
{
    public static function splitInputs(array $arr)
    {
        $bankSchema   = Schema::getColumnListing("bank");
        $parcelSchema = Schema::getColumnListing("parcel");

        $effected = [];
        foreach ($arr as $key => $value) {
            in_array($key, $bankSchema) && ($effected["bank"][$key] = $value);
            in_array($key, $parcelSchema) && ($effected["parcel"][$key] = $value);
        }

        return $effected;
    }

    public function store(array $effected)
    {
        try {
            DB::beginTransaction();
            $dataPacket         = new BankModel($effected['bank']);
            $dataPacket["date"] = date('Y.m.d');
            $dataPacket->save();
            $inserderId = $dataPacket->parcel_id;

            $dataPacket     = new ParcelModel($effected['parcel']);
            $dataPacket->id = $inserderId;
            $dataPacket->save();

            $user = request()->user();

            if (!$user->isSender()) {
                $user->roles()->attach(2);
            }

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return $e;

        }
        return $inserderId;

    }

    public function show_one(int $id)
    {
        $order = BankModel::with("parcels:id,price,phone")->where("parcel_id", $id)->first();

        if ($order) {
            return $order->toArray();
        }
        return false;

    }

    public function update($id, $effected)
    {
        try {
            DB::beginTransaction();
            count($effected["bank"]) && BankModel::where("parcel_id", $id)->update($effected["bank"]);
            count($effected["parcel"]) && ParcelModel::where("id", $id)->update($effected["parcel"]);
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return $e;
        }
        return 1;
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            BankModel::destroy($id);
            ParcelModel::destroy($id);
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return $e;

        }
        return 1;

    }
    public function get_for_edit(int $id)
    {

        $order = BankModel::with("parcels:id,price,phone")
            ->where("parcel_id", $id)
            ->first();

        if ($order) {
            return $order;
        }
        return false;

    }

    public function get_default_values_to_form()
    {
        $array              = [];
        $array['price']     = DB::table('parcel')->selectRaw("MAX(price) as price_to ,MIN(price) as price_from")->first();
        $array['date']      = DB::table('bank')->selectRaw("MAX(date) as date_to ,MIN(date) as date_from")->first();
        $array['endpoints'] = DB::table('bank')->selectRaw("DISTINCT endpoint")->get();
        $bankSchema         = Schema::getColumnListing("bank");
        $parcelSchema       = Schema::getColumnListing("parcel");
        $array['columns']   = array_diff(array_merge($bankSchema, $parcelSchema), ["created_at", "updated_at"]);
        return $array;
    }
    public function get_all($isAdmin = false, $name = null)
    {
        $orders = (new BankModel)->join("parcel", "bank.parcel_id", "=", "parcel.id");
        if ($isAdmin) {
            $orders = $orders->get(["parcel_id", "sender_name", "recipient", "product", "endpoint", "date", "price", "phone"]);
        } else {
            $orders = $orders
                ->where('sender_name', $name)
                ->get(["parcel_id", "sender_name", "recipient", "product", "endpoint", "date", "price", "phone"]);
        }

        return $orders;
    }
    public function search_by_inputs(array $arr, bool $isAdmin)
    {

        if ($isAdmin) {
            $builder = (new BankModel())
                ->join("parcel", "bank.parcel_id", "=", "parcel.id");
        } else {
            $sender_name = request()->user()->name;
            $builder     = (new BankModel())
                ->join("parcel", "bank.parcel_id", "=", "parcel.id")
                ->where('sender_name', $sender_name);
        }

        foreach ($arr as $key => $value) {
            if (($key != 'price_from'
                && $key != 'price_to'
                && $key != 'date_to'
                && $key != 'date_from'
                && $key != 'order_by'
                && $key != 'order_type')
                && $value != null
                && $value != 'all') {

                $builder = $builder->where($key, $value);
            }
        }
        $orders = $builder
            ->whereBetween('date', [$arr['date_from'], $arr['date_to']])
            ->whereBetween('price', [$arr['price_from'], $arr['price_to']])
            ->orderBy($arr['order_by'], $arr['order_type'])
            ->get();

        return $orders;

    }

    public $rules_for_index = [
        "sender_name" => ["nullable", "string"],
        "recipient"   => ["nullable", "string"],
        "product"     => ["nullable", "string"],
        "price_from"  => ["nullable", "regex:/^\d*(\.\d{2})?$/", "required_with:price_to"],
        "price_to"    => ["nullable", "regex:/^\d*(\.\d{2})?$/", "required_with:price_from"],
        "date_from"   => ["date_format:Y-m-d", "required_with:date_to"],
        "date_to"     => ["date_format:Y-m-d", "required_with:date_from"],
        "endpoint"    => ["required", "string"],
        "order_by"    => ["required", "string"],
        "order_type"  => ["required", "string"],
    ];
}
