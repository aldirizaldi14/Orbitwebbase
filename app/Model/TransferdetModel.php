<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class TransferdetModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'transferdet';
    protected $primaryKey = 'transferdet_id';
    protected $fillable = [
        'transferdet_code', 
        'transferdet_transfer_id', 
        'transferdet_product_id', 
        'transferdet_qty', 
        'transferdet_created_at',
        'transferdet_created_by',
        'transferdet_updated_at',
        'transferdet_updated_by',
        'transferdet_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'transferdet_created_at';
    const UPDATED_AT = 'transferdet_updated_at';
    const DELETED_AT = 'transferdet_deleted_at';
}
