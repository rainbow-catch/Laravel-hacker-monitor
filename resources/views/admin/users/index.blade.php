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
                <div class="row">
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
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Ip</th>
                        <th>End Date</th>
                        <th>Version</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach( $users as $user )
                            <tr>
                                <td class="user_id" hidden>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->password1 }}</td>
                                <td>{{ $user->ip }}</td>
                                <td class="date">{{ $user->enddate }}</td>
                                <td>{{ $user->version }}</td>
                                <td class="actions">
                                    <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                    <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                    <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>

                                    @if($user->approve != '3')
                                        <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                        <a href="#" class="on-default approve-row"><i  style="color: @if($user->approve == "1") deepskyblue @else red @endif" class="fa fa-check"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        <!-- end: page -->
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.editable.js') }}?v=1"></script>

    <script>
        $(document).ready(function() {
            $('input').addClass('form-control');
            $('select').addClass('form-control');
        });

    </script>
@endsection