<ul>
@foreach($items as $item)
    <li>
        <a href="{{ route('catalog.category', [$item->slug]) }}">{{ $item->name }}</a>

        @if ($item->children->count())
            <span class="badge badge-dark children-category">
                <i class="fa fa-plus"></i> <!-- бейдж с плюсом или минусом -->
            </span>
            <x-branch :items='$item->descendants'></x-branch>
        @endif
    </li>
@endforeach
</ul>
