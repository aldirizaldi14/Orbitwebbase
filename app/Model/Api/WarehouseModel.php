<?php
namespace App\Model\Api;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use DB;

class WarehouseModel extends Model
{
    use Notifiable;

    protected $table = 'warehouse';
    protected $primaryKey = 'warehouse_id';
    protected $fillable = [
        'warehouse_name', 
        'warehouse_description', 
        'warehouse_created_at',
        'warehouse_created_by',
        'warehouse_updated_at',
        'warehouse_updated_by',
        'warehouse_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'warehouse_created_at';
    const UPDATED_AT = 'warehouse_updated_at';
    const DELETED_AT = 'warehouse_deleted_at';
}
