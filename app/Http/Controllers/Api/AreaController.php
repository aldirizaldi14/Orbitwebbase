<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Model\AreaModel;
use DB;
use Log;
use Response;

class AreaController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = AreaModel::select("area.*")
            ->addSelect('1 as area_sync');
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('area_created_at', '>', $last_update)
                    ->where('area_updated_at', '>', $last_update)
                    ->where('area_deleted_at', '>', $last_update);
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
            $area = AreaModel::find($datum->area_id);
            if(! $area){
                $area = new AreaModel();
                //$area->area_created_by = $request->user()->user_username;
            }else{
                //$area->area_updated_by = $request->user()->user_username;
            }
            $area->area_name = $datum->area_name;
            $area->area_description = $datum->area_description;
            $save = $area->save();
        }
        if($save){
            $response = ['status' => 'success', 'success' => true, 'message' => 'Saved'];
        }else{
            $response = ['status' => 'error', 'success' => false, 'message' => 'Failure'];
        }
        return $response;
    }
}
