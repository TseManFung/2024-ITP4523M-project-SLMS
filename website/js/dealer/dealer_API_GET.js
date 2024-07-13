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
        document.getElementById("delivery").innerHTML = "Order Rejected, too heavy or too many items";
        document.getElementById("delivery").value = result;
        document.getElementById("Total-SAD").innerHTML = "Rejected";
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
  if (input.value > 1) {
    input.stepDown();
    update_qty(id,input.value);
  }
}

function increaseQuantity(id) {
  const input = document.getElementById('form1' + id);
  input.stepUp();
  update_qty(id,input.value);
}

function update_qty(spnum,qty) {
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