@extends('layouts.app')

@section('content')

    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">

            <div class="panel-body">
                <div class="pl-sm">
                    <h2>Logs</h2>
                    <form id="search-form">
                        <div class="row mt-md m-none">
                            <div class="col-md-6 row">
                                <label class="text-weight-bold col-md-3 mt-xs">From:</label>
                                <div class="input-group col-md-9">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                    <input type="text" data-plugin-datepicker="" class="form-control datepicker"
                                           name="date-start" value="{{$request['date-start']}}"/>
                                    <span class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                    <input type="text" data-plugin-timepicker=""
                                           data-plugin-options='{"showMeridian":false}' class="form-control"
                                           name="time-start" value="{{$request['time-start']}}"/>
                                </div>
                            </div>
                            <div class="col-md-6 row">
                                <label class="text-weight-bold col-md-3 mt-xs">To:</label>
                                <div class="input-group col-md-9">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                    <input type="text" data-plugin-datepicker="" class="form-control datepicker"
                                           name="date-end" value="{{$request['date-end']}}"/>
                                    <span class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                    <input type="text" data-plugin-timepicker=""
                                           data-plugin-options='{"showMeridian":false}' class="form-control"
                                           name="time-end" value="{{$request['time-end']}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row m-none">
                            <div class="col-md-6 row mt-md">
                                <label class="text-weight-bold col-md-3 mt-xs">Search:</label>
                                <div class="col-md-9 p-none">
                                    <input type="text" class="form-control" placeholder="Search..." name="search"
                                           value="{{$request['search']}}"/>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md">
                                <button class="btn btn-default">Search</button>
                                <button class="btn btn-primary ml-md btn-prev">Prev</button>
                                <button class="btn btn-primary ml-sm btn-next">Next</button>
                            </div>
                        </div>
                    </form>
                    <div class="row m-none">
                        <div class="col-md-2 logs p-none logbox-container mt-md">
                            @foreach($files as $file)
                                <div class="log text-md p-sm">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-file"></i>
                                    </span>
                                    <div>
                                        <a class="text-weight-bold ml-xs btn-logfile {{ $curfile == $file['name'] ? "text-danger current-log" : ""}}"
                                           href="#"
                                           data-file="{{$file['name']}}">
                                            {{ $file['name'] }}
                                        </a>
                                        <span class="text-sm">
                                            {{ DateTime::createFromFormat('YmdHis', $file['modify'])->format('Y-m-d H:i:s') }}
                                        </span>
                                    </div>
                                    @if(Auth::user()->approve > 1)
                                        <a class="ml-auto mr-xs float-right btn-delete-logfile"
                                           data-file="{{$file['name']}}">
                                            <span class="icon icon-lg">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-7 logbox-container mt-md">
                            <div class="logbox">
                                @if(count($contents) == 0)
                                    Log Content
                                @else
                                    @foreach($contents as $content)
                                        <span class="log-section">Local Time:</span>
                                        <span class="log-text">{{ $content['time'] }}</span> <br/>
                                        <span class="log-section text-danger">Hack Detect:</span>
                                        <span class="log-text">{{ $content['detect'] }}</span> <br/>
                                        <span class="log-section text-success">Full Path:</span>
                                        <span class="log-text">{{ $content['path'] }}</span> <br/>
                                        <span class="log-section text-warning">HardwareID:</span>
                                        <span class="log-text">{{ $content['hardware'] }}</span>
                                        @if(Auth::user()->CanSee('ban_hardware'))
                                            @if(!$content['isbanned'])
                                                <button class="btn btn-default btn-xs ml-md btn-ban"
                                                        data-hardware="{{$content['hardware']}}">
                                                    Ban
                                                </button>
                                            @else
                                                <button class="btn btn-default btn-xs ml-md btn-un-ban"
                                                        data-hardware="{{$content['hardware']}}">
                                                    Un-Ban
                                                </button>
                                            @endif
                                        @endif
                                        <br/>
                                        <span class="log-section text-warning text-warning">HardwareID v2:</span>
                                        <span class="log-text">{{ $content['hardwarev2'] }}</span>
                                        @if(Auth::user()->CanSee('ban_hardware'))
                                            @if(!$content['isbanned2'])
                                                <button class="btn btn-default btn-xs ml-md btn-ban"
                                                        data-hardware="{{$content['hardwarev2']}}">
                                                    Ban
                                                </button>
                                            @else
                                                <button class="btn btn-default btn-xs ml-md btn-un-ban"
                                                        data-hardware="{{$content['hardwarev2']}}">
                                                    Un-Ban
                                                </button>
                                            @endif
                                        @endif
                                        <br/>
                                        <span class="log-section text-primary">Account:</span>
                                        <span class="log-text">{{ $content['account'] }}</span> <br/>
                                        <span class="log-section text-info">Character:</span>
                                        <span class="log-text">{{ $content['character'] }}</span> <br/>
                                        --------------------------------------------------- <br/>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 pt-sm bannedlist mt-md">
                            <span class="text-weight-bold text-md">Banned List</span>
                            <br/>
                            @foreach($banlist as $ban)
                                <div class="banitem">
                                    <span>{{$ban}}</span>
                                    @if(Auth::user()->CanSee('ban_hardware'))
                                        <a class="btn-delete-ban mr-xs float-right " data-hardware="{{ $ban }}">
                                            <span class="icon icon-lg">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                            @if(Auth::user()->CanSee('ban_hardware'))
                                <div class="d-flex mt-sm">
                                    <label>Mac</label>
                                    <div class="mb-xs">
                                        <input type="text" class="form-control form-control-sm" id="input-add-mac"/>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary btn-sm" id="btn-add-mac"> Add Mac</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <div id="confirm-dialog" class="modal-block mfp-hide">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Warning!</h2>
                </header>
                <div class="panel-body">
                    <p>Are you sure that you want to delete this <span id="del-logfile-name"
                                                                       class="text-danger text-weight-bold"></span>?</p>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-default btn-primary dialog-ok">Confirm</button>
                            <button class="btn btn-default dialog-cancel" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>
        <!-- end: page -->
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        (function ($) {
            'use strict';

            var delLogFile;

            function init() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //$("input[value=''].datepicker").datepicker("setDate", new Date())
                if ($(".current-log").length)
                    $(".logs")[0].scrollTop = ($(".current-log")[0].offsetTop - 80);

            }

            function onResponse(resp) {
                if (resp == 'success') {
                    window.history.go();
                } else {
                    hideLoading();
                    toastr.warning("failed");
                }
            }

            function initEvents() {
                $("#btn-add-mac").click(function () {
                    var hardware = $('#input-add-mac').val();
                    hardware = hardware.trim();

                    if (hardware.length <= 0) {
                        toastr.warning("The mac cannot be empty");
                        return;
                    }
                    showLoading();
                    $.ajax({
                        url: '/ban/add',
                        method: 'POST',
                        data: {
                            hardware: hardware,
                        },
                        success: onResponse
                    });
                });

                $(".btn-ban").click(function () {
                    var hardware = $(this).data('hardware');

                    showLoading();
                    $.ajax({
                        url: '/ban/add',
                        method: 'POST',
                        data: {
                            hardware: hardware,
                        },
                        success: onResponse
                    });
                });


                $(".btn-un-ban").click(function () {
                    var hardware = $(this).data('hardware');

                    showLoading();
                    $.ajax({
                        url: '/ban/delete',
                        method: 'POST',
                        data: {
                            hardware: hardware,
                        },
                        success: onResponse
                    });
                });

                $(".btn-delete-ban").click(function () {
                    var hardware = $(this).data('hardware');
                    showLoading();
                    $.ajax({
                        url: '/ban/delete',
                        method: 'POST',
                        data: {
                            hardware: hardware,
                        },
                        success: onResponse
                    });
                });

                $("#confirm-dialog .dialog-ok").click(function () {
                    showLoading();
                    $.ajax({
                        url: '/log/delete',
                        method: 'POST',
                        data: {
                            logfile: delLogFile,
                        },
                        success: onResponse,
                        error: function () {
                            hideLoading();
                            toastr.warning("failed");
                        }
                    });
                });


                $(".btn-delete-logfile").click(function () {
                    delLogFile = $(this).data('file');
                    $("#del-logfile-name").text(delLogFile);

                    $.magnificPopup.open({
                        items: {
                            src: '#confirm-dialog',
                            type: 'inline'
                        },
                        preloader: false,
                        modal: true,
                    });
                });

                $(".dialog-cancel").click(function () {
                    $.magnificPopup.close();
                });

                $(".btn-logfile").click(function () {
                    const formData = new FormData($("#search-form")[0]);
                    const params = new URLSearchParams(formData);
                    const file = $(this).data('file');
                    window.location.href = "/log/" + file + "?" + params;
                });

                $(".btn-prev").click(function (e) {
                    e.preventDefault();
                    var next = $('.current-log').closest('.log').prev('.log');
                    next.find('.btn-logfile').click();
                    return false;
                });

                $(".btn-next").click(function (e) {
                    e.preventDefault();
                    var next = $('.current-log').closest('.log').next('.log');
                    next.find('.btn-logfile').click();
                    return false;
                });
            }

            init();
            initEvents();
        }).apply(this, [jQuery]);
    </script>
@endsection