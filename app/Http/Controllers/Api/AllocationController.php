<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Model\TransferModel;
use App\Model\AllocationModel;
use App\Model\AllocationdetModel;
use App\Model\AreaProductQty;
use App\Model\AreaModel;
use DB;
use Log;
use Response;

class AllocationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = AllocationModel::select("allocation.*")
            ->addSelect(DB::raw('1 as allocation_sync'))
            ->withTrashed();
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('allocation_created_at', '>=', $last_update)
                    ->orWhere('allocation_updated_at', '>=', $last_update)
                    ->orWhere('allocation_deleted_at', '>=', $last_update);
            });
        }else{
            $data->where(function($q) use ($last_update){
                $q->where('allocation_created_at', '>=', Carbon::now()->subDays(2));
            });
        }
        $data = $data->get();
        return $data;
    }

    public function detail(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = AllocationdetModel::select("allocationdet.*");
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('allocationdet_created_at', '>=', $last_update)
                    ->orWhere('allocationdet_updated_at', '>=', $last_update)
                    ->orWhere('allocationdet_deleted_at', '>=', $last_update);
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
        Log::debug($request->data);
        Log::debug($request->detail);

        DB::beginTransaction();
        try {
            $allocation = AllocationModel::where('allocation_code', $data->allocation_code)
                ->where('allocation_time', $data->allocation_time)
                ->first();
            if(! $allocation){
                $allocation = new AllocationModel();
                $allocation->allocation_created_by = $user->user_username;
                $allocation->allocation_user_id = $user->user_id;
            }else{
                $allocation->allocation_updated_by = $user->user_username;
            }
            $allocation->allocation_code = $data->allocation_code;
            $allocation->allocation_time = $data->allocation_time;
            $allocation->allocation_product_id = $data->allocation_product_id;
            $save = $allocation->save();

            foreach ($detail as $det) {
                $allocationdet = AllocationdetModel::where('allocationdet_allocation_id', $allocation->allocation_id)
                    ->where('allocationdet_area_id', $det->allocationdet_area_id)
                    ->first();
                if(! $allocationdet){
                    $allocationdet = new AllocationdetModel();
                    $allocationdet->allocationdet_created_by = $user->user_username;
                }else{
                    $allocationdet->allocationdet_updated_by = $user->user_username;
                }
                $allocationdet->allocationdet_code = '-';
                $allocationdet->allocationdet_allocation_id = $allocation->allocation_id;
                $allocationdet->allocationdet_area_id = $det->allocationdet_area_id;
                $allocationdet->allocationdet_qty = $det->allocationdet_qty;
                $allocationdet->save();

                $qty = AreaProductQty::where('area_id', $det->allocationdet_area_id)
                    ->where('product_id', $allocation->allocation_product_id)
                    ->first();
                if(! $qty){
                    $area = AreaModel::find($det->allocationdet_area_id);

                    $qty = new AreaProductQty();
                    $qty->qty_created_by = $user->user_username;
                    $qty->warehouse_id = $area->area_warehouse_id;
                    $qty->area_id = $det->allocationdet_area_id;;
                    $qty->product_id = $allocation->allocation_product_id;
                    $qty->quantity = $det->allocationdet_qty;
                    $qty->save();
                }else{
                    $t = $det->allocationdet_qty + $qty->quantity;
                    AreaProductQty::where('area_id', $det->allocationdet_area_id)
                        ->where('product_id', $allocation->allocation_product_id)
                        ->update(['qty_updated_by'=> $user->user_username, 'quantity'=> $t]);
                }

                $qty = AreaProductQty::where('warehouse_id', 0)
                    ->where('product_id', $allocation->allocation_product_id)
                    ->first();
                if($qty){
                    $t = $qty->quantity - $det->allocationdet_qty;
                    AreaProductQty::where('warehouse_id', 0)
                        ->where('product_id', $allocation->allocation_product_id)
                        ->update(['qty_updated_by'=> $user->user_username, 'quantity'=> $t]);
                }
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
