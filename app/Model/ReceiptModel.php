<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ReceiptModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'receipt';
    protected $primaryKey = 'receipt_id';
    protected $fillable = [
        'receipt_code', 
        'receipt_time', 
        'receipt_shift', 
        'receipt_user_id', 
        'receipt_created_at',
        'receipt_created_by',
        'receipt_updated_at',
        'receipt_updated_by',
        'receipt_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'receipt_created_at';
    const UPDATED_AT = 'receipt_updated_at';
    const DELETED_AT = 'receipt_deleted_at';
}
