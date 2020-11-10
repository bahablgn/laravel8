<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Company extends Model
{
    use HasFactory;

    protected  $primaryKey = 'id';
  
    protected $fillable = [
        'id', 'name', 'url'
    ];

    protected $table = 'companies';

    public function employee()
    {
        return $this->hasMany('App\Models\Employee','company_id');
    }
}