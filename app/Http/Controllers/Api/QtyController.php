<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Model\AreaProductQty;
use DB;
use Log;
use Response;

class QtyController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = AreaProductQty::select("*");
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('qty_created_at', '>=', $last_update)
                    ->orWhere('qty_updated_at', '>=', $last_update)
                    ->orWhere('qty_deleted_at', '>=', $last_update);
            });
        }
        $data = $data->get();
        return $data;
    }
}
