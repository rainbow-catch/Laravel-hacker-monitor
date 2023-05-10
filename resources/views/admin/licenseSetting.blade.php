@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
@endsection
@section('content')
    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">
            <div class="panel-body">
                <div class="pl-sm">
                    <h1 style="color:#2B7EF8" ;><b>License Setting</b>
                        <text style="font-size: 20px" class="ml-md"></text>
                    </h1>
                    <br/>
                    <div class="col-md-6">
                        <div class="row mt-md">
                            <label class="col-md-4">License IP: </label>
                            <div class="col-md-8 text-left">
                                {{ $user->ip }}
                            </div>
                        </div>
                        <div class="row mt-md">
                            <label class="col-md-4">Date of Expiry: </label>
                            <div class="col-md-8 text-left">
                                {{ $user->enddate }}
                            </div>
                        </div>
                        <div class="row mt-md">
                            <label class="col-md-4">Remaining : </label>
                            <div class="col-md-8 text-left">
                                @if(date_diff(date_create(date("Y-m-d")), new DateTime($user->enddate))->format("%R%a") > 0)
                                    <span>
                                    {{ (new DateTime($user->enddate))->diff(new DateTime())->days + 1 }} days
                                </span>
                                @else
                                    <span style="color: red">expired</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-md">
                            <label class="col-md-4">Last login: </label>
                            <div class="col-md-8 text-left">
                                @if($user->LastLogin())
                                    {{ $user->LastLogin()->PC . " (" . $user->LastLogin()->IP . ")" }}
                                @else
                                    Never
                                @endif
                            </div>
                        </div>
                        <div class="row mt-md">
                            <label class="col-md-4">Your Email: </label>
                            <div class="col-md-8 text-left">
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mt-md">
                            <label class="col-md-4">Password: </label>
                            <div class="col-md-8 text-left">
                                <input class="form-control" id="input-password" value="{{ $user->password1 }}"
                                       minlength="6"/>
                                <div class="mt-md">
                                    <button class="btn btn-primary" id="btn-password-save">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-md">
                            <label class="col-md-4">Icon image URL: </label>
                            <div class="col-md-8 text-left">
                                <input class="form-control" id="input-avatar" value="{{ $user->avatar }}"/>
                                <div class="mt-md">
                                    <button class="btn btn-primary" id="btn-avatar-save">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <h2 style="color:#2B7EF8;"><b>Guests</b>
                        <text style="font-size: 20px" class="ml-md"></text>
                    </h2>

                    <div class="row mt-md">
                        <div class="col-sm-6">
                            <div class="mb-md">
                                <button id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped mb-none" id="datatable-editable" width="100%">
                        <thead>
                        <tr>
                            <th hidden>ID</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Roles</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $guests as $user )
                            <tr>
                                <td class="user_id" hidden>{{ $user->id }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->password1 }}</td>
                                <td class="roles">{{ implode("|", $user->GetRoleString()) }}</td>
                                <td class="actions">
                                    <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                    <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                    <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
        <div id="dialog" class="modal-block mfp-hide">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Are you sure?</h2>
                </header>
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <p>Are you sure that you want to delete this row?</p>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button id="dialogConfirm" class="btn btn-primary">Confirm</button>
                            <button id="dialogCancel" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('assets/javascripts/tables/guests.datatables.editable.js') }}?v=1"></script>
    <script>
        $(document).ready(function() {
            $('input').addClass('form-control');
            $('select').addClass('form-control');
        });

    </script>

    <script src="{{ asset('assets/vendor/ios7-switch/ios7-switch.js') }}"></script>
    <script type="text/javascript">

        (function ($) {
            'use strict';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function isUrl(s) {
                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                return regexp.test(s);
            }

            function init() {
                $("#btn-password-save").click(function () {
                    var newPassword = $("#input-password").val();
                    if (newPassword.length < 6) {
                        toastr.warning("Password length must be at least 6.");
                        return;
                    }
                    $.ajax({
                        url: '/admin/users/changePassword',
                        method: 'POST',
                        data: {
                            password: $("#input-password").val(),
                        },
                        success: function (res) {
                            toastr.success("Success")
                        },
                        error: function (err) {
                            console.log(err);
                            toastr.warning("Something failed");
                        }
                    });
                });
                $("#btn-avatar-save").click(function () {
                    var newAvatar = $("#input-avatar").val();
                    if (!isUrl(newAvatar)) {
                        toastr.warning("Avatar url is not valid");
                        return;
                    }
                    $.ajax({
                        url: '/admin/users/changeAvatar',
                        method: 'POST',
                        data: {
                            avatar: newAvatar,
                        },
                        success: function (res) {
                            toastr.success("Success")
                        },
                        error: function (err) {
                            console.log(err);
                            toastr.warning("Something failed");
                        }
                    });
                });
            }

            init();
        }).apply(this, [jQuery]);
    </script>
@endsection


