<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class LineModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'line';
    protected $primaryKey = 'line_id';
    protected $fillable = [
        'line_name', 
        'line_description', 
        'line_created_at',
        'line_created_by',
        'line_updated_at',
        'line_updated_by',
        'line_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'line_created_at';
    const UPDATED_AT = 'line_updated_at';
    const DELETED_AT = 'line_deleted_at';

    public function scopeSearch($query, $search){
        if ($search){
            return $query->whereRaw("(
                lower(line_name) like '%". strtolower($search) ."%'
                OR lower(line_description) like '%". strtolower($search) ."%'
            )");
        }
    }
}
