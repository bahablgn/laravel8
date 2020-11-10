<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Employee extends Model
{
    use HasFactory;

    protected  $primaryKey = 'id';
  
    protected $fillable = [
        'id', 'company_id', 'name', 'lastname', 'title', 'email', 'phone'
    ];

    protected $table = 'employees';

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}