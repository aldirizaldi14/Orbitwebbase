<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Model\TransferModel;
use App\Model\TransferdetModel;
use DB;
use Log;
use Response;

class TransferController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = TransferModel::select("transfer.*")
            ->addSelect(DB::raw('1 as transfer_sync'));
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('transfer_created_at', '>=', $last_update)
                    ->orWhere('transfer_updated_at', '>=', $last_update)
                    ->orWhere('transfer_deleted_at', '>=', $last_update);
            });
        }
        $data = $data->get();
        return $data;
    }

    public function detail(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = TransferdetModel::select("transferdet.*");
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('transferdet_created_at', '>=', $last_update)
                    ->orWhere('transferdet_updated_at', '>=', $last_update)
                    ->orWhere('transferdet_deleted_at', '>=', $last_update);
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
            $transfer = TransferModel::where('transfer_code', $data->transfer_code)
                ->where('transfer_time', $data->transfer_time)
                ->first();
            if(! $transfer){
                $transfer = new TransferModel();
                $transfer->transfer_created_by = $user->user_username;
                $transfer->transfer_user_id = $user->user_id;
            }else{
                $transfer->transfer_updated_by = $user->user_username;
            }
            $transfer->transfer_code = $data->transfer_code;
            $transfer->transfer_time = $data->transfer_time;
            $transfer->transfer_sent_at = $data->transfer_sent_at;
            $save = $transfer->save();

            foreach ($detail as $det) {
                $transferdet = TransferdetModel::where('transferdet_transfer_id', $transfer->transfer_id)
                    ->where('transferdet_product_id', $det->transferdet_product_id)
                    ->first();
                if(! $transferdet){
                    $transferdet = new TransferdetModel();
                    $transferdet->transferdet_created_by = $user->user_username;
                }else{
                    $transferdet->transferdet_updated_by = $user->user_username;
                }
                $transferdet->transferdet_code = '-';
                $transferdet->transferdet_transfer_id = $transfer->transfer_id;
                $transferdet->transferdet_product_id = $det->transferdet_product_id;
                $transferdet->transferdet_qty = $det->transferdet_qty;
                $transferdet->save();
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
