<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\AbstractCatalogRequest;
use App\Rules\CategoryParent;
use JetBrains\PhpStorm\ArrayShape;

class CategoryCatalogRequest extends AbstractCatalogRequest
{
    /**
     * С какой сущностью сейчас работаем (категория каталога)
     *
     * @var array
     */
    protected array $entity = [
        'name'  => 'category',
        'table' => 'categories',
    ];

    // /**
    //  * @return bool
    //  */
    // public function authorize(): bool
    // {
    //     return parent::authorize();
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return parent::rules();
    }


    /**
     * Объединяет дефолтные правила и правила, специфичные для категории
     * для проверки данных при добавлении новой категории
     */
    protected function createItem(): array
    {
        $rules = [
            'parent_id' => [
                'required',
                'regex:~^[0-9]+$~',
            ],
        ];

        return array_merge(parent::createItem(), $rules);
    }


    /**
     * Объединяет дефолтные правила и правила, специфичные для категории
     * для проверки данных при обновлении существующей категории
     */
    protected function updateItem(): array
    {
        // получаем объект модели категории из маршрута: admin/category/{category}
        $model = $this->route('category');
        $rules = [
            'parent_id' => [
                'required',
                'regex:~^[0-9]+$~',
                // задаем правило, чтобы категорию нельзя было поместить внутрь себя
                new CategoryParent($model)
                // new CategoryParent($this),
            ],
        ];

        return array_merge(parent::updateItem(), $rules);
    }

    /**
     * Возвращает массив сообщений об ошибках для заданных правил
     *
     * @return array
     */
    #[ArrayShape([
        'required' => "string",
        'regex'    => "string",
        'invalid'  => "string",
    ])]
    public function messages(): array
    {
        return [
            'required' => 'Поле «:attribute» обязательно для заполнения',
            'regex'    => 'Поле «:attribute» должно быть целым положительным числом',
            'invalid'  => 'Категорию нельзя поместить внутрь самой себя',
        ];
    }

    /**
     * Возвращает массив дружественных пользователю названий полей
     *
     * @return array
     */
    #[ArrayShape([
        'parent_id' => "string",
    ])]
    public function attributes(): array
    {
        return [
            'parent_id' => 'Родительская категория',
        ];
    }


    // switch($this->method()) {
    //     case 'POST':
    //         return [
    //             'name'      => 'required|max:100',
    //             'slug'      => 'required|max:100|unique:categories,slug|alpha_dash|regex:~^[-_a-z0-9]+$~i',
    //             'parent_id' => 'integer',
    //             'content'   => 'nullable',
    //             'image'     => 'mimes:jpeg,jpg,png|max:5000',
    //         ];
    //     case 'PUT':
    //     case 'PATCH':
    //         $model = $this->route('category');
    //         $id = $model->id;
    //         return [
    //             'name'      => 'required|max:100',
    //             /*
    //              * Проверка на уникальность slug, исключая эту категорию по идентификатору:
    //              * 1. categories — таблица базы данных, где проверяется уникальность
    //              * 2. slug — имя колонки, уникальность значения которой проверяется
    //              * 3. значение, по которому из проверки исключается запись таблицы БД
    //              * 4. поле, по которому из проверки исключается запись таблицы БД
    //              * Для проверки будет использован такой SQL-запрос к базе данных
    //              * SELECT COUNT(*) FROM `categories` WHERE `slug` = '...' AND `id` <> 17
    //              */
    //             'slug'      => ['required', Rule::unique('categories', 'slug')->ignore($this->category->id), 'min:3', 'max:100', 'alpha_dash', 'regex:~^[-_a-z0-9]+$~i'],
    //             // задаем правило валидации, что категорию не пытаются поместить внутрь себя
    //             'parent_id' => ['regex:~^[0-9]+$~', new CategoryParent($model)], //'integer',
    //             'content'   => 'nullable',
    //             'image'     => 'mimes:jpeg,jpg,png|max:5000',
    //         ];
    // }
}
