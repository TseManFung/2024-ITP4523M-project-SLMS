(function () {
  'use strict';

  // Setting the current date and time
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
    // Setting the current date and time
    setCurrentDateTime();

    
    var forms = document.getElementsByClassName('needs-validation');

    
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
    result = await get_delivery_cost(TW, TQ);
    let deliveryFeeElement = document.getElementById(`Delivery-Fee-${index}`);
    if (result === "Error") {
      deliveryFeeElement.innerHTML = "Rejected orders, excessive weight, excessive quantity or no available items";
      deliveryFeeElement.value = result;
    } else {
      let deliveryCost = parseFloat(result);
      if (isNaN(deliveryCost)) {
        return;
      }
      deliveryFeeElement.value = "$" + result.toFixed(2);
      ST += deliveryCost;
      let totalOrderAmountElement = document.getElementById(`Total-Order-Amount-${index}`);
      if (totalOrderAmountElement) {
        totalOrderAmountElement.value = "$" + ST.toFixed(2);
      }
    }
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
    $('#myModal').off('hidden.bs.modal');
  }

  $('#myModal').modal('show');
}

function closeModal() {
  $('#myModal').modal('hide');
}

async function checkout(dealerID, totalQuantity, ordersData) {
  const addressInput = document.getElementById('address');

  // Parses ordersData into JSON and initialises orders.
  let orders;
  try {
    if (typeof ordersData === 'string') {
      orders = JSON.parse(ordersData);
    } else {
      orders = ordersData;
    }
  } catch (e) {
    showmyModal("Error", "Invalid order data format.");
    return;
  }


  let result = [];

  for (let i = 0; i < orders.length; i++) {
    let sparePartMap = {};


    for (let j = 0; j < orders[i].length; j++) {
      let sparePartNum = orders[i][j].sparePartNum;
      let qty = orders[i][j].qty;


      if (sparePartMap[sparePartNum]) {
        sparePartMap[sparePartNum] += qty;
      } else {
        sparePartMap[sparePartNum] = qty;
      }
    }

    result.push(Object.keys(sparePartMap).map(sparePartNum => ({
      sparePartNum: sparePartNum,
      qty: sparePartMap[sparePartNum]
    })));
  }

  const stockCheckPassed = await checkStock(result);
  if (!stockCheckPassed) {
    showmyModal("Error", "Insufficient stock for one or more items.","../../pages/dealer/search_item.php");
    return; 
  }

  if (!Array.isArray(orders) || orders.length === 0) {
    showmyModal("Error", "No valid orders to process.");
    return;
  }

  let index = 1;
  const finalOrders = [];

  while (true) {
    // Select order elements by index
    let totalAmountElement = document.getElementById(`Order-Amount-${index}`);
    let deliveryFeeElement = document.getElementById(`Delivery-Fee-${index}`);

    // Exit loop if any element is not found
    if (!totalAmountElement || !deliveryFeeElement) {
      break;
    }

    if (!addressInput.value.trim()) {
      showmyModal("Fail", "Delivery Address cannot be empty");
      addressInput.focus();
      return;
    }

    const deliveryAddress = addressInput.value;
    const TotalAmount = parseFloat(totalAmountElement.value.replace('$', ''));
    const shipCost = parseFloat(deliveryFeeElement.value.replace('$', ''));
    const time = getCurrentFormattedTime(); // get newest time

    if (isNaN(TotalAmount) || isNaN(shipCost)) {
      showmyModal("Fail", "Total Amount and Shipping Cost must be valid numbers");
      return;
    }

    // Get the part data of the current order and merge the same sparePartNum
    const currentOrderParts = result[index - 1];
    if (!currentOrderParts) {
      break;
    }

    // Integration Orders
    finalOrders.push({
      deliveryAddress,
      dealerID, 
      TotalAmount,
      shipCost,
      time,
      parts: currentOrderParts
    });
    index++;
  }

  if (finalOrders.length === 0) {
    showmyModal("Error", "No valid orders to submit.");
    return;
  }

  try {
    const response = await $.ajax({
      type: "POST",
      url: "./create_order.php",
      dataType: "json",
      data: JSON.stringify(finalOrders),
      contentType: "application/json"
    });

    if (response.order) {
      showmyModal("Success", "All orders placed and carts cleared successfully!", "../../pages/dealer/search_item.php");
    } else {
      showmyModal("Error", "An unexpected error occurred. Check console for details.");
    }
  } catch (error) {
    showmyModal("Fail", error);
  }
}

async function checkStock(result) {
  try {
    const response = await $.ajax({
      type: "POST",
      url: "./check_Stock.php",
      dataType: "json",
      data: JSON.stringify(result),
      contentType: "application/json"
    });

    return response.success;
  } catch (error) {
    return false;
  }
}
