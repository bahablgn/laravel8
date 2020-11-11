<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Website extends Model
{
    use HasFactory;

    protected  $primaryKey = 'id';
  
    protected $fillable = [
        'id', 'company_id', 'html', 'thumbnail'
    ];

    protected $table = 'websites';

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}