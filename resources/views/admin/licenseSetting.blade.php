@extends('layouts.app')

@section('content')
    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">
            <div class="panel-body">
                <div class="pl-sm col-md-6">
                        <h1 style="color:#2B7EF8" ;><b>License Setting</b>
                            <text style="font-size: 20px" class="ml-md"></text>
                        </h1>
                        <br/>
                        <div class="row mt-md">
                            <label class="col-md-4">License IP: </label>
                            <div class="col-md-8 text-left">
                                {{ $ip }}
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
                        <div class="row mt-md">
                            <label class="col-md-4">Password: </label>
                            <div class="col-md-8 text-left">
                                <input class="form-control" id="input-password" value="{{ $user->password1 }}" minlength="6"/>
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
                    </form>

                </div>

            </div>

        </section>

    </section>
@endsection

@section('script')
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
                $("#btn-password-save").click(function(){
                    var newPassword = $("#input-password").val();
                    if(newPassword.length < 6)
                    {
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
                $("#btn-avatar-save").click(function(){
                    var newAvatar = $("#input-avatar").val();
                    if(!isUrl(newAvatar))
                    {
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


