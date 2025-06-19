<?php

namespace SolutionPlus\DynamicPages\Models;

use Illuminate\Database\Eloquent\Model;
use Mabrouk\Filterable\Traits\Filterable;
use Mabrouk\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomAttribute extends Model
{
    use HasFactory, Translatable, Filterable;

    public $translatedAttributes = [
        'name',
        'value',
    ];

    protected $fillable = [
        'related_object_id',
        'related_object_type',
        'key',
        'value_validation_text',
    ];

    public function getRouteKeyName(): string
    {
        return 'key';
    }

    ## Relations

    public function relatedObject(): MorphTo
    {
        return $this->morphTo('related_object');
    }

    ## Getters & Setters

    ## Scopes

    ## Other Methods

    public function remove(): bool
    {
        $this->deleteTranslations();
        $this->delete();

        return true;
    }
} 