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

function productDetail(itemID) {
    window.location.href = `./product_detail.php?spnum=${itemID}`;
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