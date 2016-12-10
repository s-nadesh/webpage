$(function () {

    //set-alert-per-product
    $("#set_alert_per_product").validate({
        // Specify the validation rules
        rules: {
            product: "required",
            email: {
                required: true,
                email: true
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    //Create Bomx Form
    $("#create_bomx_form").validate({
        // Specify the validation rules
        rules: {
            PARENT_PN: "required",
            CHILD_PN: "required",
            CHILD_DESC: "required",
            CREATED_ON: "required",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });


    //Create new user form
    $("#new_user_form").validate({
        // Specify the validation rules
        rules: {
            first_name: "required",
            user_name: "required",
            email: {
                required: true,
                email: true
            },
            phone_no: {
                number: true,
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            old_password: "required",
        },
        // Specify the validation error messages
//        messages: {
//            first_name: "Please enter your first name",
//            user_name:"Please enter your login user name",
//            phone_no:{
//                required: "Please enter your phone number",
//                number:"Please enter a valid number",
//            },
//            password: {
//                required: "Please provide a password",
//                minlength: "Your password must be at least 5 characters long"
//            },
//            email: "Please enter a valid email address",
//            agree: "Please accept our policy"
//        },

        submitHandler: function (form) {
            form.submit();
        }
    });


    //icheckbox


    var checkAllPN = $('input.check_all_pn');
    var checkPN = $('input.check_pn');

    checkAllPN.on('ifChecked ifUnchecked', function (event) {
        if (event.type == 'ifChecked') {
            checkPN.iCheck('check');
        } else {
            checkPN.iCheck('uncheck');
        }
    });

    checkPN.on('ifChanged', function (event) {
        if (checkPN.filter(':checked').length === checkPN.length) {
            checkAllPN.prop('checked', 'checked');
        } else {
            checkAllPN.prop('checked', '');
        }
        checkAllPN.iCheck('update');

    });


    var checkAll = $('input.all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function (event) {
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function (event) {
        if (checkboxes.filter(':checked').length === checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.prop('checked', '');
        }
        checkAll.iCheck('update');

    });



    //Date picker
    $('#datepicker-start').datepicker({
        autoclose: true,
    });
    $('#datepicker-end').datepicker({
        autoclose: true
    });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });


    var hideFromExport = [0];

    //DataTable
    $("#example1").DataTable();
    var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    $("#xml_to_table").DataTable({
        "bDestroy": true
    });

    $("#table-permission").DataTable({
        "scrollY": (h - 360),
        "scrollX": true,
        "bPaginate": false,
        "bFilter": false,
//        "dom": '<"heading">frtip'
    });

    //DataTable
//    $("#report_table").DataTable({
//        "scrollY": 380,
//        "scrollX": true,
//        "bPaginate": false,
//        "dom": '<"heading">frtip'
//    });
    var table = $("#report_table_sn").DataTable({
        "scrollY": (h - 215),
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">Bfrtip',
//        "columnDefs": [
//            {"width": "20%", "targets": "_all"}
//        ],
        buttons: [{
                extend: 'excelHtml5',
                title: 'data',
                text: 'Xport',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ],
        drawCallback: function (settings) {
            var api = this.api();

            $('.rca_val, .explaination', api.table().body())
                    .editable()
                    .off('hidden')
                    .on('hidden', function (e, reason) {
                        if (reason === 'save') {
                            var dataid = $(this).closest('td').data('testheader-id');
                            var datacol = $(this).closest('td').data('colname');
                            if ($(this).text() != 'Empty') {
                                var datauserid = $(this).text();
                            } else {
                                var datauserid = '';
                            }
                            $.ajax({
                                type: "POST",
                                data: {testheaderid: dataid, colname: datacol, dataval: datauserid},
                                url: "ajaxaction.php",
                                success: function (data) {
//                                alert(data);
                                }
                            });
                            $(this).closest('td').attr('data-order', $(this).text());
                            table.row($(this).closest('tr')).invalidate().draw(false);
                        }
                    });
        },
    });
    $('#report_table_sn .root_cause_by').editable({
        type: 'select',
        name: 'Type',
        title: 'Type',
        source: [
            {value: '', text: ' Select '},
            {value: 'FAILURE1', text: 'FAILURE1'},
            {value: 'FAILURE2', text: 'FAILURE2'},
            {value: 'FAILURE3', text: 'FAILURE3'},
            {value: 'FAILURE4', text: 'FAILURE4'},
            {value: 'FAILURE5', text: 'FAILURE5'},
            {value: 'FAILURE6', text: 'FAILURE6'},
            {value: 'FAILURE7', text: 'FAILURE7'},
            {value: 'FAILURE8', text: 'FAILURE8'},
            {value: 'FAILURE9', text: 'FAILURE9'},
            {value: 'FAILURE10', text: 'FAILURE10'},
        ]
    });
    $(document).on('click', '.root_cause .editable-submit', function () {
        var dataid = $(this).closest('td').data('testheader-id');
        var datacol = $(this).closest('td').data('colname');
        var dataval = $('.root_cause .input-sm').val();
//                alert($('.rca_by .input-sm').val());
        $.ajax({
            type: "POST",
            data: {testheaderid: dataid, colname: datacol, dataval: dataval},
            url: "ajaxaction.php",
            success: function (data) {
//                                alert(data);
            }
        });
    });

    $("#report_table").DataTable({
        "scrollY": (h - 215),
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                title: 'data',
                text: 'Xport',
                exportOptions: {
//                    columns: ':visible'
                    columns: function (idx, data, node) {
                        var isNotForExport = $.inArray(idx, hideFromExport) !== -1;
                        return !isNotForExport ? true : false;
                    }
                }
            }
        ]
    });

    $("#conversion-plus").DataTable({
        "scrollY": (h - 380),
        "scrollX": true,
        "bPaginate": false,        
        "dom": '<"heading">Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                title: 'data',
                text: 'Xport',
                exportOptions: {
                    columns: ':visible',
//                    format: {
//                        body: function (data, row, column, node) {
//                            if (column === 0) {
//                                var res = data.replace(/(<([^>]+)>)/ig, "");
//                                var res1 = $.trim(res);                                
//                                return res1;
//                            } else {
//                                return data;
//                            }
//
//                        }
//                    }
                }
            }
        ]
    });

    $("#conversion-minus").DataTable({
        "scrollY": (h - 380),
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                title: 'data',
                text: 'Xport',
                exportOptions: {
                    columns: ':visible'
//                    columns: function (idx, data, node) {
//                        var isNotForExport = $.inArray(idx, hideFromExport) !== -1;
//                        return !isNotForExport ? true : false;
//                    }
                }
            }
        ]
    });

    $("#a-report-table").DataTable({
        "scrollY": (h - 220),
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                title: 'data',
                text: 'Xport',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });
    $("#table_date").DataTable({
        "scrollY": (h - 270),
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                title: 'data',
                text: 'Xport',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });
    $("#table_nodate").DataTable({
        "scrollY": (h - 270),
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                title: 'data',
                text: 'Xport',
                exportOptions: {
                    columns: function (idx, data, node) {
                        var isNotForExport = $.inArray(idx, hideFromExport) !== -1;
                        return !isNotForExport ? true : false;
                    }
                }
            }
        ]
    });



    var hideFromExport1 = [2];
    $("#alert_product_tables").DataTable({
        "scrollY": (h - 215),
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                title: 'data',
                text: 'Xport',
                exportOptions: {
                    columns: function (idx, data, node) {
                        var isNotForExport = $.inArray(idx, hideFromExport1) !== -1;
                        return !isNotForExport ? true : false;
                    }
                }
            }
        ]
    });
    $(".check_create, .check_edit, .check_delete").on("ifChecked", function (event) {
        _class = $(this).data("chbx");
        $(".check_view." + _class).iCheck("check");
    });
    $(".check_view").on("ifUnchecked", function (event) {
        _class = $(this).data("chbx");
        $("." + _class).iCheck("uncheck");
    });

    $(".alert-success, .alert-danger").delay(3200).fadeOut(300);
//    $(".alert-danger").delay(3200).fadeOut(300);
});
var expanded = false;
function showCheckboxes() {
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
}

//Modal SN
$("#myModal").on("shown.bs.modal", function (e) {
    $this = $(e.relatedTarget);

    var sn = $this.data("sn");
    var starttime = $this.data("starttime");
    $('#xml-table').val("XML_TO_TESTHEADER");
    $('#serial_number').val(sn);
    $('#start_time').val(starttime);
    xml_to_table(sn, starttime, "XML_TO_TESTHEADER", "Show Test History");
});

$("#myModal").on("hidden.bs.modal", function (e) {
    $("#xml_to_table_div").html('');
});

$("#loading").hide();
//            $(".report-sn").click(function () {
//                var sn = $(this).data("sn");
//                var starttime = $(this).data("starttime");
//                $('#xml-table').val("XML_TO_TESTHEADER");
//                $('#serial_number').val(sn);
//                $('#start_time').val(starttime);
//                xml_to_table(sn, starttime, "XML_TO_TESTHEADER", "Show Test History");
//            });

$('body').on('change', '#xml-table', function () {
    var table = $('#xml-table').val();
    var table_title = $('#xml-table option:selected').text();
    var sn = $('#serial_number').val();
    var starttime = $('#start_time').val();
    xml_to_table(sn, starttime, table, table_title);
});           
            
function xml_to_table(sn, starttime, table, table_title) {
    $.ajax({
        type: "POST",
        url: "xml_to_tests.php",
        data: {sn: sn, starttime: starttime, table: table},
        beforeSend: function () {
            $("#xml_to_table_div").html("");
            $("#loading").show();
        },
        complete: function () {
            $("#loading").hide();
        },
        success: function (response) {
            $("#xml_to_table_div").html(response);
            $("#xml_to_table").dataTable().fnDestroy();
            $("#xml_to_table").DataTable({
                "bDestroy": true,
                "scrollY": 500,
                "scrollX": true,
                "bPaginate": false,
                "dom": '<"modal_heading">Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        title: 'data',
                        text: 'Xport',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });
            $("#xml_to_table").dataTable().fnDraw();
            $("div.modal_heading").html('<b>' + table_title + '</b>');
        }
    });
}
