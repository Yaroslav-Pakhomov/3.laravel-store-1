@php
    $level++;
@endphp
@foreach($parentCategories as $item)
    <option value="{{ $item->id }}">
        @if ($level) {!! str_repeat('&nbsp;&nbsp;&nbsp;', $level) !!}  @endif {{ $item->name }}
    </option>
    @if ($item->descendants->count())
        <x-admin.category.part.branch :parentCategories="$item->descendants" :level="$level"></x-admin.category.part.branch>
    @endif
@endforeach
