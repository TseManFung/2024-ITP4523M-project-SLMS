$(document).ready(function () {
  $('input[type="file"]').bind("change drop", function () {
    change_img();
  });
  function change_img() {
    const file_input_loc = document.querySelector("#item-img-input");
    if ($('input[type="file"]').val() === "") {
      $('input[type="file"]').removeClass("image-dropping");
    }else{
      $('input[type="file"]').addClass("image-dropping");
    }
    if ($("#item-img").length) {
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
  }
  $('input[type="file"]').bind("dragover", function () {
    $('input[type="file"]').addClass("image-dropping");
  });
  $('input[type="file"]').bind("dragleave", function () {
    if ($('input[type="file"]').val() === "") {
    $('input[type="file"]').removeClass("image-dropping");
    }else{
      $('input[type="file"]').addClass("image-dropping");
    }
  });

  $("#uploadForm").on("submit", function (e) {
    e.preventDefault(); // Prevent the form from submitting via the browser
    // check if any is null or wrong: alert wornging
    // https://getbootstrap.com/docs/5.3/forms/floating-labels/#input-groups
    is_valid = true;
    inputs = $(".form-control");
    for (i = 0; i < inputs.length; i++) {
      if (inputs[i].value === "") {
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
    $.ajax({
      url: "./item.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        jsonResponse = JSON.parse(response);
        $("#successful")
          .html(`successful to add a new spare part: ${jsonResponse.sparePartName}.<br>
            The new spare part number is: ${jsonResponse.sparePartNumber}`);

        $("#successful").removeClass("d-none");
        $("#fail").addClass("d-none");
        document.uploadForm.reset();
        $("#item-img").attr("src", "");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $("#fail").html(
          `fail to add a new spare part.<br>Reason: ${jqXHR.responseText}<br>Please try again.`
        );
        $("#fail").removeClass("d-none");
        $("#successful").addClass("d-none");
      },
    });
  });
});

function Clear() {
  document.uploadForm.reset();
  $(".alert").addClass("d-none");
  $("#item-img").attr("src", "");
  inputs = $(".form-control");
  for (i = 0; i < inputs.length; i++) {
    if (inputs[i].value === "") {
      inputs[i].classList.remove("is-invalid");
    }
  }
}
