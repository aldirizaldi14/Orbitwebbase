<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AllocationdetModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'allocationdet';
    protected $primaryKey = 'allocationdet_id';
    protected $fillable = [
        'allocationdet_code', 
        'allocationdet_allocation_id', 
        'allocationdet_area_id', 
        'allocationdet_qty', 
        'allocationdet_created_at',
        'allocationdet_created_by',
        'allocationdet_updated_at',
        'allocationdet_updated_by',
        'allocationdet_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'allocationdet_created_at';
    const UPDATED_AT = 'allocationdet_updated_at';
    const DELETED_AT = 'allocationdet_deleted_at';
}
