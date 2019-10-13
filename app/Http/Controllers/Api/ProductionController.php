<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Model\ProductionModel;
use DB;
use Log;
use Response;

class ProductionController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = ProductionModel::select("production.*")
            ->addSelect(DB::raw('1 as production_sync'));
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('production_created_at', '>=', $last_update)
                    ->orWhere('production_updated_at', '>=', $last_update)
                    ->orWhere('production_deleted_at', '>=', $last_update);
            });
        }
        $data = $data->get();
        return $data;
    }

    public function sync(Request $request)
    {
        $user = Auth::guard('api')->user();
        $data = json_decode($request->data);
        $production = ProductionModel::where('production_code', $data->production_code)
            ->where('production_time', $data->production_time)
            ->first();
        if(! $production){
            $production = new ProductionModel();
            $production->production_created_by = $user->user_username;
            $production->production_user_id = $user->user_id;
        }else{
            $production->production_updated_by = $user->user_username;
        }
        $production->production_code = $data->production_code;
        $production->production_time = $data->production_time;
        $production->production_product_id = $data->production_product_id;
        $production->production_line_id = $data->production_line_id;
        $production->production_shift = $data->production_shift;
        $production->production_batch = $data->production_batch;
        $production->production_qty = $data->production_qty;
        $save = $production->save();
        if($save){
            $response = ['status' => 'success', 'success' => true, 'message' => 'Saved'];
        }else{
            $response = ['status' => 'error', 'success' => false, 'message' => 'Failure'];
        }
        return $response;
    }
}
