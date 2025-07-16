<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hiringportal extends Model
{
    use HasFactory;
   
	protected $fillable = ['Title', 'IsPaid', 'SubscriptionStartDT', 'SubscriptionEndDT', 'Notes'];

           
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}    
?>        