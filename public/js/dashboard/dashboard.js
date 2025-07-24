document.addEventListener("DOMContentLoaded", function () {
    // Change the color of the total stock number to blue
    var totalStockElement = document.querySelector(".total-stock-number");
    if (totalStockElement) {
        totalStockElement.style.color = "blue";
    }

    var options = {
        chart: {
            type: 'pie',
            height: 200
        },
        labels: ['In Stock', 'Out of Stock'],
        series: [
            parseInt(document.getElementById("totalStocks").value) - parseInt(document.getElementById("inStock").value),
            parseInt(document.getElementById("inStock").value)
        ],
        colors: ['#10c469', '#f1556c'],
        legend: {
            position: 'bottom'
        }
    };

    var chart = new ApexCharts(document.querySelector("#stock-pie-chart"), options);
    chart.render();
});




document.addEventListener("DOMContentLoaded", function () {
    const chartEl = document.querySelector("#chart");

    const totalRequests = parseInt(chartEl.dataset.request);
    const totalPending = parseInt(chartEl.dataset.pending);
    const totalApproved = parseInt(chartEl.dataset.approved);
    const totalRejected = parseInt(chartEl.dataset.rejected);

    const options = {
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false }
        },
        series: [{
            name: 'Requests',
            data: [totalRequests, totalPending, totalApproved, totalRejected]
        }],
        xaxis: {
            categories: ['Request','Pending', 'Approved', 'Rejected']
        },
        colors: ['#10c469','#FFFF00', '#CCCCFF', '#f1556c'], // Yellow, Green, Red
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                endingShape: 'rounded',
                distributed: true // 🔥 Important: enables per-bar color
            }
        },
        dataLabels: {
            enabled: true
        },
        legend: {
            show: false // Optional: hides legend since each bar is separate
        }
    };

    const chart = new ApexCharts(chartEl, options);
    chart.render();
});
