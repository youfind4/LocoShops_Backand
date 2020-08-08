@extends('layouts.app')
@push('css_lib')
<!-- iCheck -->
<link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
<!-- select2 -->
<link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
{{--dropzone--}}
<link rel="stylesheet" href="{{asset('plugins/dropzone/bootstrap.min.css')}}">

<!-- VPN Added At :- 28/07/2020 -->
<style>
.switch-part {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch-part input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider-inner {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider-inner:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider-inner {
  background-color: #2196F3;
}

input:focus + .slider-inner {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider-inner:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider-inner.round {
  border-radius: 34px;
}

.slider-inner.round:before {
  border-radius: 50%;
}
</style>

<!-- End VPN Added At :- 28/07/2020 -->
@endpush
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{trans('lang.market_plural')}}<small class="ml-3 mr-3">|</small><small>{{trans('lang.market_desc')}}</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('lang.dashboard')}}</a></li>
          <li class="breadcrumb-item"><a href="{!! route('markets.index') !!}">{{trans('lang.market_plural')}}</a>
          </li>
          <li class="breadcrumb-item active">{{trans('lang.market_create')}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
  <div class="clearfix"></div>
  @include('flash::message')
  @include('adminlte-templates::common.errors')
  <div class="clearfix"></div>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        @can('markets.index')
        <li class="nav-item">
          <a class="nav-link" href="{!! route('markets.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.market_table')}}</a>
        </li>
        @endcan
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.market_create')}}</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      {!! Form::open(['route' => 'markets.store']) !!}
      <div class="row">
        @include('markets.fields')
      </div>
      {!! Form::close() !!}
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@include('layouts.media_modal')
@endsection
@push('scripts_lib')
<!-- iCheck -->
<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
<!-- select2 -->
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
{{--dropzone--}}
<script src="{{asset('plugins/dropzone/dropzone.js')}}"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    var dropzoneFields = [];
</script>

<!--  VPN Changes At :- 28/07/2020 -->
<script>
  google_pay();
  function google_pay() {
    var checkBox = document.getElementById("google_pay_token");
    var text = document.getElementById("googlepay_token_div");
    if (checkBox.checked == true)
    {
      text.style.display = "flex";
    } else 
    {
       text.style.display = "none";
      document.getElementById("google_token_key").value  = '';
    }
  }
  paytm();
  function paytm() {
  var checkBox = document.getElementById("paytm_token");
  var text = document.getElementById("paytm_token_div");
  if (checkBox.checked == true){
    text.style.display = "flex";
  } else {
     text.style.display = "none";
     document.getElementById("paytm_token_key").value  = '';
  }
}
</script>
<!-- End VPN Changes At :- 28/07/2020 -->
@endpush