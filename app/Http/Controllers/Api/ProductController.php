<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Model\ProductModel;
use DB;
use Log;
use Response;

class ProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = ProductModel::select("product.*")
            ->addSelect('1 as product_sync');
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('product_created_at', '>', $last_update)
                    ->where('product_updated_at', '>', $last_update)
                    ->where('product_deleted_at', '>', $last_update);
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
            $product = ProductModel::find($datum->product_id);
            if(! $product){
                $product = new ProductModel();
                //$product->product_created_by = $request->user()->user_username;
            }else{
                //$product->product_updated_by = $request->user()->user_username;
            }
            $product->product_name = $datum->product_name;
            $product->product_description = $datum->product_description;
            $save = $product->save();
        }
        if($save){
            $response = ['status' => 'success', 'success' => true, 'message' => 'Saved'];
        }else{
            $response = ['status' => 'error', 'success' => false, 'message' => 'Failure'];
        }
        return $response;
    }
}
