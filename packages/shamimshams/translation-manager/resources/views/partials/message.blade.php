@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><i class="fa fa-check-circle"></i></strong> {{ session('success') }}
    <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="fa fa-exclamation-triangle"></i></strong> {{ session('success') }}
    <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif