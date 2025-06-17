<?php

namespace SolutionPlus\Cms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Mabrouk\Translatable\Rules\RequiredForLocale;
use SolutionPlus\Cms\Rules\UniqueForLocaleWithinParent;
use SolutionPlus\Cms\Models\SectionItem;

class SectionItemUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'min:3',
                'max:190',
                new UniqueForLocaleWithinParent(
                    parentObject: $this->section,
                    relationName: 'sectionItems',
                    translationForeignKeyName: 'section_item_id',
                    modelObject: $this->section_item,
                ),
                new RequiredForLocale($this->section_item),
            ],
            'title' => array_merge([
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_items_title) {
                        return $fail(__('section_items.errors.title_not_available'));
                    }
                }
            ], explode('|', $this->section_item->title_validation_text)),
            'description' => array_merge([
                function ($attribute, $value, $fail) {
                    if (!$this->section->has_items_description) {
                        return $fail(__('section_items.errors.description_not_available'));
                    }
                }
            ], explode('|', $this->section_item->description_validation_text)),
        ];
    }

    /**
     * Update the section item with the validated data.
     */
    public function sectionItemUpdate(): SectionItem
    {
        return DB::transaction(function () {
            $this->section_item->update();

            return $this->section_item->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'name' => __('solutionplus/cms/section_items.attributes.name'),
            'title' => __('solutionplus/cms/section_items.attributes.title'),
            'description' => __('solutionplus/cms/section_items.attributes.description'),
        ];
    }
}
