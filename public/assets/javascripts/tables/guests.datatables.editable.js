/*
Name: 			Tables / Editable - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.7.0
*/

(function($) {

    'use strict';

    var roleCheckBoxes = [
        { id: "input-see-home", label: "See Home", value: "see_home"},
        { id: "input-see-screenshots", label: "See Screenshots", value: "see_screenshots"},
        { id: "input-see-hacklogs", label: "See Hack Logs", value: "see_hack_logs"},
        { id: "input-see-connectlogs", label: "See Connect Logs", value: "see_connect_logs"},
        { id: "input-see-toolsdownload", label: "See Tools Download", value: "see_tools_download"},
        { id: "input-see-guides", label: "See Guides", value: "see_guides"},
        { id: "input-see-hardware", label: "Ban Hardware", value: "see_ban_hardware"},
    ].map(function(item){
        return '<input type="checkbox" name="role[]" value="' + item.value + '" class="form-check mr-md" id="' + item.id + '">' +
            '<label for="' + item.id + '">' + item.label + '</label><br/>';
    }).join("\n");
    var EditableTable = {

        options: {
            addButton: '#addToTable',
            table: '#datatable-editable',
            dialog: {
                wrapper: '#dialog',
                cancelButton: '#dialogCancel',
                confirmButton: '#dialogConfirm',
            }
        },

        initialize: function() {
            this
                .setVars()
                .build()
                .events();
        },

        setVars: function() {
            this.$table				= $( this.options.table );
            this.$addButton			= $( this.options.addButton );

            // dialog
            this.dialog				= {};
            this.dialog.$wrapper	= $( this.options.dialog.wrapper );
            this.dialog.$cancel		= $( this.options.dialog.cancelButton );
            this.dialog.$confirm	= $( this.options.dialog.confirmButton );

            return this;
        },

        build: function() {
            $('#datatable-editable thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#datatable-editable thead');
            this.datatable = this.$table.DataTable({
                aoColumns: [
                    null,
                    null,
                    null,
                    null,
                    { "bSortable": false }
                ],
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function () {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title + '" />');

                            // On every keypress in this input
                            $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                                .off('keyup change')
                                .on('change', function (e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != ''
                                                ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                : '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function (e) {
                                    e.stopPropagation();
                                    var cursorPosition = this.selectionStart;

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });

            window.dt = this.datatable;

            return this;
        },

        events: function() {
            var _self = this;

            this.$table
                .on('click', 'a.save-row', function( e ) {
                    e.preventDefault();

                    _self.rowSave( $(this).closest( 'tr' ) );
                })
                .on('click', 'a.cancel-row', function( e ) {
                    e.preventDefault();

                    _self.rowCancel( $(this).closest( 'tr' ) );
                })
                .on('click', 'a.edit-row', function( e ) {
                    e.preventDefault();

                    _self.rowEdit( $(this).closest( 'tr' ) );
                })
                .on( 'click', 'a.remove-row', function( e ) {
                    e.preventDefault();

                    var $row = $(this).closest('tr'),
                        itemId = $row.find('td:eq(0)').html();

                    $.magnificPopup.open({
                        items: {
                            src: _self.options.dialog.wrapper,
                            type: 'inline'
                        },
                        preloader: false,
                        modal: true,
                        callbacks: {
                            change: function () {
                                _self.dialog.$confirm.on('click', function (e) {
                                    e.preventDefault();

                                    $.ajax({
                                        url: '/licenseSetting/guest_delete',
                                        method: 'GET',
                                        data: {
                                            id: itemId
                                        },
                                        success: function () {
                                            _self.rowRemove($row);
                                        }
                                    });

                                    $.magnificPopup.close();
                                });
                            },
                            close: function () {
                                _self.dialog.$confirm.off('click');
                            }
                        }
                    })
                });

            this.$addButton.on( 'click', function(e) {
                e.preventDefault();

                _self.rowAdd();
            });

            this.dialog.$cancel.on( 'click', function( e ) {
                e.preventDefault();
                $.magnificPopup.close();
            });

            return this;
        },

        // ==========================================================================================
        // ROW FUNCTIONS
        // ==========================================================================================
        rowAdd: function() {
            this.$addButton.attr({ 'disabled': 'disabled' });

            var actions,
                data,
                $row;

            actions = [
                '<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>',
                '<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>',
                '<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>',
                '<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>',
            ].join(' ');

            data = this.datatable.row.add([ '', '', '', '', actions ]);
            $row = this.datatable.row( data[0] ).nodes().to$();

            $row
                .addClass( 'adding' )
                .find( 'td:last' )
                .addClass( 'actions' );
            $row
                .find( 'td:eq(0)' )
                .attr( 'hidden', true );
            $row
                .find( 'td:eq(3)')
                .addClass('roles');

            this.rowEdit( $row );

            this.datatable.order([0,'asc']).draw(); // always show fields
        },

        rowCancel: function( $row ) {
            var _self = this,
                $actions,
                i,
                data;

            if ( $row.hasClass('adding') ) {
                this.rowRemove( $row );
            } else {

                data = this.datatable.row( $row.get(0) ).data();
                this.datatable.row( $row.get(0) ).data( data );

                $actions = $row.find('td.actions');
                if ( $actions.get(0) ) {
                    this.rowSetActionsDefault( $row );
                }

                this.datatable.draw();
            }
        },

        rowEdit: function( $row ) {
            var _self = this,
                data;

            data = this.datatable.row( $row.get(0) ).data();

            $row.children( 'td' ).each(function( i ) {
                var $this = $( this );

                if ( $this.hasClass('actions') ) {
                    _self.rowSetActionsEditing( $row );
                } else if ($this.hasClass('roles')) {
                    $this.html( roleCheckBoxes );
                } else {
                    $this.html( '<input type="text" class="form-control input-block" value="' + data[i] + '"/>' );
                }
            });

            setTimeout(function() {
                data[3].split("|").map(function(item){
                    $('#input-see-' + item.toLowerCase()).attr('checked', true);
                })
            }, 100);

        },
		rowSave: function( $row ) {
					var _self     = this,
						$actions, roles,
						values    = [],
						parms = [];
					values = $row.find('td').map(function() {
						var $this = $(this);

						if ( $this.hasClass('actions') ) {
							_self.rowSetActionsDefault( $row );
							return _self.datatable.cell( this ).data();
						} else if($this.hasClass('roles')) {
                            var roles = $this.find('input').map(function(){
                                return this.checked?1:0;
                            }).get();
                            parms.push(roles);
                            return $.trim( values.join("|") );
                        } else {
							parms.push($this.find('input').val());
							return $.trim( $this.find('input').val() );
						}
					});
    					console.log(parms)
                    var row_num, new_user;
					$.ajax({
						url: '/admin/guest_save',
						method: 'GET',
						data: {
							parms: parms,
						},
						success: function(response) {
                            row_num = response.user_id;
                            new_user = response.new_user;
                            roles = response.roles;
                            if(new_user == false)
                                window.location.replace('users');
                            if ( $row.hasClass( 'adding' ) ) {
                                this.$addButton.removeAttr( 'disabled' );
                                $row.removeClass( 'adding' );
                            }

                            values = $row.find('td').map(function() {
                                var $this = $(this);

                                if ( $this.hasClass('actions') ) {
                                    _self.rowSetActionsDefault( $row );
                                    return _self.datatable.cell( this ).data();
                                }
                                else if( $this.hasClass('roles') ) {
                                    return roles;
                                }
                                else {
                                    return $.trim( $this.find('input').val() );
                                }
                            });

                            _self.datatable.row( $row.get(0) ).data( values );

                            $actions = $row.find('td.actions');
                            if ( $actions.get(0) ) {
                                _self.rowSetActionsDefault( $row );
                            }

                            _self.datatable.draw(true);
						}
					});
				},


        rowRemove: function( $row ) {
            if ( $row.hasClass('adding') ) {
                this.$addButton.removeAttr( 'disabled' );
            }

            this.datatable.row( $row.get(0) ).remove().draw();
        },

        rowSetActionsEditing: function( $row ) {
            $row.find( '.on-editing' ).removeClass( 'hidden' );
            $row.find( '.on-default' ).addClass( 'hidden' );
        },

        rowSetActionsDefault: function( $row ) {
            $row.find( '.on-editing' ).addClass( 'hidden' );
            $row.find( '.on-default' ).removeClass( 'hidden' );
        }
    };

    $(function() {
        EditableTable.initialize();
    });

}).apply(this, [jQuery]);