// scroll
function scrollTo(elementID) {

targetElement = document.getElementById(elementID);

targetElement.scrollIntoView();
}


// page top
document.addEventListener("DOMContentLoaded", function () {
    topBtn = document.querySelector("#page-top");
    topBtn.style.display = "none";

    window.addEventListener("scroll", function () {
        if (window.scrollY > 350) {
            topBtn.style.display = "block";
        } else {
            topBtn.style.display = "none";
        }
    });

    topBtn.addEventListener("click", function () {
        scrollTo("header-wrap");
        return false;
    });
});

// page
function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
}

// get parameter from URL
function getParameterFromURL(parameterName) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(parameterName);
}

// go back to previous page
function goBack() {
    window.history.back();
}


  function addToCart1(itemID) {
    $.ajax({
      type: "POST",
      url: "./addToCart.php",
      data: {
        sparePartNum: itemID,
        qty: 1
      },
      success: function (data) {
        location.reload();
      }
    });
    
  }
  
  function addToCart(itemID, quantity) {
    $.ajax({
      type: "POST",
      url: "./addToCart.php",
      data: {
        sparePartNum: itemID,
        qty: quantity
      },
      success: function (data) {
        window.location.href = "./dealer_cart.php";
      }
    });
    
  }

  function Submitfilter() {
    // get name="Category"
    Checkboxes = document.getElementsByName("Category");
    const currentUrl = new URL(window.location.href);
    for (const ele of Checkboxes) {
      if (ele.checked) {
        currentUrl.searchParams.delete(ele.value);
      } else {
        currentUrl.searchParams.set(ele.value, ele.value);
      }
    }
    // get  id="minPrice" id="maxPrice"
    if ($("#minPrice").val()) {
      currentUrl.searchParams.set("minPrice", $("#minPrice").val());
    } else {
      currentUrl.searchParams.delete("minPrice");
    }
    if ($("#maxPrice").val()) {
      currentUrl.searchParams.set("maxPrice", $("#maxPrice").val());
    } else {
      currentUrl.searchParams.delete("maxPrice");
    }
  
    window.location.href = currentUrl.toString();
  }

  function GoToPage_POST(action,kvPair) {
    var form = document.createElement('form');
    form.style.visibility = 'hidden'; // no user interaction is necessary
    form.method = 'POST'; // forms by default use GET query strings
    form.action = action;
    for (key in Object.keys(kvPair)) {
      var input = document.createElement('input');
      input.name = key;
      input.value = payload[key];
      form.appendChild(input); // add key/value pair to form
    }
    document.body.appendChild(form); // forms cannot be submitted outside of body
    form.submit();}