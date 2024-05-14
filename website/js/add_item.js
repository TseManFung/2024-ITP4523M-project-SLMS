document.addEventListener('DOMContentLoaded', function () {
    const file_input_loc = document.querySelector("#item-img-input")
    const image_loc = document.querySelector("#item-img")

    file_input_loc.addEventListener('change', function () {
        change_img()
    })

    function change_img() {
        if (file_input_loc.value === "") {
            image_loc.src = ""
            return
        }
        if (file_input_loc.files && file_input_loc.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                image_loc.src = e.target.result;
            };

            reader.readAsDataURL(file_input_loc.files[0]);
        }
    }
})