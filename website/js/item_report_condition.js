$(document).ready(function() {
    $('#hasDate').change(function() {
        if ($("#hasDate")[0].checked) {
            $("#dateRange").removeClass("d-none");
            $("#dateRange").find("input").prop("disabled", false);
        } else {
            $("#dateRange").addClass("d-none");
            $("#dateRange").find("input").prop("disabled", true);
        }
    });

    if (getParameterFromURL("spnum") !== null) {
        $("#spec_item_row").removeClass("d-none");
        $("#all_item_row").addClass("d-none");
        // init in here
    }
    
});