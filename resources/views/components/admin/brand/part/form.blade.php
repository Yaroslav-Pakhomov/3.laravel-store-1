@csrf
<div class="form-group mb-3">
    <label class="w-100">
        <input type="text" class="form-control" name="name" placeholder="Наименование"
               required maxlength="100" value="{{ old('name') ?? $brand->name ?? '' }}">
    </label>
</div>
<div class="form-group mb-3">
    <label class="w-100">
        <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)" required maxlength="100"
               value="{{ old('slug') ?? $brand->slug ?? '' }}">
    </label>
</div>
<div class="form-group mb-3">
    <label class="w-100">
        <textarea class="form-control" name="content" placeholder="Краткое описание" maxlength="200" rows="3">
            {{ old('content') ?? $brand->content ?? '' }}
        </textarea>
    </label>
</div>
<div class="form-group mb-3">
    <input type="file" class="form-control-file btn btn-outline-primary mb-2" name="image"
           accept="image/png, image/jpeg">
</div>
@isset($brand->image)
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">Удалить загруженное изображение</label>
    </div>
@endisset
<div class="form-group mb-3">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
