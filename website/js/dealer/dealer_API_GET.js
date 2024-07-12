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
  let TW = $("#totalWeight").attr("total-weight");
  let TQ = $("#delivery").attr("total-qty");
  console.log(TW);
  get_delivery_cost(TW, TQ)
      .then(result => {
          console.log('Delivery cost:', result);
          if(result==="Error"){
            document.getElementById("delivery").innerHTML = "Order Rejected, too heavy or too many items";
          }else{
            document.getElementById("delivery").innerHTML = "$" + result;
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
});