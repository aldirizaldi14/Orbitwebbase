<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Model\DeliveryModel;
use App\Model\DeliverydetModel;
use App\Model\AreaProductQty;
use DB;
use Log;
use Response;

class DeliveryController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    /*public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = DeliveryModel::select("delivery.*")
            ->addSelect(DB::raw('1 as delivery_sync'))
            ->withTrashed();
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('delivery_created_at', '>=', $last_update)
                    ->orWhere('delivery_updated_at', '>=', $last_update)
                    ->orWhere('delivery_deleted_at', '>=', $last_update);
            });
        }else{
            $data->where(function($q) use ($last_update){
                $q->where('delivery_created_at', '>=', Carbon::now()->subDays(2));
            });
        }
        $data = $data->get();
        return $data;
    }*/


    //editan aldi
    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = DeliveryModel::select("sj_number.*")
            ->addSelect(DB::raw('1 as delivery_sync'));
            //->withTrashed();
        
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('delivery_created_at', '>=', $last_update)
                    ->orWhere('delivery_updated_at', '>=', $last_update)
                    ->orWhere('delivery_deleted_at', '>=', $last_update);
            });
        }else{
            $data->where(function($q) use ($last_update){
                $q->where('delivery_created_at', '>=', Carbon::now()->subDays(2));
            });
        }
        $data = $data->get();
        
        $rooms = json_decode($data, true);
        return response()->json($rooms);
        //return $data;

    }
    //editan aldi

    public function detail(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = DeliverydetModel::select("deliverydet.*");
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('deliverydet_created_at', '>=', $last_update)
                    ->orWhere('deliverydet_updated_at', '>=', $last_update);
                    //->orWhere('deliverydet_deleted_at', '>=', $last_update);
            });
        }
        $data = $data->get();
        return $data;


    }

    public function sync(Request $request)
    {
        $user = Auth::guard('api')->user();
        $data = json_decode($request->data);
        $detail = json_decode($request->detail);

        DB::beginTransaction();
        try {
            $delivery = DeliveryModel::where('surat_jalan', $data->surat_jalan)
                ->where('schedule_shipdate', $data->schedule_shipdate)
                ->first();
            if(! $delivery){
                $delivery = new DeliveryModel();
                $delivery->delivery_created_by = $user->user_username;
                $delivery->delivery_user_id = $user->user_id;
            }else{
                $delivery->delivery_updated_by = $user->user_username;
            }
            $delivery->delivery_code = $data->delivery_code;
            $delivery->delivery_time = $data->delivery_time;
            $delivery->delivery_expedition = $data->delivery_expedition;
            $delivery->delivery_destination = $data->delivery_destination;
            $delivery->delivery_city = $data->delivery_city;
            $save = $delivery->save();

            foreach ($detail as $det) {
                $deliverydet = DeliverydetModel::where('deliverydet_delivery_id', $delivery->delivery_id)
                    ->where('deliverydet_product_id', $det->deliverydet_product_id)
                    ->first();
                if(! $deliverydet){
                    $deliverydet = new DeliverydetModel();
                    $deliverydet->deliverydet_created_by = $user->user_username;
                }else{
                    $deliverydet->deliverydet_updated_by = $user->user_username;
                }
                $deliverydet->deliverydet_code = '-';
                $deliverydet->deliverydet_delivery_id = $delivery->delivery_id;
                $deliverydet->deliverydet_product_id = $det->deliverydet_product_id;
                $deliverydet->deliverydet_area_id = $det->deliverydet_area_id;
                $deliverydet->deliverydet_qty = $det->deliverydet_qty;
                $deliverydet->save();

                $qty = AreaProductQty::where('area_id', $det->deliverydet_area_id)
                    ->where('product_id', $det->deliverydet_product_id)
                    ->first();
                $t = $qty->quantity - $det->deliverydet_qty;
                AreaProductQty::where('area_id', $det->deliverydet_area_id)
                    ->where('product_id', $det->deliverydet_product_id)
                    ->update(['qty_updated_by'=> $user->user_username, 'quantity'=> $t]);
            }
            DB::commit();
            return ['status' => 'success', 'success' => true, 'message' => 'Saved'];
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
            return ['status' => 'error', 'success' => false, 'message' => 'Failure'];
        }
    }
}
