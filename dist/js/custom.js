  $(function () {

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
    
    
    
    //DataTable
    $("#example1").DataTable();
    
    //DataTable
    $("#report_table").DataTable({
        "scrollY": 400,
        "scrollX": true,
        "bPaginate": false,
        "dom": '<"heading">frtip'
    });
    $("div.heading").html('<b>Custom tool bar! Text/images etc.</b>');
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