<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class DeliverydetModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'deliverydet';
    protected $primaryKey = 'deliverydet_id';
    protected $fillable = [
        'deliverydet_code', 
        'deliverydet_delivery_id', 
        'deliverydet_product_id', 
        'deliverydet_qty', 
        'deliverydet_created_at',
        'deliverydet_created_by',
        'deliverydet_updated_at',
        'deliverydet_updated_by',
        'deliverydet_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'deliverydet_created_at';
    const UPDATED_AT = 'deliverydet_updated_at';
    const DELETED_AT = 'deliverydet_deleted_at';
}
