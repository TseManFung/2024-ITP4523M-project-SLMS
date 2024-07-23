$(document).ready(function () {
  $(".cta").bind("click", function () {
    GoToPage_POST("./dealer_delete_order.php", {
      orderID: $(this).attr("data-order-id"),
    });
  });

  $("#btnPayByFps").bind("click", function () {
    generateQRCode(document.getElementById("qrcode"), 256, 256);
    $("#myModal").modal("show");
  });

  $("#receiptForm").on("submit", function (e) {
    e.preventDefault();
    const errorP = $("#receipt-input-error");
    inputFile = $("#receipt-img-input");
    if (inputFile.val() === "") {
      inputFile.addClass("is-invalid");
      errorP.text("Please select a file.");
      return;
    }
    const fileSize = inputFile[0].files[0].size;
    const maxSize = 10 * 1024 * 1024; // 10MB
    if (fileSize > maxSize) {
      inputFile.addClass("is-invalid");
      errorP.text("File size exceeds the maximum limit of 10MB.");
      return;
    }
    allowed_formats = ["jpg", "jpeg", "png","pdf"];
    const fileName = inputFile.val().toLowerCase();
    const fileExtension = fileName.split('.').pop();
    if (!allowed_formats.includes(fileExtension)) {
      inputFile.addClass("is-invalid");
      errorP.text("Invalid file format. Only PDF, JPG, JPEG, and PNG files are allowed.");
      return;
    }
    this.submit();
  });
});
