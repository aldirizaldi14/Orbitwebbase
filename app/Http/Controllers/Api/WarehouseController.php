<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Model\WarehouseModel;
use DB;
use Log;
use Response;

class WarehouseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = WarehouseModel::select("warehouse.*")
            ->addSelect(DB::raw('1 as warehouse_sync'))
            ->withTrashed();
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('warehouse_created_at', '>=', $last_update)
                    ->orWhere('warehouse_updated_at', '>=', $last_update)
                    ->orWhere('warehouse_deleted_at', '>=', $last_update);
            });
        }
        $data = $data->get();
        return $data;
    }

    public function sync(Request $request)
    {
        $data = json_decode($request->data);
        $save = true;
        foreach ($data as $datum) {
            $warehouse = WarehouseModel::find($datum->warehouse_id);
            if(! $warehouse){
                $warehouse = new WarehouseModel();
                //$warehouse->warehouse_created_by = $request->user()->user_username;
            }else{
                //$warehouse->warehouse_updated_by = $request->user()->user_username;
            }
            $warehouse->warehouse_name = $datum->warehouse_name;
            $warehouse->warehouse_description = $datum->warehouse_description;
            $save = $warehouse->save();
        }
        if($save){
            $response = ['status' => 'success', 'success' => true, 'message' => 'Saved'];
        }else{
            $response = ['status' => 'error', 'success' => false, 'message' => 'Failure'];
        }
        return $response;
    }
}
