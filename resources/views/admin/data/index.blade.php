@extends('layouts.app')

@section('content')


    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel">

            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="mb-md">
                            <button id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-sm-3" style="display: flex">
                        <span style="margin:auto"> Month: </span>
                        <select id="selectMonth" class='form-control'>
                            <option value=" ">All</option>
                            <option value="01">1</option>
                            <option value="02">2</option>
                            <option value="03">3</option>
                            <option value="04">4</option>
                            <option value="05">5</option>
                            <option value="06">6</option>
                            <option value="07">7</option>
                            <option value="08">8</option>
                            <option value="00">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                </div>

                <table class="table table-bordered table-striped mb-none" id="data-datatable-editable" width="100%">
                    <thead>
                    <tr>
                        <th hidden>ID</th>
                        <th>TITLE</th>
                        <th>CONTENT</th>
                        <th>DATE</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $data as $item )
                        <tr data-item-id="55">
                            <td class="user_id" hidden>{{ $item->id }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->content }}</td>
                            <td>{{ $item->date }}</td>
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

    <script src="{{ asset('assets/javascripts/tables/data.datatables.editable.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('input').addClass('form-control');
            $('select').addClass('form-control');
        });

    </script>
@endsection