@csrf
<div class="form-group mt-3">
    <label for="name"></label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Наименование" required maxlength="100"
               value="{{ old('name') ?? $product->name ?? '' }}">

</div>

<div class="form-group">
    <label for="slug"></label>
    <input type="text" class="form-control" name="slug" id="slug" placeholder="ЧПУ (на англ.)" required maxlength="100"
               value="{{ old('slug') ?? $product->slug ?? '' }}">
</div>


<div class="form-group mt-3">
    <!-- цена (руб) -->
    <label class="form-check-label w-0 p-0 m-0" for="price"></label>
    <input type="text" class="form-control w-25 d-inline mr-4 form-check-inline" placeholder="Цена (руб.)" id="price"
                   name="price" required value="{{ old('price') ?? $product->price ?? '' }}">
    <!-- новинка -->
    <div class="form-check form-check-inline">
        @php
            $checked = FALSE; // создание нового товара
            if (isset($product)) $checked = $product->new; // редактирование товара
            if (old('new')) $checked = TRUE; // были ошибки при заполнении формы
        @endphp
        <input type="checkbox" name="new" class="form-check-input" id="new-product"
               @if($checked) checked @endif value="1">
        <label class="form-check-label" for="new-product">Новинка</label>
    </div>
    <!-- лидер продаж -->
    <div class="form-check form-check-inline">
        @php
            $checked = FALSE; // создание нового товара
            if (isset($product)) $checked = $product->hit; // редактирование товара
            if (old('hit')) $checked = TRUE; // были ошибки при заполнении формы
        @endphp
        <input type="checkbox" name="hit" class="form-check-input" id="hit-product"
               @if($checked) checked @endif value="1">
        <label class="form-check-label" for="hit-product">Лидер продаж</label>
    </div>
    <!-- распродажа -->
    <div class="form-check form-check-inline ">
        @php
            $checked = FALSE; // создание нового товара
            if (isset($product)) $checked = $product->sale; // редактирование товара
            if (old('sale')) $checked = TRUE; // были ошибки при заполнении формы
        @endphp
        <input type="checkbox" name="sale" class="form-check-input" id="sale-product"
               @if($checked) checked @endif value="1">
        <label class="form-check-label" for="sale-product">Распродажа</label>
    </div>
    </div>


<div class="form-group mt-3">
    @php
        $category_id = old('category_id') ?? $product->category_id ?? 0;
        $items = $categories;
    @endphp
    <select name="category_id" class="form-control" title="Категория">
        <option value="0">Выберите категорию</option>
        @if (isset($items) && count($items))
            <x-admin.product.part.branch :level=1 :parent=0 :items="$categories" :product="$product"></x-admin.product.part.branch>
        @endif
    </select>
</div>

<div class="form-group mt-3">
    @php
        $brand_id = old('brand_id') ?? $product->brand_id ?? 0;
    @endphp
    <select name="brand_id" class="form-control" title="Бренд">
        <option value="0">Выберите бренд</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}" @if ($brand->id === $brand_id) selected @endif>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group ">
    <label class="form-check-label" for="content"></label>
    <textarea class="form-control" name="content" id="content" placeholder="Описание" rows="6">{{ old('content') ?? $product->content ?? '' }}</textarea>
</div>

<div class="form-group mt-3">
    <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg">
</div>

@isset($product->image)
    <div class="form-group form-check  mt-3">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">
            Удалить загруженное изображение
        </label>
    </div>
@endisset

<div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
