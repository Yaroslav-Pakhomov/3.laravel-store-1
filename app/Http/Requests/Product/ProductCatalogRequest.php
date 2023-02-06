<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\AbstractCatalogRequest;
use JetBrains\PhpStorm\ArrayShape;

class ProductCatalogRequest extends AbstractCatalogRequest
{
    /**
     * С какой сущностью сейчас работаем (товар каталога)
     *
     * @var array
     */
    protected array $entity = [
        'name'  => 'product',
        'table' => 'products',
    ];

    // public function authorize(): bool
    // {
    //     return parent::authorize();
    // }

    // public function rules(): array
    // {
    //     return parent::rules();
    // }

    /**
     * Объединяет дефолтные правила и правила, специфичные для товара
     * для проверки данных при добавлении нового товара
     */
    protected function createItem(): array
    {
        $rules = [
            'category_id' => [
                'required',
                'integer',
                'min:1',
            ],
            'brand_id'    => [
                'required',
                'integer',
                'min:1',
            ],
            'price'       => [
                'required',
                'numeric',
                'min:1',
            ],
        ];

        return array_merge(parent::createItem(), $rules);
    }

    /**
     * Объединяет дефолтные правила и правила, специфичные для товара
     * для проверки данных при обновлении существующего товара
     */
    protected function updateItem(): array
    {
        $rules = [
            'category_id' => [
                'required',
                'integer',
                'min:1',
            ],
            'brand_id'    => [
                'required',
                'integer',
                'min:1',
            ],
            'price'       => [
                'required',
                'numeric',
                'min:1',
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
        'integer'  => "string",
        'numeric'  => "string",
        'min'      => "string",
    ])]
    public function messages(): array
    {
        return [
            'required' => 'Поле «:attribute» обязательно для заполнения',
            'integer'  => 'Поле «:attribute» должно быть целым положительным числом',
            'numeric'  => 'Поле «:attribute» должно быть положительным числом',
            'min'      => 'Поле «:attribute» обязательно для заполнения',
        ];
    }

    /**
     * Возвращает массив дружественных пользователю названий полей
     *
     * @return array
     */
    #[ArrayShape([
        'parent_id'   => "string",
        'category_id' => "string",
        'brand_id'    => "string",
        'price'       => "string",
    ])]
    public function attributes(): array
    {
        return [
            'parent_id'   => 'Родитель',
            'category_id' => 'Категория',
            'brand_id'    => 'Бренд',
            'price'       => 'Цена',
        ];
    }
}
