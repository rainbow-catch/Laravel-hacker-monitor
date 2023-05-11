@extends('layouts.app')

@section('content')

    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">

            <div class="panel-body">
                <div class="pl-sm">
                    <center><h1>Welcome to SoftwareRG </h1></center>

                    <!--spacer here-->
                    <center><img src="assets/images/logo1.png" alt="" width="45%"/></center><!--box starts-->

                    <center><h6>Status of your anti hack</h6></center>
                    @if($complete)
                        <center><span class="badge bg-success">Complete</span></center>
                    @elseif($incomplete)
                        <center><span class="badge bg-warning">Incomplete</span></center>
                    @else
                        <center><span class="badge bg-danger">Not Installed</span></center>
                    @endif

                    <center><h6>Expiration date:</h6></center>

                    <center><h6 style="color:#FB5616" ;><b>{{ Auth::user()->enddate()}}</b></h6></center>


                    <center><h6>Authorized IP:</h6></center>
                    <center><h6 style="color:#FB5616" ;><b>{{ Auth::user()->ip()}}</b></h6></center>
                    @if(Auth::user()->approve > 1)
                        <center>
                            @if($complete || $incomplete)
                                <a href="#" class="btn btn-primary btn-reinstall">Re-install</a>
                            @else
                                <a href="/ftp/install" class="btn btn-primary">Install</a>
                            @endif
                            @if($complete || $incomplete)
                                <a href="#" class="btn btn-danger btn-uninstall">Un-install</a>
                            @endif
                        </center>
                    @endif
                </div>
            </div>


        </section>
    </section>
    </section>

    <div id="confirm-dialog" class="modal-block mfp-hide">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Warning!</h2>
            </header>
            <div class="panel-body">
                <p>Are you sure that you want to <span id="action-name" class="text-danger text-weight-bold"></span>?
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



@endsection

@section('script')
    <script type="text/javascript">
        (function ($) {
            'use strict';

            var action;

            $(".btn-uninstall").click(function () {
                action = 'uninstall';
                $("#action-name").text("uninstall");

                $.magnificPopup.open({
                    items: {
                        src: '#confirm-dialog',
                        type: 'inline'
                    },
                    preloader: false,
                    modal: true,
                });
            });

            $(".btn-reinstall").click(function () {
                action = 'reinstall';
                $("#action-name").text("reinstall");

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
                window.location.href = "/ftp/" + action;
                $.magnificPopup.close();
            });

            $(".dialog-cancel").click(function () {
                $.magnificPopup.close();
            });
        }).apply(this, [jQuery]);
    </script>
@endsection


