@extends('layouts.app')

@section('content')
    @csrf
    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">

            <div class="panel-body">
                <div class="pl-sm">
                    <h2><a href="{{ route('screenshots') }}">ScreenShots</a>/{{$folder}}</h2>
                    <div class="screenimages mt-md">
                        @foreach($images as $image)
                            <div class="screenimage text-md p-sm" data-folder="{{ $folder }}"
                                 data-image="{{ $image['name'] }}">
                                <span class="icon icon-lg">
                                    <i class="fa fa-image"></i>
                                </span>
                                <a class="text-weight-bold ml-xs btn-show-image">
                                    {{ $image['name'] }}
                                </a>
                                <span class="ml-lg text-sm">
                                    Created at: <span
                                            class="text-dark">{{ DateTime::createFromFormat('YmdHis', $image['modify'])->format('Y-m-d H:i:s') }}</span>
                                </span>
                                @if(Auth::user()->approve > 1)
                                    <a class="mr-xs float-right btn-delete-image">
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


        <div id="img-dialog" class="modal-block mfp-hide modal-block-lg">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title" id="image-name"></h2>
                </header>
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <img src="" id="dialog-image" class="col-md-12" width="100%"/>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary btn-prev-image">Prev</button>
                            <button class="btn btn-primary btn-next-image">Next</button>
                            <button class="btn btn-default dialog-cancel" data-dismiss="modal">To close</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>

        <div id="confirm-dialog" class="modal-block mfp-hide">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Warning!</h2>
                </header>
                <div class="panel-body">
                    <p>Are you sure that you want to delete this <span id="del-image-name"
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

            var curImage;
            var delImage;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".btn-show-image").click(function () {
                curImage = $(this).closest('.screenimage')[0];
                var folder = $(curImage).data('folder');
                var name = $(curImage).data('image');
                showImage(folder, name);
            });

            $(".btn-next-image").click(function () {
                var nextBtn = $(curImage.nextElementSibling).find('.btn-show-image');
                if (nextBtn.length)
                    nextBtn.click();
            });

            $(".btn-prev-image").click(function () {
                var nextBtn = $(curImage.previousElementSibling).find('.btn-show-image');
                if (nextBtn.length)
                    nextBtn.click();
            });

            $(".btn-delete-image").click(function () {
                delImage = $(this).closest('.screenimage')[0];
                var name = $(delImage).data('image');
                $("#del-image-name").text(name);

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

            $("#confirm-dialog .dialog-ok").click(function () {
                var folder = $(delImage).data('folder');
                var name = $(delImage).data('image');
                showLoading();
                $.ajax({
                    url: '/screenshot/delete',
                    method: 'POST',
                    data: {
                        folder: folder,
                        image: name
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
                        toastr.warning("failed");
                    }
                });
            });

            function showImage(folder, image) {
                $.ajax({
                    url: '/screenshot',
                    method: 'POST',
                    data: {
                        folder: folder,
                        image: image
                    },
                    success: function (resp) {
                        $("#image-name").text(image);
                        $("#dialog-image").attr("src", "/" + resp);
                        $.magnificPopup.open({
                            items: {
                                src: '#img-dialog',
                                type: 'inline'
                            },
                            preloader: true,
                            modal: true,
                        });
                    }
                });
            }
        }).apply(this, [jQuery]);
    </script>
@endsection