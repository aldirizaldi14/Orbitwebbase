<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AllocationModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'allocation';
    protected $primaryKey = 'allocation_id';
    protected $fillable = [
        'allocation_code', 
        'allocation_time', 
        'allocation_product_id', 
        'allocation_user_id', 
        'allocation_created_at',
        'allocation_created_by',
        'allocation_updated_at',
        'allocation_updated_by',
        'allocation_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'allocation_created_at';
    const UPDATED_AT = 'allocation_updated_at';
    const DELETED_AT = 'allocation_deleted_at';
}