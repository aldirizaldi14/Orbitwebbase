<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class TransferModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'transfer';
    protected $primaryKey = 'transfer_id';
    protected $fillable = [
        'transfer_code', 
        'transfer_time', 
        'transfer_sent_at', 
        'transfer_user_id', 
        'transfer_created_at',
        'transfer_created_by',
        'transfer_updated_at',
        'transfer_updated_by',
        'transfer_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'transfer_created_at';
    const UPDATED_AT = 'transfer_updated_at';
    const DELETED_AT = 'transfer_deleted_at';
}
