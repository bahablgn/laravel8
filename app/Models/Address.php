<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Address extends Model
{
    use HasFactory;

    protected  $primaryKey = 'id';
  
    protected $fillable = [
        'id', 'company_id', 'address'
    ];

    protected $table = 'addresses';

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}