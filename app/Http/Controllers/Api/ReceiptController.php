<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Model\TransferModel;
use App\Model\ReceiptModel;
use App\Model\ReceiptdetModel;
use App\Model\AreaProductQty;
use DB;
use Log;
use Response;

class ReceiptController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function data(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = ReceiptModel::select("receipt.*")
            ->addSelect(DB::raw('1 as receipt_sync'));
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('receipt_created_at', '>=', $last_update)
                    ->orWhere('receipt_updated_at', '>=', $last_update)
                    ->orWhere('receipt_deleted_at', '>=', $last_update);
            });
        }
        $data = $data->get();
        return $data;
    }

    public function detail(Request $request)
    {
        $last_update = $request->get('last_update');
        $data = ReceiptdetModel::select("receiptdet.*");
        if($last_update){
            $data->where(function($q) use ($last_update){
                $q->where('receiptdet_created_at', '>=', $last_update)
                    ->orWhere('receiptdet_updated_at', '>=', $last_update)
                    ->orWhere('receiptdet_deleted_at', '>=', $last_update);
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
            $transfer = TransferModel::where('transfer_code', $data->receipt_transfer_code)
                ->first();
            if($transfer){
                $transfer_id = $transfer->transfer_id;
            }else{
                $transfer_id = 0;
            }
            $receipt = ReceiptModel::where('receipt_transfer_id', $transfer_id)
                ->first();
            if(! $receipt){
                $receipt = new ReceiptModel();
                $receipt->receipt_created_by = $user->user_username;
                $receipt->receipt_user_id = $user->user_id;
                $receipt->receipt_transfer_id = $transfer_id;
            }else{
                $receipt->receipt_updated_by = $user->user_username;
            }
            $receipt->receipt_code = $data->receipt_code;
            $receipt->receipt_time = $data->receipt_time;
            $receipt->receipt_status = $data->receipt_status;
            $save = $receipt->save();

            foreach ($detail as $det) {
                $receiptdet = ReceiptdetModel::where('receiptdet_receipt_id', $receipt->receipt_id)
                    ->where('receiptdet_product_id', $det->receiptdet_product_id)
                    ->first();
                if(! $receiptdet){
                    $receiptdet = new ReceiptdetModel();
                    $receiptdet->receiptdet_created_by = $user->user_username;
                }else{
                    $receiptdet->receiptdet_updated_by = $user->user_username;
                }
                $receiptdet->receiptdet_code = '-';
                $receiptdet->receiptdet_receipt_id = $receipt->receipt_id;
                $receiptdet->receiptdet_transferdet_id = $det->receiptdet_transferdet_id;
                $receiptdet->receiptdet_product_id = $det->receiptdet_product_id;
                $receiptdet->receiptdet_qty = $det->receiptdet_qty;
                $receiptdet->receiptdet_note = $det->receiptdet_note;
                $receiptdet->save();

                $qty = AreaProductQty::where('area_id', 0)
                    ->where('product_id', $det->receiptdet_product_id)
                    ->first();
                if(! $qty){
                    $qty = new AreaProductQty();
                    $qty->qty_created_by = $user->user_username;
                    $qty->warehouse_id = 0;
                    $qty->area_id = 0;
                    $qty->product_id = $det->receiptdet_product_id;
                    $qty->quantity = $det->receiptdet_qty;
                }else{
                    $qty->qty_updated_by = $user->user_username;
                    $qty->quantity = $det->receiptdet_qty + $qty->quantity;
                }
                $qty->save();
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
