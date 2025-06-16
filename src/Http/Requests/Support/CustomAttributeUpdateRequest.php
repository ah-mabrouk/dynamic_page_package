<?php

namespace SolutionPlus\Cms\Http\Requests\Support;

use Illuminate\Foundation\Http\FormRequest;
use Mabrouk\Translatable\Rules\RequiredForLocale;
use Mabrouk\Translatable\Rules\UniqueForLocaleWithinParent;
use SolutionPlus\Cms\Models\CustomAttribute;

class CustomAttributeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key' => 'sometimes|string|regex:/^[a-z0-9-_]+$/|min:3|max:50|unique:custom_attributes,key,' . $this->custom_attribute->id,
            'name' => [
                'string',
                'min:3',
                'max:190',
                new UniqueForLocaleWithinParent(
                    parentObject: $this->section_item ?: $this->section,
                    relationName: 'customAttributes',
                    translationForeignKeyName: 'custom_attribute_id',
                    modelObject: $this->custom_attribute,
                ),
                new RequiredForLocale($this->custom_attribute),
            ],
            'value' => 'nullable|required_with:value_validation_text|string|min:3|max:190',
            'value_validation_text' => 'nullable|required_with:value|string|min:3|max:190',
        ];
    }

    public function updateCustomAttribute(): CustomAttribute
    {
        $this->custom_attribute->update([
            'key' => $this->exists('key') ? $this->key : $this->custom_attribute->key,
            'value_validation_text' => $this->exists('value_validation_text') ? $this->value_validation_text : $this->custom_attribute->value_validation_text,
        ]);

        return $this->custom_attribute->refresh();
    }

    public function attributes(): array
    {
        return [
            'key' => __('solutionplus/cms/custom_attributes.attributes.key'),
            'name' => __('solutionplus/cms/custom_attributes.attributes.name'),
            'value' => __('solutionplus/cms/custom_attributes.attributes.value'),
            'value_validation_text' => __('solutionplus/cms/custom_attributes.attributes.value_validation_text'),
        ];
    }
}
