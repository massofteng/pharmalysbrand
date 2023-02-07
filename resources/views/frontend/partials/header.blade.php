<!--===header===-->
<header class="<?php echo ( $currentRoute=='frontend.home' ) ? 'home': '' ?>">
    <div class="container-fluid">
        <div class="row align-items-center position-relative">
            <div class="col-md-2 v-logo">
                <div class="logo">
                    <a href="{{ route('frontend.home')}}">
                        <img class="img-all" src="assets/img/logo.svg" alt="Logo">
                        <img class="img-home" src="assets/img/logo-white.svg" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="v-menu col-md-10 d-flex justify-content-between align-items-center">
                <div class="main-menu">
                    <ul>
                        <li><a class="active" href="{{ route('frontend.about')}}">About</a></li>
                        <li><a href="{{ route('frontend.brands')}}">Brands</a></li>
                        <li><a href="{{ route('frontend.stories')}}">Stories</a></li>
                        <li><a href="{{ route('frontend.partners')}}">Partners</a></li>
                    </ul>
                </div>
                <div class="location-cta" id="location-cta">
                    <ul class="d-flex align-content-between">
                        <li>
                            <a href="#link">
                                <img class="me-2 img-all" src="assets/img/world.svg" alt="world">
                                <img class="me-2 img-home" src="assets/img/world-home.svg" alt="world">
                                <span id="country_name"></span> 
                            </a>
                        </li>
                        <li><a href="#link">|</a></li>
                        <li><a href="#link" id="language_name"></a></li>
                    </ul>
                </div>
            </div>
            <!--Location and Language-->
            <div class="col-12">
                @include('frontend.layouts.language-switcher')
            </div>
            <!--Location and Language-->
        </div>
    </div>
</header>
<!--mobile menu-->
<div class="mobile-menu position-relative">
    <span class="m-menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMobile"
          aria-controls="offcanvasMobile">
        <img src="assets/img/menu.png" alt="Menu">
    </span>
    <div class="bg-blue offcanvas offcanvas-top" tabindex="-1" id="offcanvasMobile"
         aria-labelledby="offcanvasMobileLabel">
        <div class="offcanvas-body ">
            <a href="#link">
                <img src="assets/img/logo-white.svg" alt="Logo">
            </a>
            <div class="m-m-container align-items-baseline">
                <ul>
                    <li><a href="#link">About</a></li>
                    <li><a href="#link">Brand</a></li>
                    <li><a href="#link">Stories</a></li>
                    <li><a href="#link">Partners</a></li>
                </ul>
                <div class="offcanvas-header align-items-center">
                    <span class="offcanvas-title d-flex offcanvasMobileLabel" id="offcanvasMobileLabel">
                        <img class="me-2" src="assets/img/world-home.svg" alt="world">
                        <a href="#link">
                            <span class="country" id="mobile_country_name">Switzerland</span> 
                            <br><span class="location" id="mobile_language_name">English</span> 
                        </a>
                    </span>
                    <span class="v-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <img src="assets/img/close.png" alt="Close">
                </span>
                </div>
                {{-- <div class="location-language">
                    <h2 class="color-blue vf-600 vfs-24 mb-5">AALocation and Language</h2>
                    <label for="location">Locatioin</label>
                    <select id="location" class="form-select form-select-lg">
                        <option class="selected-option" selected>Switzerland</option>
                        <option value="1">BD</option>
                        <option value="2">USA</option>
                        <option value="3">UK</option>
                    </select>
                    <label for="language">Language</label>
                    <select id="language" class="form-select form-select-lg ">
                        <option class="selected-option" selected>English</option>
                        <option value="1">Switzerland</option>
                        <option value="2">BD</option>
                        <option value="3">DE</option>
                    </select>
                    <button type="submit" class="language-location-submit btn v-btn-1 br-35 vf-600">
                        Continue
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>

function geotargetly_loaded(){
    var geo_country_name = geotargetly_country_name();
    $("#country_name").text(geo_country_name);
    var language_key = localStorage.getItem("language_key");
    var language_name = localStorage.getItem("language_name");
    var language_id = localStorage.getItem("language_id");
    var country = localStorage.getItem("country");
    var country_id = localStorage.getItem("country_id");
    var change = localStorage.getItem("change");

    if(change==1){
        geo_country_name = country;
    }

    if(geo_country_name == country){
        $("#language_name").text(language_name);
        $("#country_name").text(geo_country_name);
        $("select#location").val(country_id).trigger("change");
        var lan_data = getLanguesById(country_id);
        return false;
    }

    var get_language_url = "{{ url('/language') }}";
    var country_option = '';
    jQuery.ajax({
        type: "GET",
        url: get_language_url + '/' + geo_country_name,
        success : function(data) { 
            var countries = data.countries; 
            var languages = data.languages; 
            var option = '';
            languages.forEach(function(item) {
                if(item.default==1){
                    $("#language_name").text(item.language_name);
                    localStorage.setItem("language_name", item.language_name);
                    localStorage.setItem("language_key", item.language_key);
                    localStorage.setItem("language_id", item.id);
                    localStorage.setItem("country", geo_country_name);
                    localStorage.setItem("country_id", country_id);

                    option +="<option class='selected-option' value='"+item.id+"' selected>"+item.language_name+"</option>";
                    country_option = "<option class='selected-option' value='"+item.country_id+"'selected>" + geo_country_name + "</option>";
                }else{
                    option +="<option value='"+item.id+"'>"+item.language_name+"</option>";
                }
            });
            $("#country_name").text(geo_country_name);
            $("#language").html(option);
            countries.forEach(function(item) {
                country_option +="<option value='"+item.id+"'>"+item.name+"</option>";
            });
            $("#location").html(country_option);
            location.reload();
        }
    });
}


function changeLanguage(){ 
    var lan_id= $("#language option:selected").val();
    var lan_name= $("#language option:selected").text();
    var country_name= $("#location option:selected").text();
    var country_id= $("#location option:selected").val();
    var get_language_url = "{{ url('/change-language') }}";
    jQuery.ajax({
        type: "GET",
        url: get_language_url + '/' + lan_id + '/'+ country_name,
        success : function(data) { 
            localStorage.setItem("language_key", data);
            localStorage.setItem("language_name", lan_name);
            localStorage.setItem("language_id", lan_id);
            localStorage.setItem("country", country_name);
            localStorage.setItem("country_id", country_id);
            localStorage.setItem("change",1);
            location.reload();
        }
    });
}

$("#location").on('change', function(){
    getLanguesById(this.value);
})

function getLanguesById(id){
    var get_language_by_id = "{{ url('/get_language_by_id') }}";
    jQuery.ajax({
        type: "GET",
        url: get_language_by_id + '/' + id,
        success : function(data) { 
            console.log(data);
            var lan_option = '';
            data.forEach(function(item) {
                if(item.default==1){
                    lan_option +="<option class='selected-option' value='"+item.id+"' selected>"+item.language_name+"</option>";
                }else{
                    lan_option +="<option value='"+item.id+"'>"+item.language_name+"</option>";
                }
            });
            $("#language").html(lan_option);
        }
    });
}
</Script>
<!--mobile menu-->
<!--===header===-->