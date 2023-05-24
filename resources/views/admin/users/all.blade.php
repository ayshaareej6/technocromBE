@extends('admin.layouts.main')
@section('title') {{ __('All users') }} @endsection
@push('customStyles')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<style>
    .avatar-sm {
        width: auto !important;
    }
</style>
@endpush
@section('container')


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ __('All users') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('USER') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('All users') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                @if (Session::has('message'))
                <div class="col-sm-12">
                    <div class="alert alert-{{ Session::get('type') }} alert-dismissible fade show" role="alert">
                        @if (Session::get('type') == 'danger') <i class="mdi mdi-block-helper me-2"></i> @else <i class="mdi mdi-check-all me-2"></i> @endif
                        {{ __(Session::get('message')) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif
                <div class="col-sm-12 message"></div>
                <div class="col-sm-12 mb-2">
                    <a href="{{ route('admin.view.user') }}" class="btn btn-sm btn-primary">ALL USER</a>
                    <a href="{{ route('admin.add.user') }}" class="btn btn-sm btn-success">ADD NEW USER</a>
                    <a href="{{ route('admin.trash.user') }}" class="btn btn-sm btn-danger">TRASH</a>

                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered data-table wrap">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th width="10%">Full Name</th>
                                        <th width="10%">Name</th>
                                        <th width="10%">Email</th>
                                        <th width="15%">Email_verified_at</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Status</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
</div>

@endsection

@push('customScripts')

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function() {
        var table = $('.data-table').DataTable({

            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: "{{route('admin.view.user')}}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'email_verified_at',
                    name: 'email_verified_at'
                },
                // {data: 'password', name: 'password'},
                // {data: 'remember_token', name: 'remember_token'},
                // {data: 'created_by_name', name: 'created_by_name'},
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                // {data: 'updated_by_name', name: 'updated_by_name'},
                {
                    data: 'updated_at',
                    name: 'created_at'
                },

                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            responsive: true,
            'createdRow': function(row, data, dataIndex) {
                $(row).attr('id', data.id);
            },
            "order": [
                [0, "desc"]
            ],
            "bDestroy": true,
        });
    });

    $(document).on('click', '.user_status', function() {
        var id = $(this).attr('data-id');
        var status = $(this).val();
        $.ajax({
            type: 'POST',
            url: "{{route('admin.updatestatus.user')}}",
            data: {
                id: id,
                status: status
            },
            success: function(data) {

                var result = JSON.parse(data);
                var type = result.type;

                if (status == "0") {
                    $('.user_status#switch' + id).attr('value', '1');
                } else {
                    $('.user_status#switch' + id).attr('value', '0');
                }
                $('.message').html('<div class="alert alert-' + result.type +
                    ' alert-dismissible fade show" role="alert"><i class="mdi ' + result.icon +
                    ' me-2"></i>' + result.message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>'
                );
            }
        });

    });

    $(document).on("click", ".remove", function(event) {
        var flag = confirm('Are You Sure want to Remove User?');
        if (flag) {
            var id = $(this).data('id');
            $.ajax({
                url: "{{route('admin.delete.user')}}",
                type: 'POST',
                data: {
                    id: id
                },
                success: function(data) {
                    let result = JSON.parse(data);
                    $('.message').html('<div class="alert alert-' + result.type +
                        ' alert-dismissible fade show" role="alert"><i class="mdi ' + result.icon +
                        ' me-2"></i>' + result.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>'
                    );

                    let table = $('.data-table').DataTable();
                    table.row('#' + id).remove().draw(false);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        } else {
            event.preventDefault();
        }
    });
</script>
@endpush