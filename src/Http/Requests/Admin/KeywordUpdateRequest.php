<?php

namespace SolutionPlus\Cms\Http\Requests\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Mabrouk\Translatable\Rules\RequiredForLocale;
use SolutionPlus\Cms\Models\Keyword;

class KeywordUpdateRequest extends FormRequest
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
            'name' => 'sometimes|required|string|min:3|max:50',
            'visible' => 'sometimes|boolean',
        ];
    }

    protected function getValidatorInstance()
    {
        $this->merge(format_json_strings_to_boolean(['is_visible']));
        return parent::getValidatorInstance();
    }

    public function updateKeyword(): Keyword
    {
        return DB::transaction(function () {
            $this->keyword->update([
                'is_visible' => $this->exists('is_visible') ? $this->is_visible : $this->keyword->is_visible,
            ]);

            return $this->keyword->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'name' => __('solutionplus/cms/keywords.attributes.name'),
            'is_visible' => __('solutionplus/cms/keywords.attributes.visible'),
        ];
    }
}
