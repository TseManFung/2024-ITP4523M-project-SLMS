function get_delivery_cost(weight, quantity) {
  $.ajax({
    url: `http://127.0.0.1:8080/ship_cost_api/quantity/${quantity}`,
    success: function (data) {
      if (data.result == "rejected") {
        return data.reason;
      } else if (data.result == "accepted") {
        quantityCost = data.cost;
        $.ajax({
          url: `http://127.0.0.1:8080/ship_cost_api/weight/${weight}`,
          success: function (data) {
            if (data.result == "rejected") {
              return data.reason;
            } else if (data.result == "accepted") {
              return Math.max(data.cost, quantityCost);
            } else {
              return "Error";
            }
          },

          error: function (data) {
            return data;
          },
        });
      } else {
        return "Error";
      }
    },

    error: function (data) {
      return data;
    },
  });
}
