// script.js

// 函数：获取送货费用
function get_delivery_cost(weight, quantity) {
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

$(document).ready(function () {
  let TW = parseFloat($("#totalWeight").attr("total-weight"));
  let TQ = parseInt($("#delivery").attr("total-qty"), 10);
  let ST = parseFloat($("#Total-SAD").attr("subtotal-method"));
  get_delivery_cost(TW, TQ)
    .then(result => {
      console.log('Delivery cost:', result);
      if (result === "Error") {
        document.getElementById("delivery").innerHTML = "Please go to the next page for details";
        document.getElementById("delivery").value = result;
        document.getElementById("Total-SAD").innerHTML = "Unavailable";
      } else {
        // Convert result to a number
        let deliveryCost = parseFloat(result);
        document.getElementById("delivery").innerHTML = "$" + deliveryCost.toFixed(2);

        // Ensure ST is a number and add deliveryCost to it
        ST += deliveryCost;

        document.getElementById("Total-SAD").innerHTML = "$" + ST.toFixed(2);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
});

function decreaseQuantity(id) {
  const input = document.getElementById('form1' + id);
  let currentValue = parseInt(input.value, 10);
  if (currentValue > 1) {
    input.value = currentValue - 1;
    update_qty(id, input.value);
  }
}

function increaseQuantity(id) {
  const input = document.getElementById('form1' + id);
  const max = parseInt(input.max, 10);
  let currentValue = parseInt(input.value, 10);

  if (currentValue < max) {
    input.value = currentValue + 1;
  } else {
    input.value = max;
  }

  update_qty(id, input.value);
}

function update_qty(spnum, qty) {
  $.ajax({
    type: "POST",
    url: "./update_cart.php",
    data: {
      sparePartNum: spnum,
      qty: qty
    },
    success: function (data) {
      location.reload();
    }
  });
}

$(document).ready(function () {
  $('input[type="number"]').on('blur', function () {
    const id = $(this).attr('id').replace('form1', '');
    let qty = parseInt($(this).val(), 10);
    const max = parseInt($(this).attr('max'), 10);

    if (isNaN(qty) || qty < 1) {
      qty = 1;
    } else if (qty > max) {
      qty = max;
    }

    $(this).val(qty);
    update_qty(id, qty);
  });
});

function checkoutTest(totalWeight, qty) {
  var totalWeight = totalWeight;
  var qty = qty;

  var delivery = document.getElementById("delivery").innerHTML;

  if (delivery === "$NaN"||delivery === "") {
    showmyModal('Fail', 'API connect error.');
    return;
  }
  if (totalWeight <= 0) {
    showmyModal('Fail', 'There are no items in the shopping cart.');
    return;
  }

  // if (totalWeight > 70) {
  //   showmyModal('Fail', 'The weight must be less than or equal to 70kg.');
  //   return;
  // }

  if (qty <= 0) {
    showmyModal('Fail', 'There are no items in the shopping cart.');
    return;
  }

  // if (qty > 30) {
  //   showmyModal('Fail', 'The quantity must be less than or equal to 30.');
  //   return;
  // }
  window.location.href = './checkout.php';
  return;
}

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

function deleteitem(id) {
  $.ajax({
    type: "POST",
    url: "./deleteitem_on_cart.php",
    data: {
      sparePartNum: id,
    },
    success: function (data) {
      location.reload();
    }
  });
}