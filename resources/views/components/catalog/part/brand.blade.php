<div class='col-md-6 mb-4'>
    <div class='card'>
        <div class='card-header'>
            <h4>{{ $brand->name }}</h4>
        </div>
        <div class='card-body p-0 m-auto'>
            <img src="{{ $brand->full_image ?? Vite::asset('resources/images/default2.jpg') }}" alt="{{ $brand->name }}" class="img-fluid">
        </div>
        <div class='card-footer'>
            <a href="{{ route('catalog.brand', [$brand->slug]) }}" class="btn btn-dark">Перейти в раздел</a>
        </div>
    </div>
</div>
