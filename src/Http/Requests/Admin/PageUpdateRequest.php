<?php

namespace SolutionPlus\DynamicPages\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Mabrouk\Translatable\Rules\RequiredForLocale;
use SolutionPlus\DynamicPages\Models\Page;

class PageUpdateRequest extends FormRequest
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
                'max:255',
                new RequiredForLocale($this->page),
            ],
            'title' => [
                'string',
                'min:3',
                'max:255',
                new RequiredForLocale($this->page),
            ],
            'description' => [
                'string',
                'min:3',
                'max:40000',
                new RequiredForLocale($this->page),
            ],
        ];
    }

    /**
     * Update the page with the validated data.
     */
    public function updatePage(): Page
    {
        return DB::transaction(function () {
            $this->page->update();

            return $this->page->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'name' => __('solutionplus/dynamic_pages/pages.attributes.name'),
            'title' => __('solutionplus/dynamic_pages/pages.attributes.title'),
            'description' => __('solutionplus/dynamic_pages/pages.attributes.description'),
        ];
    }
}
