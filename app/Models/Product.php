<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'product_category_id'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            foreach ($product->images as $image) {
                Storage::deleteDirectory("product_images/$image->id");
            }
        });
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->diffForHumans(),
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function stock(): HasOne
    {
        return $this->hasOne(ProductStock::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumbnail()
    {
        $firstImage = $this->images->first();

        return $this->generateBase64FromImagePath($firstImage->path);
    }

    public function base64Images(): Collection
    {
        return $this->images()->get(['id', 'path'])->map(function ($image) {
            return [
                'id' => $image->id,
                'preview' => $this->generateBase64FromImagePath($image->path),
            ];
        });
    }

    protected function generateBase64FromImagePath(string $path): string
    {
        $imagePath = "product_images/{$this->id}/{$path}";
        $imageContent = base64_encode(Storage::get($imagePath));
        $imageMimeType = Storage::mimeType($imagePath);

        return "data:{$imageMimeType};base64,{$imageContent}";
    }
}
