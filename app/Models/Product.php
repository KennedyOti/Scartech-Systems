<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'brand',
        'model_number',
        'summary',
        'description',
        'specifications',
        'features',
        'image',
        'gallery',
        'datasheet_path',
        'is_featured',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'features' => 'array',
            'gallery' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param  Builder<Product>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<Product>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * @return BelongsTo<ProductCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * @return Attribute<string, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): string => asset($this->image ?? 'images/placeholders/product.jpg'));
    }

    /**
     * All images for the gallery, main image first.
     *
     * @return Attribute<list<string>, never>
     */
    protected function galleryImages(): Attribute
    {
        return Attribute::get(fn (): array => array_values(array_unique(array_filter([
            $this->image ?? 'images/placeholders/product.jpg',
            ...($this->gallery ?? []),
        ]))));
    }
}
