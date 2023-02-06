@csrf
<div class="form-group mb-3">
    <label class="w-100">
        <input type="text" class="form-control" name="name" placeholder="Наименование"
               required maxlength="100" value="{{ old('name') ?? $category->name ?? '' }}">
    </label>
</div>
<div class="form-group mb-3">
    <label class="w-100">
        <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)" required maxlength="100"
               value="{{ old('slug') ?? $category->slug ?? '' }}">
    </label>
</div>
<div class="form-group mb-3">
    @php
        $parent_id = old('parent_id') ?? $category->parent_id ?? 0;
    @endphp
    <select name="parent_id" class="form-control" title="Родитель">
        <option value="0">Без родителя</option>
        @if (count($parentCategories))
            <x-admin.category.part.branch :parentCategories="$parentCategories" :level="-1"></x-admin.category.part.branch>
        @endif
    </select>
</div>
<div class="form-group mb-3">
    <label class="w-100">
        <textarea class="form-control" name="content" placeholder="Краткое описание" maxlength="200" rows="3">
            {{ old('content') ?? $category->content ?? '' }}
        </textarea>
    </label>
</div>
<div class="form-group mb-3">
    <input type="file" class="form-control-file btn btn-outline-primary mb-2" name="image" accept="image/png, image/jpeg">
</div>
@isset($category->image)
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">Удалить загруженное изображение</label>
    </div>
@endisset
<div class="form-group mb-3">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
