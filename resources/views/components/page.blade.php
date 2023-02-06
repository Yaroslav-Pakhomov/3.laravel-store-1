@foreach ($pages->where('parent_id', 0) as $page)
@if (count($pages->where('parent_id', $page->id)))
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $page->name }}
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="{{ route('page.show', [$page->slug]) }}">{{ $page->name }}</a></li>
        <li><hr class="dropdown-divider"></li>
        @foreach ($pages->where('parent_id', $page->id) as $child)
        <li><a class="dropdown-item" href="{{ route('page.show', [$child->slug]) }}">{{ $child->name }}</a></li>
        @endforeach
    </ul>
</li>
@else
<li class="nav-item">
    <a class="nav-link" href="{{ route('page.show', [$page->slug]) }}">
        {{ $page->name }}
    </a>
</li>
@endif
@endforeach
