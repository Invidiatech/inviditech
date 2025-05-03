 <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
     document.addEventListener('DOMContentLoaded', function() {
        // Initialize charts
        initCharts();
    });
    
    function initCharts() {
        // Reading Time Chart
        const readingTimeCtx = document.getElementById('readingTimeChart');
        if (readingTimeCtx) {
            new Chart(readingTimeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Morning', 'Afternoon', 'Evening', 'Night'],
                    datasets: [{
                        data: [15, 30, 45, 10],
                        backgroundColor: [
                            '#4299e1',
                            '#38b2ac',
                            '#805ad5',
                            '#2d3748'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        }
        
        // Activity Chart
        const activityChartCtx = document.getElementById('activityChart');
        if (activityChartCtx) {
            new Chart(activityChartCtx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'Comments',
                        data: [5, 10, 8, 15, 12, 9, 12],
                        borderColor: '#3182ce',
                        backgroundColor: 'rgba(49, 130, 206, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Likes',
                        data: [7, 15, 12, 20, 18, 15, 17],
                        borderColor: '#e53e3e',
                        backgroundColor: 'rgba(229, 62, 62, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
  