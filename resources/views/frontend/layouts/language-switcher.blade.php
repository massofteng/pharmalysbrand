<div class="location-language">
    <h2 class="color-blue vf-600 vfs-24 mb-5">{{__('header.location_and_location')}}</h2>
    <label for="location">{{__('header.location')}}</label>
    <select id="location" class="form-select form-select-lg">
        @if(get_countries())
            @foreach(get_countries() as $country)
                <option value="{{ $country->id }}">{{ $country->name}}</option>
            @endforeach
        @endif
    </select>
    <label for="language">{{__('header.language')}}</label>
    <select id="language" class="form-select form-select-lg"></select>
    <button type="submit" onClick="changeLanguage()" class="language-location-submit btn v-btn-1 br-35 vf-600">
        {{__('header.continue')}}
    </button>
</div>