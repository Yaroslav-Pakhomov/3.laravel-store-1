<div id="brand-sidebar">
    <h4>Популярные бренды</h4>
    <ul>
    @foreach($brands as $brand)
        <li>
            <a href="{{ route('catalog.brand', [$brand->slug]) }}">{{ $brand->name }}</a>
            <span class="badge badge-dark float-right">{{ $brand->products_count }}</span>
        </li>
    @endforeach
    </ul>
</div>
