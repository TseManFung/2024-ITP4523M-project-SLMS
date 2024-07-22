// import Chart from 'chart.js/auto'
$(document).ready(function () {
  const c = $("#Chart");
  //const ctx = c[0].getContext("2d");
  if (c.attr("data-type") == "D") {
    ID = c.attr("data-D");
    MultiLineChartForDealer(c, ID);
  } else if (c.attr("data-type") == "S") {
    ID = c.attr("data-S");
    LineChartForASparePart(c, ID);
  } else if (c.attr("data-type") == "N") {
    BarChartForTop10SparePart(c);
  }
});

// chart.js

function removeDollorSign(s) {
  return s.replace("$", "").trim();
}

async function BarChartForTop10SparePart(c) {
  jsonData = getData();

  // Sort jsonData
  jsonData.sort((a, b) => {
    const valueA = parseInt(removeDollorSign(a[6]));
    const valueB = parseInt(removeDollorSign(b[6]));
    return valueB - valueA;
  });

  jsonData = jsonData.slice(0, 10);

  const labels = jsonData.map((item) => {
    let label = item[1];
    if (label.length > 50) {
      label = label.substring(0, 47) + "...";
    }
    return label;
  });
  const data = {
    labels: labels,
    datasets: [
      {
        axis: "y",
        label: "Sales ($)",
        data: jsonData.map((item) => removeDollorSign(item[6])),
        fill: false,
        borderWidth: 1,
      },
    ],
  };
  const config = {
    type: "bar",
    data,
    options: {
      indexAxis: "y",
      plugins: {
        title: {
          display: true,
          text: "Top 10 selling spare parts",
          font: {
            size: 36,
          },
        },
      },
    },
  };
  new Chart(c[0], config);
}

async function LineChartForASparePart(c, sparePartNum) {
  //最近一年的每个月的销售量
  jsonData = await getDatabyID(1, sparePartNum);
  const labels = jsonData.map((item) => item["Month/Year"]);
  const data = {
    labels: labels,
    datasets: [
      {
        label: "Sales Quantity",
        data: jsonData.map((item) => item.Quantity),
        fill: false,
        borderColor: "rgb(75, 192, 192)",
        tension: 0.1,
      },
    ],
  };
  const config = {
    type: "line",
    data,
    options: {
      plugins: {
        title: {
          display: true,
          text: "Sales volume per month in the past year",
          font: {
            size: 36,
          },
        },
      },
    },
  };
  new Chart(c[0], config);
}

async function MultiLineChartForDealer(c, dealerID) {
  //最近一年的每个月的order數量
  jsonData = await getDatabyID(2, dealerID);

  const labels = jsonData.map((item) => item["Month/Year"]);
  const data = {
    labels: labels,
    datasets: [
      {
        label: "Order Count",
        data: jsonData.map((item) => item.Quantity),
        fill: false,
        borderColor: "rgb(75, 192, 192)",
        tension: 0.1,
      },
    ],
  };
  const config = {
    type: "line",
    data,
    options: {
      plugins: {
        title: {
          display: true,
          text: "Number of orders per month in the last year",
          font: {
            size: 36,
          },
        },
      },
    },
  };
  new Chart(c[0], config);
}

function getData() {
  var data = $("#item-report").bootstrapTable("getData", {
    includeHiddenRows: true,
  });
  //return JSON.stringify(data);
  return data;
}
async function getDatabyID(mode, id) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "./report_data.php",
      type: "POST",
      data: {
        mode: mode,
        ID: id,
      },
      success: function (data) {
        const obj = JSON.parse(data);

        const currentDate = new Date();
        const startDate = new Date();
        startDate.setFullYear(startDate.getFullYear() - 1);
        startDate.setMonth(startDate.getMonth() + 1);

        let allMonths = {};
        let current = new Date(startDate);
        while (current <= currentDate) {
          const monthYear =
            (current.getMonth() + 1).toString().padStart(2, "0") +
            "/" +
            current.getFullYear();
          allMonths[monthYear] = 0;
          current.setMonth(current.getMonth() + 1);
        }

        obj.forEach((item) => {
          if (item.hasOwnProperty("SalesQuantity")) {
            allMonths[item["Month/Year"]] = parseInt(item["SalesQuantity"], 10);
          } else if (item.hasOwnProperty("OrderCount")) {
            allMonths[item["Month/Year"]] = parseInt(item["OrderCount"], 10);
          }
        });

        const result = Object.keys(allMonths).map((key) => ({
          "Month/Year": key,
          Quantity: allMonths[key],
        }));

        resolve(result);
      },
      error: function (xhr, status, error) {
        reject(error);
      },
    });
  });
}
