@extends('frontend.layouts.app')
@section('head')
<x-meta current-page-id="contact" />
@endsection
@section('content')
<div class="v-app ">
    <div class="v-full-width v-b-m">
        <div class="container ">
            <div class="row align-items-center position-relative">
                <div class="col-md-5  d-none d-md-block d-lg-block d-xl-block"  data-aos="fade-up" data-aos-duration="2000">
                    <img class="v-img-left" src="assets/img/work.jpg" alt="Work">
                </div>
                <div class="col-md-7">
                    <div class="mw-480 ms-80 mb-4"  data-aos="fade-up" data-aos-duration="2000">
                        <h1 class="v-heading color-blue ">Contact</h1>
                    </div>
                    <div class="mw-480 pb-160 ms-160"  data-aos="fade-up" data-aos-duration="2000">
                        <p class="v-details color-blue mb-4 ">
                            Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna
                            dolor sagittis lacus.
                        </p>
                    </div>
                    <div class="mw-480 ms-80 mb-4">
                        <a class="v-link v-link-arrow-down" href="#link">
                            <img src="assets/img/arrow-down.png" alt="Arrow Down">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-block d-md-none"  data-aos="fade-up" data-aos-duration="2000">
            <img class="v-img-left" src="assets/img/work-contact.jpg" alt="Work">
        </div>
    </div>
    <div class="container-fluid v-b-m v-md-575">
        <div class="row pt-160 pb-160">
            <div class="col-md-5" data-aos="fade-up" data-aos-duration="2000">
                <h3 class="v-heading color-blue">Contact form</h3>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-md-7 v-form pr-40" data-aos="fade-up" data-aos-duration="2000">
                <form action="#" class="" method="POST">
                    <label for="salutation">Salutation</label>
                    <select id="salutation" name="salutation" class="form-select form-control form-control-lg">
                        <option id="salutation" class="selected-option" selected="">Please select</option>
                        <option value="1">Select1</option>
                        <option value="2">Select2</option>
                        <option value="3">Select3</option>
                    </select>
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" class="form-control" placeholder="Please enter">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" class="form-control" placeholder="Please enter">
                    <label for="email_address">Email</label>
                    <input type="text" id="email_address" class="form-control" placeholder="Please enter">
                    <label for="message">Message</label>
                    <textarea name="" id="message" cols="30" rows="10" class="form-control"
                              placeholder="Please enter"></textarea>
                    <button class="btn-submit language-location-submit btn v-btn-1 br-35 vf-600">
                        Send form
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!--text right-->
    <!--social media-->
    <div class="bg-blue-shade pt-150 pb-150"  >
        <div class="container-fluid">
            <div class="row pb-70">
                <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                    <h3 class="v-title color-blue vf-600">Contact options</h3>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-5"  data-aos="fade-up" data-aos-duration="2000">
                    <div class="social-cta">
                        <a href="#link">
                            <div>
                                <img src="assets/img/messenger.png" alt="Facebook Messenger" class="me-4">
                            </div>
                            <div>
                                Facebook
                                Messenger
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-5"  data-aos="fade-up" data-aos-duration="2000">
                    <div class="social-cta">
                        <a href="#link">
                            <div>
                                <img src="assets/img/whatsapp.png" alt="Facebook Messenger" class="me-4">
                            </div>
                            <div>
                                Whatsapp
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-5"  data-aos="fade-up" data-aos-duration="2000">
                    <div class="social-cta">
                        <a href="#link">
                            <div>
                                <img src="assets/img/messenger.png" alt="Facebook Messenger" class="me-4">
                            </div>
                            <div>
                                +41 41 557 22 22
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--social media-->
</div>
@endsection

@push('custom-scripts')
    
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-submit").click(function(e){

        e.preventDefault();

        var first_name = $('#first_name').val();
        var last_name = $("#last_name").val();
        var message = $("#message").val();
        var email = $("#email_address").val();
        var salutation = $("#salutation").val();
        var url = "{{ url('save-contact') }}";

        $.ajax({
           url:url,
           method:'POST',
           data: { 
                first_name:first_name, 
                last_name:last_name, 
                message:message, 
                email:email,
                salutation:salutation
            }, 
           success:function(response){
              if(response.success){
                    $('#first_name').val('');
                    $("#last_name").val('');
                    $("#message").val('');
                    $("#email_address").val('');
                    $("#salutation").val('');
                    alert(response.message) 
              }else{
                alert(response.message) 
              }
           },
           error:function(error){
              console.log(error)
           }
        });
	});
</script>
@endpush