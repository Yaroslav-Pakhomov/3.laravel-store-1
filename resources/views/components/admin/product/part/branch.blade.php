@php
    $level++;
@endphp
@foreach ($items->where('parent_id', $parent) as $item)
    @php
        $category_id = old('category_id') ?? $product->category_id ?? 0;
    @endphp
    <option value="{{ $item->id }}" @if ($item->id === $category_id) selected @endif>
        @if ($level) {!! str_repeat('&nbsp;&nbsp;&nbsp;', $level) !!}  @endif {{ $item->name }}
    </option>
    @if (count($items->where('parent_id', $parent)))
        <x-admin.product.part.branch :level='$level' :parent='$item->id' :items="$items" :product="$product"></x-admin.product.part.branch>
    @endif
@endforeach
