@extends('admin.layouts.main')
@section('title') {{ __('WEB SETTING') }} @endsection
@section('container')
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-8">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ __('MANAGE WEB SETTINGS') }}</h4>

                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Settings') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Web Setting') }}</li>
                        </ol>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            @if (Session::has('message'))
            <div class="col-sm-12">
                <div class="alert alert-{{ Session::get('type') }} alert-dismissible fade show" role="alert">
                    @if (Session::get('type') == 'danger') <i class="mdi mdi-block-helper me-2"></i> @else <i
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#contact" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">CONTACT INFORMATION</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#social" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">SOCIAL LINKS</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#logo" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">LOGO & FAVICON</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#smtp" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">SMTP SETTING</span>
                                </a>
                            </li>
                            
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="contact" role="tabpanel">
                                <div class="col-sm-12">
                                    <form class="needs-validation" method="POST" action="{{route('admin.contact.info.process')}}" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="row">
                                            <h3 class="card-title">Contact Information</h3>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" class="form-control" name="phone" id="phone"
                                                        placeholder="Phone No#" value="{{$contact->phone ?? ''}}">
                                                    <div class="invalid-feedback">
                                                        Please enter valid phone.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        placeholder="Email address" value="{{ $contact->email ?? ''}}" required>
                                                    <div class="invalid-feedback">
                                                        Please enter valid email address.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <textarea rows="4" class="form-control" name="address" id="address"
                                                        placeholder="Address here">{{$contact->address ?? ''}}</textarea>
                                                    <div class="invalid-feedback">
                                                        Please enter valid Address.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="social" role="tabpanel">
                                <div class="col-sm-12">
                                    <form class="needs-validation" method="POST" action="{{route('admin.web.social.link.process')}}" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="row">
                                            <h3 class="card-title">Social Links</h3>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="facebook" class="form-label">Facebook</label>
                                                    <input type="text" class="form-control" name="facebook" id="facebook"
                                                        placeholder="Facebook Link#" value="{{ $links->facebook ?? '' }}">
                                                    <div class="invalid-feedback">
                                                        Please enter valid facebook.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="facebook" class="form-label">Instagram</label>
                                                    <input type="text" class="form-control" name="instagram" id="instagram"
                                                        placeholder="Instagram Link#" value="{{ $links->instagram ?? '' }}">
                                                    <div class="invalid-feedback">
                                                        Please enter valid Instagram.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="twitter" class="form-label">Twitter</label>
                                                    <input type="text" class="form-control" name="twitter" id="twitter"
                                                        placeholder="Twitter Link#" value="{{ $links->twitter ?? '' }}" >
                                                    <div class="invalid-feedback">
                                                        Please enter valid Twitter.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="linkedin" class="form-label">LinkedIn</label>
                                                    <input type="text" class="form-control" name="linkedin" id="linkedin"
                                                        placeholder="LinkedIn Link#" value="{{ $links->linkedin ?? '' }}">
                                                    <div class="invalid-feedback">
                                                        Please enter valid linkedin link.
                                                    </div>
                                                </div>
                                            </div>
                                            {{--
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="google" class="form-label">Google</label>
                                                        <input type="text" class="form-control" name="google" id="google"
                                                            placeholder="Account Link#" value="{{ $links->google ?? '' }}">
                                                        <div class="invalid-feedback">
                                                            Please enter valid google account.
                                                        </div>
                                                    </div>
                                                </div>
                                            --}}
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="tiktok" class="form-label">Tiktok</label>
                                                    <input type="text" class="form-control" name="tiktok" id="tiktok"
                                                        placeholder="Tiktok Link#" value="{{ $links->tiktok ?? '' }}">
                                                    <div class="invalid-feedback">
                                                        Please enter valid Tiktok profile.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="logo" role="tabpanel">
                                <div class="col-sm-12">
                                    <form class="needs-validation" method="POST" action="{{route('admin.web.logos.process')}}" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="row">
                                            <h3 class="card-title">Logo & Favicon</h3>

                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="logo" class="form-label">Logo</label>
                                                    <input type="file" class="form-control" name="logo" id="logo" required>
                                                    <div class="invalid-feedback">
                                                        Please select valid logo.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                @if(isset($logo))
                                                    <img src="{{asset('backend/assets/images/websettings/'.$logo->logo)}}" class="rounded avatar-lg" alt="">
                                                @else
                                                    <img src="{{asset('backend/assets/images/no-image.jpg')}}" class="rounded avatar-lg" alt="">
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary" name="updateLogo" value="true" type="submit">UPDATE LOGO</button>
                                        </div>
                                    </form>
                                    <hr />
                                    <form class="needs-validation" method="POST" action="{{route('admin.web.logos.process')}}" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="favicon" class="form-label">Favicon</label>
                                                    <input type="file" class="form-control" name="favicon" id="favicon" required>
                                                    <div class="invalid-feedback">
                                                        Please select valid Favicon.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                @if(isset($favicon))
                                                    <img src="{{asset('backend/assets/images/websettings/'.$favicon->favicon)}}" class="rounded avatar-lg" alt="">
                                                @else
                                                    <img src="{{asset('backend/assets/images/no-image.jpg')}}" class="rounded avatar-lg" alt="">
                                                @endif
                                            </div>

                                        </div>
                                        <div>
                                            <button class="btn btn-primary" name="updateFavicon" value="true" type="submit">UPDATE FAVICON</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="smtp" role="tabpanel">
                                <div class="col-sm-12">
                                    <form class="needs-validation" method="POST" action="{{route('admin.web.stmpsetting.process')}}" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="row">
                                            <h3 class="card-title">SMTP Settings</h3>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="host" class="form-label">Mail Host</label>
                                                    <input type="text" class="form-control" name="host" id="host"
                                                        placeholder="Mail Host" value="{{$smtp->host ?? ''}}" required>
                                                    <div class="invalid-feedback">
                                                        Please enter valid mail host.
                                                    </div>
                                                    <label class="text-primary">eg. (smtp.zoho.com/smtp.gmail.com etc.)</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="port" class="form-label">Mail Port</label>
                                                    <input type="number" min="0" class="form-control" name="port" id="port"
                                                        placeholder="Mail Port" value="{{$smtp->port ?? ''}}" required>
                                                    <div class="invalid-feedback">
                                                        Please enter valid mail port.
                                                    </div>
                                                    <label class="text-primary">eg. (465 / 587)</label>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Mail Username</label>
                                                    <input type="text" class="form-control" name="username" id="username"
                                                        placeholder="Mail Username" value="{{$smtp->username ?? ''}}" required>
                                                    <div class="invalid-feedback">
                                                        Please enter valid mail username.
                                                    </div>
                                                    <label class="text-primary">eg. (account username / email of mail service provider)</label>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Mail Password</label>
                                                    <div class="input-group auth-pass-inputgroup">
                                                        <input type="password" class="form-control" placeholder="Mail password" aria-label="Password" aria-describedby="password-addon" id="password" name="password" value="@if(isset($smtp->password)){{ Crypt::decryptString($smtp->password) }}@endif" required/>
                                                        <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        Please enter valid mail password.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="encryption" class="form-label">Mail Encryption</label>
                                                    <input type="text" class="form-control" name="encryption" id="encryption"
                                                        placeholder="Mail Host" value="{{$smtp->encryption ?? ''}}" required />
                                                    <div class="invalid-feedback">
                                                        Please enter valid mail encryption.
                                                    </div>
                                                    <label class="text-primary">eg. (tls / ssl)</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="from_name" class="form-label">Mail From Name</label>
                                                    <input type="text" class="form-control" name="from_name" id="from_name"
                                                        placeholder="Mail From Name" value="{{$smtp->from_name ?? ''}}" required>
                                                    <div class="invalid-feedback">
                                                        Please enter valid mail from name.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary" type="submit">UPDATE SETTING</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div>
</div>
@endsection