<?php

namespace App\Http\Requests\Brand;

use App\Http\Requests\AbstractCatalogRequest;

// use Illuminate\Foundation\Http\FormRequest;

class BrandCatalogRequest extends AbstractCatalogRequest
{
    /**
     * С какой сущностью сейчас работаем (бренд каталога)
     *
     * @var array
     */
    protected array $entity = [
        'name'  => 'brand',
        'table' => 'brands',
    ];

    // /**
    //  * @return bool
    //  */
    // public function authorize(): bool
    // {
    //     return parent::authorize();
    // }

    /**
     * @return array
     */
    public function rules(): array
    {
        return parent::rules();
    }

    /**
     * Объединяет дефолтные правила и правила, специфичные для бренда
     * для проверки данных при добавлении нового бренда
     */
    protected function createItem(): array
    {
        $rules = [];
        return array_merge(parent::createItem(), $rules);
    }

    /**
     * Объединяет дефолтные правила и правила, специфичные для бренда
     * для проверки данных при обновлении существующего бренда
     */
    protected function updateItem(): array
    {
        $rules = [];
        return array_merge(parent::updateItem(), $rules);
    }


}
