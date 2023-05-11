@extends('layouts.app')

@section('content')


    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">

            <div class="panel-body">
                <div class="pl-sm">
                    <h2>ScreenShots</h2>
                    <div class="screenfolders mt-md">
                        @foreach($folders as $folder)
                            <div class="screenfolder text-md p-sm" data-folder="{{ $folder['name'] }}">
                                <span class="icon icon-lg">
                                    <i class="fa fa-folder"></i>
                                </span>
                                <a class="text-weight-bold ml-xs" href="/screenimages/{{ $folder['name'] }}">
                                    {{ $folder['name'] }}
                                </a>
                                @if(Auth::user()->approve > 1)
                                    <a class="mr-xs float-right btn-delete-folder">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        @endforeach
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
                    <p>Are you sure that you want to delete this folder <span id="del-folder-name"
                                                                              class="text-danger text-weight-bold"></span>?
                    </p>
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
    <!-- end: page -->
    </section>
@endsection

@section('script')

    <script type="text/javascript">
        (function ($) {
            'use strict';

            var delFolder;

            $(".btn-delete-folder").click(function () {
                delFolder = $(this).closest('.screenfolder')[0];
                var folder = $(delFolder).data('folder');
                $("#del-folder-name").text(folder);

                $.magnificPopup.open({
                    items: {
                        src: '#confirm-dialog',
                        type: 'inline'
                    },
                    preloader: false,
                    modal: true,
                });
            });

            $("#confirm-dialog .dialog-ok").click(function () {
                var folder = $(delFolder).data('folder');
                showLoading();
                $.ajax({
                    url: '/screenshots/delete',
                    method: 'GET',
                    data: {
                        folder: folder,
                    },
                    success: function (resp) {
                        if (resp == 'success') {
                            window.history.go();
                        } else {
                            hideLoading();
                            toastr.warning("failed");
                        }
                    },
                    error: function () {
                        hideLoading();
                        toastr.warning("failed");
                    }
                });
            });

            $(".dialog-cancel").click(function () {
                $.magnificPopup.close();
            });
        }).apply(this, [jQuery]);
    </script>
@endsection