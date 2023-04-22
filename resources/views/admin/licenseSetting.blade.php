@extends('layouts.app')

@section('content')
    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">
            <div class="panel-body">
                <div class="pl-sm">
                    <form class="col-md-6" id="licenseSetting-form" method="POST"
                          action="{{ route('licenseSetting.save') }}">
                        @csrf
                        <h1 style="color:#2B7EF8" ;><b>License Setting</b>
                            <text style="font-size: 20px" class="ml-md"></text>
                        </h1>
                        <br/>
                        <?php
                        $licenseItems = [
                            'name' => 'Client Name',
                            'memory' => 'Check Memory',
                            'launcher' => 'Force Launcher',
                            'crc32' => 'Launcher CRC32',
                            'system' => 'Macros System',
                            'instance' => 'Max Instances',
                        ];?>
                        @foreach($setting as $key => $val)
                            @if($key=='id') @continue; @endif
                            <div class="row mt-md">
                                <label class="col-md-4">{{ $licenseItems[$key] }}</label>
                                <div class="col-md-8 switch switch-sm switch-primary">
                                    <input type="checkbox" name="{{ str_replace(' ', '_', $key) }}" data-plugin-ios-switch
                                           {{ $val > 0? 'checked': '' }}/>
                                </div>
                            </div>
                        @endforeach


                        <div class="row mt-md">
                            <button class="btn btn-primary" id="btn-save">Save</button>
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


