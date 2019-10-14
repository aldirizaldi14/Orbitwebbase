<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ReceiptdetModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'receiptdet';
    protected $primaryKey = 'receiptdet_id';
    protected $fillable = [
        'receiptdet_code', 
        'receiptdet_receipt_id', 
        'receiptdet_product_id', 
        'receiptdet_qty', 
        'receiptdet_created_at',
        'receiptdet_created_by',
        'receiptdet_updated_at',
        'receiptdet_updated_by',
        'receiptdet_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'receiptdet_created_at';
    const UPDATED_AT = 'receiptdet_updated_at';
    const DELETED_AT = 'receiptdet_deleted_at';
}
