@extends('layouts.app')

@section('content')
    <style>
        .main-table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .main-table td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .main-table tr:nth-child(even) {
            background-color: #CBFEDE;
        }
    </style>
    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">

            <div class="panel-body">
                <div class="pl-sm">
                    <h3>Version information and change logs</h3>

                    <div>
                        <label onclick="myFunction()" style="float: right;">
                            <img src="assets/images/ver.png" width="30"/>
                            View Logs
                        </label>
                    </div>

                    <table class="main-table">
                        <tr>
                            <th>File</th>
                            <th>Context</th>
                            <th>Download</th>
                            <th>Update date</th>
                            @if(Auth::user()->approve == 3)
                                <th>Edit</th>
                            @endif
                        </tr>


                        @foreach($files as $file)
                            <tr file-id="{{ $file['id'] }}">
                                <td class="label-name">{{ $file['name'] }}</td>
                                <td class="label-description">{{ $file['description'] }}</td>
                                <td>
                                    <a href="{{ $file['path'] }}" target="_blank" class="btn-download">
                                        <img src="assets/images/down.png" width="30"/>
                                    </a>
                                </td>
                                <td class="label-update-date" style="color:#FF0000">{{ $file['update_date'] }}</td>
                                @if(Auth::user()->approve == 3)
                                    <td>
                                        <a href="#" style="font-size: 20px;" class="btn-edit">
                                            <i class="fa fa-edit" style="vertical-align: middle;"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>

                    <div id="myDIV" style="display: none;"><p>
                        <h4>
                            Change logs
                            @if(Auth::user()->approve == 3)
                            <a href="#" class="log-add" style="padding-left:30px; font-size:12px;">
                                Add a log
                            </a>
                                @endif
                        </h4>


                        @if(count($logs)==0)
                            <span id="no-log">No logs.</span>
                            <ul></ul>
                        @else
                        <ul>
                            @foreach($logs as $log)
                                <li log-id = "{{ $log['id'] }}" >
                                    <div class="log-control" style="display: flex">
                                        <span>{{ $log['log'] }}</span>
                                        @if(Auth::user()->approve == 3)
                                        <a href="#" style="margin-left: 10px; font-size: 12px;" class="log-edit">edit</a>
                                        <a href="#" style="margin-left: 5px; font-size: 12px;" class="log-delete">delete</a>
                                            @endif
                                    </div>
                                </li>
                            @endforeach
                                {{--<li>Fix crash (Cheat Engine)<b> &nbsp;</b><br/></li>--}}
                                {{--<li>Fix Auto Ban (We need more test)<b> &nbsp;</b><br/></li>--}}
                                {{--<li>Fix Valkyria last version <b> &nbsp;</b><br/></li>--}}
                                {{--<li>Add high level protection (Packer)<b> &nbsp;</b><br/></li>--}}
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </section>

    {{--log create/edit dialog--}}
    <div id="log-dialog" class="modal-block mfp-hide">
        <section class="panel">
            <header class="panel-heading">
                {{--Add log or Edit log--}}
                <h2 class="panel-title"></h2>
            </header>
            <div class="panel-body">
                <input id="log-id" type="hidden"/>
                <div class="row">
                    <label class="col-md-3">Log detail</label>
                    <div class="col-md-9">
                        <textarea type="text" class="form-control" id="log-detail"></textarea>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-default btn-primary log-dialog-ok">Save</button>
                        <button class="btn btn-default log-dialog-cancel" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>

{{--DownloadFile edit dialog--}}
    <div id="file-dialog" class="modal-block mfp-hide">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Download File Details</h2>
            </header>
            <div class="panel-body">
                <input id="file-id" type="hidden"/>
                <div class="row">
                    <label class="col-md-3">Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="file-name"/>
                    </div>
                </div>
                <div class="row mt-sm">
                    <label class="col-md-3">Path</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="file-path"/>
                    </div>
                </div>
                <div class="row mt-sm">
                    <label class="col-md-3">Update Date</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control datepicker" id="file-update-date"/>
                    </div>
                </div>
                <div class="row mt-sm">
                    <label class="col-md-12">Description</label>
                    <div class="col-md-12">
                        <textarea class="form-control" id="file-description"></textarea>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-default btn-primary dialog-ok">Save</button>
                        <button class="btn btn-default dialog-cancel" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
    </section>




@endsection

@section('script')
    <script type="text/javascript">
        function myFunction() {
            var x = document.getElementById("myDIV");
            if (x.style.display == "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

        (function ($) {
            'use strict';
            $('#file-update-date').datepicker({format: 'yyyy-mm-dd'});

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Ajax for CRUD log
            function init() {
                $('.log-edit').click(function () {
                    var li = $(this).closest('li');
                    $('#log-dialog .panel-title').html('Edit log');
                    $('#log-id').val($(li).attr('log-id'));
                    $('#log-detail').val($(li).find('div span').html());
                    $.magnificPopup.open({
                        items: {
                            src: '#log-dialog',
                            type: 'inline'
                        },
                        preloader: false,
                        modal: true,
                    });
                });
                $(".log-delete").click(function() {
                    var li = $(this).closest('li');
                    var logId = $(li).attr('log-id');

                    if(confirm("Are you sure you want to delete this log?")){
                        $.ajax({
                            url: '/downloads/logs/delete/' + logId,
                            method: 'DELETE',
                            success: function (res) {
                                var field = $('li[log-id=' + logId + ']');
                                $(field).remove();
                                if($('#myDIV ul li').length == 0)
                                    $('#no-log').show();
                                $.magnificPopup.close();
                                toastr.success("Success")
                            },
                            error: function (err) {
                                console.log(err);
                                toastr.warning("Something failed");
                            }
                        });
                    }
                });
            }
            init();
            $('.log-add').click(function () {
                $('#log-dialog .panel-title').html('Add log');
                $('#log-id').val("");
                $('#log-detail').val("");
                $.magnificPopup.open({
                    items: {
                        src: '#log-dialog',
                        type: 'inline'
                    },
                    preloader: false,
                    modal: true,
                });
            });

            $('.log-dialog-ok').click(function () {
                var logId = $('#log-id').val();
                var logDetail = $('#log-detail').val();
                $.ajax({
                    url: '/downloads/logs/save/' + logId,
                    method: 'POST',
                    data: {
                        log: logDetail
                    },
                    success: function (res) {
                        if(logId!=""){
                            var field = $('li[log-id=' + logId + ']');
                            $(field).find('span').html(logDetail);
                        }
                        else {
                            var code = '<li log-id = "' + res.id + '" >\n' +
                                '                                    <div class="log-control" style="display: flex">\n' +
                                '                                        <span>' + res.log + '</span>\n' +
                                '                                        <a href="#" style="margin-left: 10px; font-size: 12px;" class="log-edit">edit</a>\n' +
                                '                                        <a href="#" style="margin-left: 5px; font-size: 12px;" class="log-delete">delete</a>\n' +
                                '                                    </div>\n' +
                                '                                </li>';
                            $('#myDIV ul').append(code);
                            $('#no-log').hide();
                        }
                        $.magnificPopup.close();
                        toastr.success("Success");
                        init();
                    },
                    error: function (err) {
                        console.log(err);
                        toastr.warning("Something failed");
                    }
                });
            });


            $(".log-dialog-cancel").click(function () {
                $.magnificPopup.close();
            });



            // Ajax for download file
            $('.btn-edit').click(function () {
                var tr = $(this).closest('tr');
                $('#file-id').val($(tr).attr('file-id'));
                $('#file-name').val($(tr).find('.label-name').text());
                $('#file-description').val($(tr).find('.label-description').text());
                $('#file-path').val($(tr).find('.btn-download').attr('href'));
                $('#file-update-date').datepicker('setDate', $(tr).find('.label-update-date').text());
                $.magnificPopup.open({
                    items: {
                        src: '#file-dialog',
                        type: 'inline'
                    },
                    preloader: false,
                    modal: true,
                });
            });

            $('.dialog-ok').click(function () {
                var fileId = $('#file-id').val();
                var fileName = $('#file-name').val();
                var fileDescription = $('#file-description').val();
                var filePath = $('#file-path').val();
                var fileUpdateDate = $('#file-update-date').val();
                $.ajax({
                    url: '/downloads/save/' + fileId,
                    method: 'POST',
                    data: {
                        name: fileName,
                        description: fileDescription,
                        path: filePath,
                        update_date: fileUpdateDate,
                    },
                    success: function (res) {
                        var fields = $('tr[file-id=' + fileId + '] td');
                        $(fields[0]).html(fileName);
                        $(fields[1]).html(fileDescription);
                        $(fields[2]).find('a').attr('href', filePath);
                        $(fields[3]).html(fileUpdateDate);
                        $.magnificPopup.close();
                        toastr.success("Success")
                    },
                    error: function (err) {
                        console.log(err);
                        toastr.warning("Something failed");
                    }
                });
            });
            $(".dialog-cancel").click(function () {
                $.magnificPopup.close();
            });
        }).apply(this, [jQuery]);
    </script>
@endsection