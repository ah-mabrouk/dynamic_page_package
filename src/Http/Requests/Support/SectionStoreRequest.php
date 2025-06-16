<?php

namespace SolutionPlus\Cms\Http\Requests\Support;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use SolutionPlus\Cms\Models\Section;
use Mabrouk\Translatable\Rules\UniqueForLocaleWithinParent;

class SectionStoreRequest extends FormRequest
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
            'identifier' => 'required|regex:/^[a-z0-9-_]+$/|string|min:3|max:50|unique:sections,identifier',
            'name' => [
                'required',
                'string',
                'min:3',
                'max:190',
                new UniqueForLocaleWithinParent(
                    parentObject: $this->page,
                    relationName: 'sections',
                    translationForeignKeyName: 'section_id',
                    modelClass: 'Section'
                ),
            ],
            'title' => array_merge([
                'required_if:has_title,true',
                function ($attribute, $value, $fail) {
                    if (!$this->has_title) {
                        return $fail(__('solutionplus/cms/sections.errors.title_not_available'));
                    }
                }
            ], explode('|', $this->title_validation_text)),

            'description' => array_merge([
                'required_if:has_description,true',
                function ($attribute, $value, $fail) {
                    if (!$this->has_description) {
                        return $fail(__('solutionplus/cms/sections.errors.description_not_available'));
                    }
                }
            ], explode('|', $this->description_validation_text)),

            'has_title' => 'required|boolean',
            'has_description' => 'required|boolean',
            'images_count' => 'required|integer|min:0',

            'has_items' => 'required|boolean',
            'has_items_title' => 'required|boolean',
            'has_items_description' => 'required|boolean',
            'item_images_count' => 'required|integer|min:0',

            'title_validation_text' => [
                'required_if:has_title,true',
                'string',
                'min:3',
                'max:190',
                function ($attribute, $value, $fail) {
                    if (!$this->has_title) {
                        return $fail(__('solutionplus/cms/sections.errors.title_not_available'));
                    }
                }
            ],

            'description_validation_text' => [
                'required_if:has_description,true',
                'string',
                'min:3',
                'max:190',
                function ($attribute, $value, $fail) {
                    if (!$this->has_description) {
                        return $fail(__('solutionplus/cms/sections.errors.description_not_available'));
                    }
                }
            ],
        ];
    }

    protected function getValidatorInstance()
    {
        $this->merge(format_json_strings_to_boolean([
            'has_title',
            'has_description',
            'has_items',
            'has_items_title',
            'has_items_description',
        ]));

        return parent::getValidatorInstance();
    }

    /**
     * Store a new section with the validated data.
     */
    public function storeSection(): Section
    {
        return DB::transaction(function () {
            $section = $this->page->sections()->create([
                'identifier' => $this->identifier,
                'has_title' => $this->is_has_title,
                'has_description' => $this->is_has_description,
                'images_count' => $this->images_count,
                'has_items' => $this->is_has_items,
                'has_items_title' => $this->is_has_items_title,
                'has_items_description' => $this->is_has_items_description,
                'item_images_count' => $this->item_images_count,
                'title_validation_text' => $this->title_validation_text,
                'description_validation_text' => $this->description_validation_text,
            ]);

            return $section->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'name' => __('solutionplus/cms/sections.attributes.name'),
            'title' => __('solutionplus/cms/sections.attributes.title'),
            'description' => __('solutionplus/cms/sections.attributes.description'),
            'has_title' => __('solutionplus/cms/sections.attributes.has_title'),
            'has_description' => __('solutionplus/cms/sections.attributes.has_description'),
            'images_count' => __('solutionplus/cms/sections.attributes.images_count'),
            'has_items' => __('solutionplus/cms/sections.attributes.has_items'),
            'has_items_title' => __('solutionplus/cms/sections.attributes.has_items_title'),
            'has_items_description' => __('solutionplus/cms/sections.attributes.has_items_description'),
            'item_images_count' => __('solutionplus/cms/sections.attributes.item_images_count'),
            'title_validation_text' => __('solutionplus/cms/sections.attributes.title_validation_text'),
            'description_validation_text' => __('solutionplus/cms/sections.attributes.description_validation_text'),
        ];
    }
}
