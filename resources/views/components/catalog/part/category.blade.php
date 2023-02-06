<div class='col-md-6 mb-4'>
    <div class='card'>
        <div class='card-header'>
            <h4>{{ $category->name }}</h4>
        </div>
        <div class='card-body p-0 m-auto'>
            <img src="{{ $category->full_image ?? Vite::asset('resources/images/default.jpg') }}" alt="{{ $category->name }}" class="img-fluid">
        </div>
        <div class='card-footer'>
            <a href="{{ route('catalog.category', [$category->slug]) }}" class="btn btn-dark">Перейти в раздел</a>
        </div>
    </div>
</div>
