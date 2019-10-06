<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ProductModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_code', 
        'product_description', 
        'product_created_at',
        'product_created_by',
        'product_updated_at',
        'product_updated_by',
        'product_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'product_created_at';
    const UPDATED_AT = 'product_updated_at';
    const DELETED_AT = 'product_deleted_at';

    public function scopeSearch($query, $search){
        if ($search){
            return $query->whereRaw("(
                lower(product_code) like '%". strtolower($search) ."%'
                OR lower(product_description) like '%". strtolower($search) ."%'
            )");
        }
    }
}
