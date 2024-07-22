// JavaScript 代码
(function () {
  'use strict';

  // 设置当前日期和时间
  function setCurrentDateTime() {
    var now = new Date();
    var formattedDateTime = now.getFullYear() + '/' +
      ('0' + (now.getMonth() + 1)).slice(-2) + '/' +
      ('0' + now.getDate()).slice(-2) + ' ' +
      ('0' + now.getHours()).slice(-2) + ':' +
      ('0' + now.getMinutes()).slice(-2) + ':' +
      ('0' + now.getSeconds()).slice(-2);
    // document.getElementById('Order-D-T').value = formattedDateTime;
  }

  window.addEventListener('load', function () {
    // 设置当前日期和时间
    setCurrentDateTime();

    // 获取需要验证的表单
    var forms = document.getElementsByClassName('needs-validation');

    // 遍历这些表单并阻止提交
    Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
}());


async function get_delivery_cost(weight, quantity) {
  return new Promise((resolve, reject) => {
    try {
      $.ajax({
        url: `http://127.0.0.1:8080/ship_cost_api/quantity/${quantity}`,
        crossDomain: true,
        dataType: 'json',
        success: function (data) {
          if (data.result == "resolveed") {
            resolve(data.reason);
          } else if (data.result == "accepted") {
            var quantityCost = data.cost;
            $.ajax({
              url: `http://127.0.0.1:8080/ship_cost_api/weight/${weight}`,
              crossDomain: true,
              dataType: 'json',
              success: function (data) {
                if (data.result == "resolveed") {
                  resolve(data.reason);
                } else if (data.result == "accepted") {
                  var weightCost = data.cost;
                  resolve(Math.max(weightCost, quantityCost));
                } else {
                  resolve("Error");
                }
              },
              error: function (xhr, status, error) {
                resolve(xhr.responseJSON ? xhr.responseJSON.reason : error);
              }
            });
          } else {
            resolve("Error");
          }
        },
        error: function (xhr, status, error) {
          resolve(xhr.responseJSON ? xhr.responseJSON.reason : error);
        }
      });
    } catch (outerError) {
      resolve(outerError.message);
    }
  });
}
function getCurrentFormattedTime() {
  const now = new Date();
  const year = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, '0');
  const day = String(now.getDate()).padStart(2, '0');
  const hours = String(now.getHours()).padStart(2, '0');
  const minutes = String(now.getMinutes()).padStart(2, '0');
  const seconds = String(now.getSeconds()).padStart(2, '0');

  const formattedTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
  return formattedTime;
}


$(document).ready(async function () {
  let index = 1;
  while (true) {
    // Select order elements by index
    let weightElement = document.getElementById(`Order-Weight-${index}`);
    let quantityElement = document.getElementById(`Order-Quantity-${index}`);
    let amountElement = document.getElementById(`Order-Amount-${index}`);

    // Exit loop if any element is not found
    if (!weightElement || !quantityElement || !amountElement) {
      break;
    }

    // Clean and parse initial values
    let TW = parseFloat(weightElement.value.replace(/[^0-9.]/g, '')) || 0;
    let TQ = parseFloat(quantityElement.value.replace(/[^0-9.]/g, '')) || 0;
    let ST = parseFloat(amountElement.value.replace(/[^0-9.]/g, '')) || 0;

    // Get delivery cost
    result = await get_delivery_cost(TW, TQ)
/*       .then(result => { */
        console.log('Delivery cost:', result);

        let deliveryFeeElement = document.getElementById(`Delivery-Fee-${index}`);
        if (result === "Error") {
          deliveryFeeElement
          deliveryFeeElement.innerHTML = "Rejected orders, excessive weight, excessive quantity or no available items";
          deliveryFeeElement.value = result;
        } else {
          let deliveryCost = parseFloat(result);
          if (isNaN(deliveryCost)) {
            console.error('Invalid delivery cost');
            return;
          }
          deliveryFeeElement.value = "$" + result.toFixed(2);
          ST += deliveryCost;
          let totalOrderAmountElement = document.getElementById(`Total-Order-Amount-${index}`);
          if (totalOrderAmountElement) {
            totalOrderAmountElement.value = "$" + ST.toFixed(2);
          }
        }
/*       })
      .catch(error => {
        console.error('Error fetching delivery cost:', error);
      }); */

    index++;
  }
});




function showmyModal(tTitle, tbody, redirectUrl = null) {
  document.getElementById("exampleModalLongTitle").innerHTML = tTitle;
  document.getElementById("modal-body").innerHTML = tbody;

  if (redirectUrl) {
    $('#myModal').on('hidden.bs.modal', function () {
      window.location.href = redirectUrl;
    });
  } else {
    $('#myModal').off('hidden.bs.modal'); // 移除以前的重定向绑定
  }

  $('#myModal').modal('show');
}

function closeModal() {
  $('#myModal').modal('hide');
}



function checkout(id, qty) {
  var addressInput = document.getElementById("address");
  if (!addressInput.value.trim()) {
    showmyModal("Fail", "Delivery Address cannot be empty");
    addressInput.focus();
    return;
  } else {
    const deliveryAddress = addressInput.value;
    const dealerID = id;
    const orderItemNumber = qty;
    const TotalAmount = parseFloat(document.getElementById('Order-Amount').value.replace('$', ''));
    const shipCost = parseFloat(document.getElementById('Delivery-Fee').value.replace('$', ''));
    const time = getCurrentFormattedTime(); // get newest time

    if (isNaN(TotalAmount) || isNaN(shipCost)) {
      showmyModal("Fail", "Total Amount and Shipping Cost must be valid numbers");
      return;
    }

    $.ajax({
      type: "POST",
      url: "./create_order.php",
      data: {
        deliveryAddre: deliveryAddress,
        dealerID: dealerID,
        orderItemNumber: orderItemNumber,
        TotalAmount: TotalAmount,
        shipCost: shipCost,
        Time: time // use newest time
      },
      success: function (data) {
        try {
          var response = data;
          if (response.order && response.cart) {
            showmyModal("Success", "Order placed and cart cleared successfully!", "../../pages/dealer/search_item.php");
          } else {
            showmyModal("Partial Success", "Order placed but there was an issue clearing the cart.");
          }
        } catch (error) {
          console.error("Parsing error:", error);
          console.error("Response data:", data);
          showmyModal("Error", "An unexpected error occurred. Check console for details.");
        }
      },
      error: function (xhr, status, error) {
        showmyModal("Fail", "Failed to submit the form. Please try again.");
      }
    });

    return true;
  }
}