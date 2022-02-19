@extends('layout')

@section('page_title', 'User CRUD')

@section('header_styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="{!! asset('css/datatables.min.css') !!}" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{!! asset('css/toastr.min.css') !!}" />

    <style>
        .form-group .error {
            color: #ff0234;
        }

        img {
            max-width: 100%;
        }
        img.user-image-td {
            height: 100px;
            width: 100px;
            object-fit: cover;
            object-position: center center;
        }

        #img-preview,
        #img-view-preview {
            margin-bottom: 5px;
        }
        #img-preview img,
        #img-view-preview img {
            height: 120px;
            width: 120px;
            object-fit: cover;
            object-position: center center;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-md-12 text-right">
                <button id="btnAddUser" type="button" class="btn btn-primary btn-add-edit">@lang('users.add')</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="tableUsers" class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{!! trans('users.name') !!}</th>
                            <th>{!! trans('users.email') !!}</th>
                            <th>{!! trans('users.phone') !!}</th>
                            <th>{!! trans('users.gender') !!}</th>
                            <th>{!! trans('users.image') !!}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-user" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userModalTitle">@lang('users.add') @lang('users.user')</h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="{!! route('users.store') !!}" class="form-horizontal" id="frmUser" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="user_id" value="" />
                    <div class="modal-body">
                        <div class="row form-group">
                            <label for="name" class="col-md-2 col-form-label">@lang('users.name')</label>
                            <div class="col-md-10">
                                <input type="text" name="name" id="name" class="form-control" placeholder="@lang('users.name')" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="email" class="col-md-2 col-form-label">@lang('users.email')</label>
                            <div class="col-md-10">
                                <input type="text" name="email" id="email" class="form-control" placeholder="@lang('users.email')" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="phone" class="col-md-2 col-form-label">@lang('users.phone')</label>
                            <div class="col-md-10">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="@lang('users.phone')" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="gender" class="col-md-2 col-form-label">@lang('users.gender')</label>
                            <div class="col-md-10">
                                <div class="form-check form-check-inline col-md-2">
                                    <input type="radio" name="gender" id="gender_m" class="form-check-input" value="male" checked />
                                    <label class="form-check-label" for="gender_m">@lang('users.genders.m')</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2">
                                    <input type="radio" name="gender" id="gender_f" class="form-check-input" value="female" />
                                    <label class="form-check-label" for="gender_f">@lang('users.genders.f')</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2">
                                    <input type="radio" name="gender" id="gender_o" class="form-check-input" value="other" />
                                    <label class="form-check-label" for="gender_o">@lang('users.genders.o')</label>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="image" class="col-md-2 col-form-label">@lang('users.image')</label>
                            <div class="col-md-10">
                                <div id="img-preview" class="d-none"><img alt="" src="" class="user-image-preview" /></div>
                                <input type="file" name="image" id="image" class="form-control" placeholder="@lang('users.image')" accept="image/*" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-warning">@lang('users.close')</button>
                        <button class="btn btn-success" type="submit">@lang('users.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-userInfo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userViewModalTitle">@lang('users.view') @lang('users.user')</h4>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="viewUser">
                    <div class="row form-group">
                        <label for="name" class="col-md-2 col-form-label">@lang('users.name')</label>
                        <div class="col-md-10">
                            <input type="text" name="name" id="view_name" class="form-control" placeholder="@lang('users.name')" readonly />
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="email" class="col-md-2 col-form-label">@lang('users.email')</label>
                        <div class="col-md-10">
                            <input type="text" name="email" id="view_email" class="form-control" placeholder="@lang('users.email')" readonly />
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="phone" class="col-md-2 col-form-label">@lang('users.phone')</label>
                        <div class="col-md-10">
                            <input type="text" name="phone" id="view_phone" class="form-control" placeholder="@lang('users.phone')" readonly />
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="gender" class="col-md-2 col-form-label">@lang('users.gender')</label>
                        <div class="col-md-10">
                            <div class="form-check form-check-inline col-md-2">
                                <input type="radio" name="gender" id="view_gender_m" class="form-check-input" value="male" checked disabled />
                                <label class="form-check-label" for="view_gender_m">@lang('users.genders.m')</label>
                            </div>
                            <div class="form-check form-check-inline col-md-2">
                                <input type="radio" name="gender" id="view_gender_f" class="form-check-input" value="female" disabled />
                                <label class="form-check-label" for="view_gender_f">@lang('users.genders.f')</label>
                            </div>
                            <div class="form-check form-check-inline col-md-2">
                                <input type="radio" name="gender" id="view_gender_o" class="form-check-input" value="other" disabled />
                                <label class="form-check-label" for="view_gender_o">@lang('users.genders.o')</label>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="image" class="col-md-2 col-form-label">@lang('users.image')</label>
                        <div class="col-md-10">
                            <div id="img-view-preview" class="d-none"><img alt="" src="" class="user-image-preview" /></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">@lang('users.close')</button>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{!! asset('js/jquery.validate.js') !!}"></script>
    <script src="{!! asset('js/toastr.min.js') !!}"></script>
    <script src="{!! asset('js/datatables.min.js') !!}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.all.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
            }
        });

        toastr.options = {
            "debug": false,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000
        };

        $dataTable = $('#tableUsers').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                method: 'POST',
                url: '{!! route('users.browse') !!}',
            },
            order: [
                [0, 'ASC']
            ],
            columns: [
                {data: 'id', name: 'id', searchable: false, orderable: false},
                {data: 'name', name: 'name', searchable: true, orderable: true},
                {data: 'email', name: 'email', searchable: true, orderable: true},
                {data: 'phone', name: 'phone', searchable: false, orderable: true},
                {data: 'gender', name: 'gender', searchable: true, orderable: true},
                {data: 'image', name: 'image', searchable: false, orderable: false},
                {data: 'action', name: 'action', searchable: false, orderable: false, className: 'text-right'},
            ]
        });

        $(document).on('click', '.btn-add-edit', function() {
            $('#frmUser')[0].reset();
            $('#frmUser').find('label.error').remove();
            $('#frmUser').find('input[name="gender"][value="m"]').prop('checked', true);

            $("#img-preview").addClass('d-none');
            $('#img-preview .user-image-preview').attr('src', '');

            $userID = $(this).attr('data-user');
            $('#user_id').val($userID);

            $('#userModalTitle').html('@lang('users.add') @lang('users.user')');

            if ($userID != undefined) {
                $infoURL = $(this).attr('data-info');

                $('#userModalTitle').html('@lang('users.edit') @lang('users.user')');
                $.ajax({
                    type: 'POST',
                    url: $infoURL,
                    success: function(response) {
                        $('#frmUser').find('input[name="name"]').val(response.data.name);
                        $('#frmUser').find('input[name="email"]').val(response.data.email);
                        $('#frmUser').find('input[name="phone"]').val(response.data.phone);
                        $('#frmUser').find('input[name="gender"][value="'+response.data.gender+'"]').prop('checked', true);

                        if (response.data.image != null) {
                            var imgURL = '{!! url('uploads/users') !!}/'+response.data.image;
                            $('#img-preview .user-image-preview').attr('src', imgURL);
                            $('#img-preview').removeClass('d-none');
                        } else {
                            $('#img-preview .user-image-preview').attr('src', '');
                            $('#img-preview').addClass('d-none');
                        }
                    }
                });
            }

            $('#modal-user').modal('show');
        });

        $(document).on('click', '.btn-info', function(){
            $userID = $(this).attr('data-user');

            $infoURL = $(this).attr('data-info');

            $('#userModalTitle').html('@lang('users.edit') @lang('users.user')');
            $.ajax({
                type: 'POST',
                url: $infoURL,
                success: function(response) {
                    $('#viewUser').find('input[name="name"]').val(response.data.name);
                    $('#viewUser').find('input[name="email"]').val(response.data.email);
                    $('#viewUser').find('input[name="phone"]').val(response.data.phone);
                    $('#viewUser').find('input[name="gender"][value="'+response.data.gender+'"]').prop('checked', true);

                    if (response.data.image != null) {
                        var imgURL = '{!! url('uploads/users') !!}/'+response.data.image;
                        $('#img-view-preview .user-image-preview').attr('src', imgURL);
                        $('#img-view-preview').removeClass('d-none');
                        $('#img-view-preview').parent().parent().removeClass('d-none');
                    } else {
                        $('#img-view-preview .user-image-preview').attr('src', '');
                        $('#img-view-preview').addClass('d-none');
                        $('#img-view-preview').parent().parent().addClass('d-none');
                    }

                    $('#modal-userInfo').modal('show');
                }
            });
        });

        $(document).on('click', '.btn-delete', function(){
            var id = $(this).attr('data-user');

            Swal.fire({
                title: '@lang('users.you_sure')',
                html: '@lang('users.delete_confirm')',
                confirmButtonText: '@lang('users.yes')',
                denyButtonText: '@lang('users.no')',
                showDenyButton: true,
                showCancelButton: false,
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{!! route('users.destroy') !!}',
                        data: {
                            id: id,
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('@lang('users.delete_success')');
                                setTimeout(function(){
                                    $dataTable.ajax.reload();
                                }, 500);
                            } else {
                                var errors = "<ul>";
                                $.each(response.messages, function(k, v) {
                                    errors += "<li>" + v + "</li>";
                                    console.log(k, v);
                                });
                                errors += "<ul>";

                                toastr.error(errors);
                            }
                        }
                    });
                }
            });
        });

        $('#frmUser').validate({
            rules: {
                name:{
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true,
                },
                gender: {
                    required: true,
                },
            },

            submitHandler: function(form) {
                var formData = new FormData($('#frmUser')[0]);
                $.ajax({
                    contentType: false,
                    processData: false,
                    cache: false,
                    type: 'POST',
                    url: $('#frmUser').attr('action'),
                    // data: $('#frmUser').serialize(),
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('@lang('users.save_success')');
                            setTimeout(function(){
                                $('#modal-user').modal('hide');
                                $dataTable.ajax.reload();
                            }, 1000);
                        } else {
                            var errors = "<ul>";
                            $.each(response.messages, function(k, v) {
                                errors += "<li>" + v + "</li>";
                                console.log(k, v);
                            });
                            errors += "<ul>";

                            toastr.error(errors);
                        }
                    }
                });
            }
        });
    </script>
@endsection
