function renderAttendanceChart(data) {
    const options = {
        series: [
            { name: "Attendances", type: "area", data: data.attendances },
            { name: "Late", type: "area", data: data.lates },
        ],
        chart: {
            height: 313,
            type: "line",
            toolbar: { show: false },
        },
        stroke: { curve: "smooth", width: 2 },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
                stops: [0, 90, 100],
            },
        },
        xaxis: {
            categories: data.labels,
            axisTicks: { show: false },
            axisBorder: { show: false },
        },
        colors: ["#405568", "#1bb394"],
        tooltip: {
            shared: true,
            y: [
                {
                    formatter: (val) => val + " hadir",
                },
                {
                    formatter: (val) => val + " terlambat",
                },
            ],
        },
        legend: {
            show: true,
            position: "top",
        },
    };

    const chart = new ApexCharts(
        document.querySelector("#dash-performance-chart"),
        options
    );
    chart.render();
}

renderAttendanceChart(attendanceData);

// Range button handler
document.querySelectorAll("#chart-filter-buttons button").forEach((btn) => {
    btn.addEventListener("click", function () {
        const range = this.dataset.range;
        window.location.href = `/?range=${range}`;
    });
});

