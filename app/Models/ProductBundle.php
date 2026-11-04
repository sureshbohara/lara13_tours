<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['parent_product_id', 'product_id', 'quantity'])]
class ProductBundle extends Model
{
    protected $table = 'product_bundles';

   
    public function parentProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }

 
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}