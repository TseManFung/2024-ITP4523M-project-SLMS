document.addEventListener("DOMContentLoaded", function () {
  $("#item-img-input").bind("change drop", function () {
    change_img();
  });
  function change_img() {
    const file_input_loc = document.querySelector("#item-img-input");
    $("#item-img-input").removeClass("image-dropping");

    if (file_input_loc.value === "") {
      $("#item-img").attr("src", "");
      return;
    }
    if (file_input_loc.files && file_input_loc.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#item-img").attr("src", e.target.result);
      };

      reader.readAsDataURL(file_input_loc.files[0]);
    }
  }
  $("#item-img-input").bind("dragover", function () {
    $("#item-img-input").addClass("image-dropping");
  });
  $("#item-img-input").bind("dragleave", function () {
    $("#item-img-input").removeClass("image-dropping");
  });

  $("#ED_item").on("submit", function (e) {
    //$(".alert").addClass("d-none");
    e.preventDefault();
    // check if any is null or wrong: alert wornging
    // https://getbootstrap.com/docs/5.3/forms/floating-labels/#input-groups
    is_valid = true;
    inputs = $(".form-control:valid");
    for (i = 0; i < inputs.length; i++) {
      if (inputs[i].value === "" && inputs[i].id != "item-img-input") {
        inputs[i].classList.add("is-invalid");
        is_valid = false;
      }
    }
    if (!is_valid) {
      return;
    }
    // document.add_item.submit(); is not ok
    // use other way to submit
    var formData = new FormData(this);
    formData.append("sparePartNum", $("#SpacePartNumber").val());
    $.ajax({
      url: "./item.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        jsonResponse = JSON.parse(response);
        $("#successful")
          .html(`successful to edit or delete the spare part: ${jsonResponse.sparePartName}.`);

          $("#successful").removeClass("d-none");
          $("#fail").addClass("d-none");
          $("#confirm-delete").addClass("d-none");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $("#fail").html(
          `fail to add a new spare part.<br>Reason: ${jqXHR.responseText}<br>Please try again.`
        );
        $("#fail").removeClass("d-none");
        $("#successful").addClass("d-none");
        $("#confirm-delete").addClass("d-none");
      },
    });
    
  })
});



function Cancel_delete() {
  $(".alert").addClass("d-none");
}

function Delete() {
  $(".alert").addClass("d-none");
  // try to set the state to D (delete) of this item
  // if success, show the successful alert
  $("#successful").removeClass("d-none");
  // if fail, show the fail alert
}

function confirm_delete() {
  $(".alert").addClass("d-none");

  $("#confirm-delete").removeClass("d-none");
}
