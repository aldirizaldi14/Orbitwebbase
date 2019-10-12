<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Model\LineModel;
use DB;
use Log;
use Response;

class LineController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = LineModel::select("line.*")
            ->addSelect(DB::raw('1 as line_sync'));
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('line_created_at', '>', $last_update)
                    ->where('line_updated_at', '>', $last_update)
                    ->where('line_deleted_at', '>', $last_update);
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
            $line = LineModel::find($datum->line_id);
            if(! $line){
                $line = new LineModel();
                //$line->line_created_by = $request->user()->user_username;
            }else{
                //$line->line_updated_by = $request->user()->user_username;
            }
            $line->line_name = $datum->line_name;
            $line->line_description = $datum->line_description;
            $save = $line->save();
        }
        if($save){
            $response = ['status' => 'success', 'success' => true, 'message' => 'Saved'];
        }else{
            $response = ['status' => 'error', 'success' => false, 'message' => 'Failure'];
        }
        return $response;
    }
}
