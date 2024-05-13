document.addEventListener('DOMContentLoaded', function () {
    const item = document.querySelector("#item")
    const Display_modes = document.querySelectorAll(`li[name="Display_mode"]`)
    const Display_class = ["cell","list" ]

    for (let i = 0; i < 2; i++) {
        Display_modes[i].addEventListener('click', function () {
            if (item.classList.contains(Display_class[i^1])) {
                item.classList.remove(Display_class[i^1])
                item.classList.add(Display_class[i])
            }
        });
        
    }


})