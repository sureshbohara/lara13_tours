<?php
declare(strict_types=1);
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['package_id', 'name', 'email', 'address', 'review', 'rating', 'status'])]

class PackageReview extends Model
{

    protected $casts = ['status' => 'boolean', 'rating' => 'integer'];

    public function package(){
       return $this->belongsTo(Package::class); 
   }
   
}