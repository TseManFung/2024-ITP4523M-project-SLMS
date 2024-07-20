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

function removeDollorSign(s){
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
    },
  };
  new Chart(c[0], config);
}

async function LineChartForASparePart(c, sparePartNum) {
  //最近一年的每个月的销售量
  /* new Chart(c[0],{
    type: 'line',
    data: {
        labels: "123",
        datasets: [{
          label: 'My First Dataset',
          data: getData(),
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1
        }]
      },
  }) */
  /* const config = 
  const labels = Utils.months({count: 12});
const  */
}

async function MultiLineChartForDealer(c, dealerID) {}

function getData() {
  var data = $("#item-report").bootstrapTable("getData", {
    includeHiddenRows: true,
  });
  //return JSON.stringify(data);
  return data;
}
