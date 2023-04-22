@extends('layouts.app')

@section('content')
    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">
            <div class="panel-body">
                <div class="pl-sm">
                    <form class="col-md-6 mr-auto col-md-offset-3" id="license-form" target="_blank" method="get"
                          action="/license/generate">
                        <h1 style="color:#2B7EF8" ; class="text-center  "><b>License </b>
                            <text style="font-size: 20px" class="ml-md"></text>
                        </h1>

                        <br/>
                        @if($setting->name)
                            <div class="row mt-md">

                            <!-- <label class="col-md-4">Expiration date:</label>
                            <div class="col-md-8">
                               <label style="color:#FB5616";><b>{{ Auth::user()->enddate }}</b></label>
                            </div>-->


                            <!-- <label class="col-md-4">Authorized IP</label>
                            <div class="col-md-8">
                                <label style="color:#FB5616";><b>{{ Auth::user()->ip }}</b></label>
                            </div>-->
                                <BR>

                                <label class="col-md-4">Client Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" placeholder="Example: Main.exe" name="client_name"
                                           required/>
                                </div>
                            </div>
                        @endif

                        @if($setting->memory)
                            <div class="row mt-md">
                                <label class="col-md-4">Check Memory<BR>
                                    <H12><p style="color:#2B7EF8" ;><b>Only for season 6 or downgrade versions.</b></p>
                                    </H12>
                                </label>
                                <div class="col-md-8 switch switch-sm switch-primary">
                                    <input type="checkbox" name="check_memo" data-plugin-ios-switch checked="checked"/>
                                </div>
                            </div>
                        @endif

                        @if($setting->launcher)
                            <div class="row mt-md">
                                <label class="col-md-4">Force Launcher <BR>
                                    <H12><p style="color:#2B7EF8" ;><b>Enable forcing of main.</b></p></H12>
                                </label>
                                <div class="col-md-8 switch switch-sm switch-primary">
                                    <input type="checkbox" name="force_launcher" data-plugin-ios-switch
                                           checked="checked"/>
                                </div>
                            </div>
                        @endif

                        @if($setting->crc32)
                            <div class="row mt-md">
                                <label class="col-md-4">Launcher CRC32</label>
                                <div class="col-md-8">
                                    <input class="form-control" placeholder="Example: 0xFFFFFFF" name="launcher_crc"
                                           required/>
                                </div>
                            </div>
                        @endif

                        @if($setting->system)
                            <div class="row mt-md">
                                <label class="col-md-4">Macros system<BR>
                                    <H12><p style="color:#2B7EF8" ;><b>Check programs with Auto potions etc.</b></p>
                                    </H12>
                                </label>
                                <div class="col-md-8 switch switch-sm switch-primary">
                                    <input type="checkbox" name="checksumm" data-plugin-ios-switch checked="checked"/>
                                </div>
                            </div>
                        @endif

                        @if($setting->instance)
                            <div class="row mt-md">
                                <label class="col-md-4">Max Instances<BR>
                                    <H12><p style="color:#2B7EF8" ;><b>Max game windows per PC.</b></p></H12>
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" name="max_instances" type="number" min="1" max="40"
                                           required value="1"/>

                                </div>
                            </div>
                        @endif
                        <!-- <div class="row mt-md">
                            <label class="col-md-4">Max Instances<BR>
                            <H12><p style="color:#2B7EF8";><b>Max game windows per PC.</b></p></H12>
                            </label>
                            <div class="col-md-8">
                                <input class="form-control" name="max_instances2" type="number" min="1" max="40" required value="1"/>
                                
                            </div>
                        </div>-->
                        <div class="row mt-md">
                            <div class="text-center">
                                <button class="btn btn-primary" id="btn-generate-key">Generate Key</button>
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

            function init() {
                $('[data-plugin-ios-switch]').each(function () {
                    $(this).themePluginIOS7Switch();
                });
            }

            init();
        }).apply(this, [jQuery]);
    </script>
@endsection


