$(function () {

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

    //DataTable
    $("#report_table").DataTable({
        "scrollY": 380,
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">frtip'
    });

    $("#conversion-plus").DataTable({
        "scrollY": 360,
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: function (idx, data, node) {
                        var isNotForExport = $.inArray(idx, hideFromExport) !== -1;
                        return !isNotForExport ? true : false;
                    }
                }
            }
        ]
    });
    
    $("#conversion-minus").DataTable({
        "scrollY": 360,
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">frtip'
    });

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