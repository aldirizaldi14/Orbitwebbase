<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ProductionModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'production';
    protected $primaryKey = 'production_id';
    protected $fillable = [
        'production_code', 
        'production_time', 
        'production_product_id', 
        'production_line_id', 
        'production_shift', 
        'production_batch', 
        'production_qty', 
        'production_remark', 
        'production_user_id', 
        'production_created_at',
        'production_created_by',
        'production_updated_at',
        'production_updated_by',
        'production_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'production_created_at';
    const UPDATED_AT = 'production_updated_at';
    const DELETED_AT = 'production_deleted_at';
}
