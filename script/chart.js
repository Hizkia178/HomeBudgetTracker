let days = 30;
function fetchChartData(days) {
    const data = {
        labels: [],
        income: [],
        expenses: [],
        budget: [],
        savings: []
    };

    for (let i = 0; i < days; i++) {
        data.labels.push(`Day ${i + 1}`); 
        data.income.push(Math.floor(Math.random() * 1000) + 500);  
        data.expenses.push(Math.floor(Math.random() * 800) + 200);  
        data.budget.push(data.income[i] * 0.8);  
        data.savings.push(data.income[i] - data.expenses[i]); 
    }

    updateChart(data);
}


function updateChart(data) {
    overviewChart.data.labels = data.labels;
    overviewChart.data.datasets[0].data = data.income;
    overviewChart.data.datasets[1].data = data.expenses;
    overviewChart.data.datasets[2].data = data.budget;
    overviewChart.data.datasets[3].data = data.savings;
    overviewChart.update();
}


const ctx = document.getElementById('overviewChart').getContext('2d');
const overviewChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Income',
                data: [],
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Expenses',
                data: [],
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Budget',
                data: [],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Savings',
                data: [],
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                fill: true,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            x: {
                beginAtZero: true
            },
            y: {
                beginAtZero: true
            }
        }
    }
});


fetchChartData(30);


document.getElementById('rangeSelect').addEventListener('change', function (event) {
    const range = parseInt(event.target.value);
    fetchChartData(range);
});