<?php

namespace App\Rules;

// use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

/**
 * Нужно для проверки, что при редактировании категории в качестве родителя
 * не будет выбрана эта же категория или один из ее потомков. Здесь простыми
 * правилами валидации не обойтись.
 */
class CategoryParent implements Rule
{
    private object $category;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    // public function __construct(Category $category)
    public function __construct(object $category)
    {
        $this->category = $category;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $this->category->validParent($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        // return 'The validation error message.';
        return trans('validation.custom.parent_id.invalid');
    }
}
