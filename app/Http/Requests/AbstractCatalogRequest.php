<?php

declare(strict_types=1);

namespace App\Http\Requests;

// use App\Rules\CategoryParent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

/**
 *
 */
abstract class AbstractCatalogRequest extends FormRequest
{

    /**
     * С какой сущностью сейчас работаем: категория, бренд, товар
     *
     * @var array
     */
    protected array $entity = [];

    public function authorize(): bool
    {
        return TRUE;
    }

    public function rules(): array|bool
    {
        return match ($this->method()) {
            'POST'         => $this->createItem(),
            'PUT', 'PATCH' => $this->updateItem(),
            default        => FALSE,
        };
    }

    // Можно записать другой вариант
    // public function rules() {
    //     switch ($this->route()->getName()) {
    //         case 'admin.item.create':
    //             return $this->createItem();
    //         case 'admin.item.update':
    //             return $this->updateItem();
    //     }
    // }

    /**
     * Задает дефолтные правила для проверки данных при добавлении
     * категории, бренда или товара
     */
    #[ArrayShape([
        'name'    => "string[]",
        'slug'    => "string[]",
        'content' => "string[]",
        'image'   => "string[]",
    ])]
    protected function createItem(): array
    {
        return [
            'name'    => [
                'required',
                'max:100',
            ],
            'slug'    => [
                'required',
                'max:100',
                'unique:' . $this->entity['table'] . ',slug',
                'regex:~^[-_a-z0-9]+$~i',
            ],
            'content' => [
                'nullable',
            ],
            'image'   => [
                'mimes:jpeg,jpg,png',
                'max:5000',
            ],
        ];
    }

    /**
     * Задает дефолтные правила для проверки данных при обновлении
     * категории, бренда или товара
     */
    #[ArrayShape([
        'name'    => "string[]",
        'slug'    => "array",
        'content' => "string[]",
        'image'   => "string[]",
    ])]
    protected function updateItem(): array
    {
        // получаем объект модели из маршрута: admin/entity/{entity}
        $model = $this->route($this->entity['name']);
        return [
            'name'    => [
                'required',
                'max:100',
            ],
            'slug'    => [
                'required',
                'min:3',
                'max:100',
                // проверка на уникальность slug, исключая эту сущность по идентификатору
                // 'unique:'.$this->entity['table'].',slug,'.$model->id.',id',
                Rule::unique($this->entity['table'], 'slug')->ignore($model->id),
                'regex:~^[-_a-z0-9]+$~i',
            ],
            'content' => [
                'nullable',
            ],
            'image'   => [
                'mimes:jpeg,jpg,png',
                'max:5000',
            ],
        ];
    }

    /**
     * Возвращает массив сообщений об ошибках для заданных правил
     *
     * @return array
     */
    #[ArrayShape([
        'name' => "string[]",
        'slug' => "string[]",
        'image' => "string[]",
    ])]
    public function messages(): array
    {
        return [
            'name' => [
                'required' => 'Поле «:attribute» обязательно для заполнения',
                'max'      => 'Поле «:attribute» должно быть не больше :max символов',
            ],

            'slug' => [
                'required' => 'Поле «:attribute» обязательно для заполнения',
                'unique'   => 'Поле «:attribute» должно быть уникальным значением',
                'regex'    => 'Поле «:attribute» допускает только буквы, цифры, «-» и «_»',
                'max'      => 'Поле «:attribute» должно быть не больше :max символов',
            ],

            'image'   => [
                'mimes' => 'Поле «:attribute» должно быть только jpeg,jpg,png',
                'max' => 'Поле «:attribute» должно быть не больше :max байт',
            ],
        ];
    }

    /**
     * Возвращает массив дружественных пользователю названий полей
     *
     * @return array
     */
    #[ArrayShape([
        'name' => "string",
        'slug' => "string",
        'image' => "string",
    ])]
    public function attributes(): array
    {
        return [
            'name' => 'Имя, Фамилия',
            'slug' => 'ЧПУ (англ)',
            'image' => 'Изображение',
        ];
    }

}
