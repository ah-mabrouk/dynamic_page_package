<?php

namespace SolutionPlus\Cms\Models;

use SolutionPlus\Cms\Traits\HasTimezoneFields;
use Illuminate\Database\Eloquent\Model;
use Mabrouk\Filterable\Traits\Filterable;
use Mabrouk\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Keyword extends Model
{
    use HasFactory, Translatable, Filterable, HasTimezoneFields;

    public $translatedAttributes = [
        'name',
    ];

    protected $fillable = [
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    ## Relations

    public function pages(): MorphToMany
    {
        return $this->morphedByMany(Page::class, 'related_object', 'keyword_related_objects');
    }

    public function keywordRelatedObjects(): HasMany
    {
        return $this->hasMany(KeywordRelatedObject::class, 'keyword_id');
    }

    ## Getters & Setters

    ## Scopes

    public function scopeVisible($query, bool $visible = true)
    {
        return $query->where('is_visible', $visible);
    }

    ## Other Methods

    public function remove(): bool
    {
        $this->deleteTranslations();
        $this->delete();

        return true;
    }
} 