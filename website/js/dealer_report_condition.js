$(document).ready(function() {
    $('#hasDate').change(function() {
        if ($("#hasDate")[0].checked) {
            $("#dateRange").removeClass("d-none");
        } else {
            $("#dateRange").addClass("d-none");
        }
    });
  
});