@extends('admin.layouts.main')
@section('title') {{ __('All Users') }} @endsection
@section('container')


<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ __('Edit & Update USER') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('USER') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Edit & Update USER') }}</li>
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
            <form class="needs-validation" method="POST" action="{{route('admin.update.user.process')}}"
                enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="id" value="{{$user->id}}" />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Name here" value="{{$user->name ?? ''}}"
                                                required>
                                            <div class="invalid-feedback">
                                                Please enter valid Name.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="full_name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="full_name" id="full_name"
                                                placeholder="full name here" value="{{$user->full_name ?? ''}}"
                                                required>
                                            <div class="invalid-feedback">
                                                Please enter valid Full name.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Email here" value="{{$user->email ?? ''}}"
                                                required disabled>
                                            <div class="invalid-feedback">
                                                Please enter valid Email.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password here" value="{{$user->password ?? ''}}"
                                                required>
                                            <div class="invalid-feedback">
                                                Please enter valid password.
                                            </div>
                                        </div>
                                    </div>
                                  
                                    
                                 
                                   
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select select2" id="" name="status" required>
                                                <option selected disabled value="">Select Status</option>
                                                <option @if($user->status == "1") {{ 'selected' }} @endif
                                                    value="1">active</option>
                                                <option @if($user->status == "0") {{ 'selected' }} @endif
                                                    value="0">inactive</option>
                                               
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                   
                   
                    <div class="col-sm-12">
                        <button class="btn btn-primary" type="submit">UPDATE USER</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div>
</div>
@endsection

@section('extra-scripts')
<script src="{{asset('assets/backend/libs/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('assets/backend/js/pages/form-validation.init.js')}}"></script>
@endsection