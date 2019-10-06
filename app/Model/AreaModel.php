<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AreaModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'area';
    protected $primaryKey = 'area_id';
    protected $fillable = [
        'area_name', 
        'area_description', 
        'area_created_at',
        'area_created_by',
        'area_updated_at',
        'area_updated_by',
        'area_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'area_created_at';
    const UPDATED_AT = 'area_updated_at';
    const DELETED_AT = 'area_deleted_at';

    public function scopeSearch($query, $search){
        if ($search){
            return $query->whereRaw("(
                lower(area_name) like '%". strtolower($search) ."%'
                OR lower(area_description) like '%". strtolower($search) ."%'
            )");
        }
    }
}
