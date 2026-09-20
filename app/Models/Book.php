<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Book extends Model {
 protected $fillable = ['code','isbn','title','author','publisher','year','category_id','shelf','quantity','description'];
 public function category(): BelongsTo { return $this->belongsTo(Category::class); }
 protected function casts(): array { return ['year'=>'integer','quantity'=>'integer']; }
}
