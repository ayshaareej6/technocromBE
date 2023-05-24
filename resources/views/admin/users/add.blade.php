@extends('admin.layouts.main')
@section('title') {{ __('All User') }} @endsection
@section('container')


<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ __('Add New USER') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('USER') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Add USER') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            @if(Session::has('message'))
            <div class="col-sm-12">
                <div class="alert alert-{{Session::get('type')}} alert-dismissible fade show" role="alert">
                    @if(Session::get('type') == 'danger') <i class="mdi mdi-block-helper me-2"></i> @else <i
                        class="mdi mdi-check-all me-2"></i> @endif
                    {{ __(Session::get('message')) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            @if ($errors->any())
            <div class="col-sm-12">
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-block-helper me-2"></i>
                    {{ __($error) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endforeach
            </div>
            @endif
            <div class="col-sm-12 message"></div>
            <div class="col-sm-12 mb-2">
            <a href="{{ route('admin.view.user') }}" class="btn btn-sm btn-primary">ALL USER</a> 
                <a href="{{ route('admin.add.user') }}"class="btn btn-sm btn-success">ADD NEW USER</a>
                <a href="{{ route('admin.trash.user') }}"class="btn btn-sm btn-danger">TRASH</a>
            </div>
            <form class="needs-validation" method="POST" action="{{route('admin.add.user.process')}}"
                enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Name here" value="{{old('name')}}" required>
                                            <div class="invalid-feedback">
                                                Please enter valid name.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="full_name" class="form-label">Full Name*</label>
                                            <input type="text" class="form-control" name="full_name" id="full_name"
                                                placeholder="Full name here" value="{{old('full_name')}}" required>
                                            <div class="invalid-feedback">
                                                Please enter valid Full name.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Email here" value="{{old('email')}}" required>
                                            <div class="invalid-feedback">
                                                Please enter valid Email.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password here" value="{{old('password')}}" required>
                                            <div class="invalid-feedback">
                                                Please enter valid Password.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                                placeholder="Confirm password here" value="{{old('confirm_password')}}" required>
                                            <div class="invalid-feedback">
                                                Please enter valid Confirm password.
                                            </div>
                                        </div>
                                    </div>
                                    

                                    
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                    
                   
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">ADD USER</button>
                    </div> 
                </div>
            </form>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div>
</div>

@endsection

@section('customScripts')
<script src="{{asset('assets/backend/libs/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('assets/backend/js/pages/form-validation.init.js')}}"></script>
@endsection