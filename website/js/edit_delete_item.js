document.addEventListener('DOMContentLoaded', function () {
    $("#item-img-input").bind('change drop', function () {
        change_img();
    });
    function change_img(){
        const file_input_loc = document.querySelector("#item-img-input")
		$('#item-img-input').removeClass('image-dropping')

        if (file_input_loc.value === "") {
            $('#item-img').attr('src', "");
            return
        }
        if (file_input_loc.files && file_input_loc.files[0]) {
            var reader = new FileReader();
        
            reader.onload = function (e) {
              $('#item-img').attr('src', e.target.result);
            };
        
            reader.readAsDataURL(file_input_loc.files[0]);
          }
    }
    $('#item-img-input').bind('dragover', function () {
		$('#item-img-input').addClass('image-dropping');
	});
    $('#item-img-input').bind('dragleave', function () {
		$('#item-img-input').removeClass('image-dropping')})
    
    // get the data about the item, getParameterFromURL("itemNumber")
})

function Submit() {
    $(".alert").addClass("d-none");

    // check if any is null or wrong: alert wornging
    // https://getbootstrap.com/docs/5.3/forms/floating-labels/#input-groups

    // document.add_item.submit(); is not ok
    // use other way to submit
    
    $("#successful").removeClass("d-none");

}

function Cancel(){
    // go back to the previous page
    // window.history.back();
}
function Cancel_delete(){
    $(".alert").addClass("d-none");
}

function Delete(){
    $(".alert").addClass("d-none");
    // try to set the state to D (delete) of this item
    // if success, show the successful alert
    $("#successful").removeClass("d-none");
    // if fail, show the fail alert
}

function confirm_delete(){
    $("#confirm-delete").removeClass("d-none");
}