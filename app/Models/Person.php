<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Person extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'company_id', 'name', 'lastname', 'title', 'email', 'phone'
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}