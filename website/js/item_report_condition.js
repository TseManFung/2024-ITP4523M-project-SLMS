$(document).ready(function() {
    $('#hasDate').change(function() {
        if ($("#hasDate")[0].checked) {
            $("#dateRange").removeClass("d-none");
        } else {
            $("#dateRange").addClass("d-none");
        }
    });

    if (getParameterFromURL("spnum") !== null) {
        $("#spec_item_row").removeClass("d-none");
        $("#all_item_row").addClass("d-none");
        // init in here
    }
});