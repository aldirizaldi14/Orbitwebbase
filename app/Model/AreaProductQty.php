<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AreaProductQty extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'area_product_qty';
    protected $primaryKey = ['warehouse_id', 'product_id', 'area_id'];
    public $incrementing = false;
    protected $fillable = [
        'quantity', 
        'warehouse_id', 
        'product_id', 
        'area_id', 
        'qty_created_at',
        'qty_created_by',
        'qty_updated_at',
        'qty_updated_by',
        'qty_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'qty_created_at';
    const UPDATED_AT = 'qty_updated_at';
    const DELETED_AT = 'qty_deleted_at';
}
