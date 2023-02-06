<form action="{{ route('basket.checkout') }}" method="get" id="profiles">
    <div class="d-flex flex-wrap justify-content-between">
        <div class="form-group w-75">
            <label class="d-none" for="profile_id"></label>
            <select name="profile_id" id="profile_id" class="form-control">
                <option value="0">Выберите профиль</option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}" @if($profile->id === $current) selected @endif>
                        {{ $profile->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group w-25">
            <button type="submit" class="btn btn-primary w-100 ">Выбрать</button>
        </div>
    </div>
</form>
