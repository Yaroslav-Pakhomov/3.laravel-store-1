<div class='col-md-6 mb-4'>
    <div class='card-header'>
        <h3 class="mb-0">{{ $product->name }}</h3>
    </div>
    <div class='card-body p-0  position-relative'>
        <div class="position-absolute">
            @if($product->new)
                <span class="badge badge-info text-white ml-1">Новинка</span>
            @endif
            @if($product->hit)
                <span class="badge badge-danger ml-1">Лидер продаж</span>
            @endif
            @if($product->sale)
                <span class="badge badge-success ml-1">Распродажа</span>
            @endif
        </div>
        <img src="{{ $product->full_image ?? Vite::asset('resources/images/default.jpg') }}" alt="{{ $product->name }}" class="img-fluid">
    </div>
    <div class='card-footer mt-2 d-flex justify-content-between'>
        {{-- Форма для добавления товара в корзину --}}
        <form action="{{ route('basket.add', [$product->slug]) }}" method="POST" class="d-inline add-to-basket">
            @csrf
            <button type="submit" class="btn btn-success">Добавить в корзину</button>
        </form>
        <a href="{{ route('catalog.product', [$product->slug]) }}" class="btn btn-dark">Перейти к товару</a>
    </div>
</div>
