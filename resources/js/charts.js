import Chart from 'chart.js/auto';

window.initCharts = function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueData = JSON.parse(revenueCtx.dataset.chartData || '[]');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(d => d.date),
                datasets: [{
                    label: 'Revenue (₦)',
                    data: revenueData.map(d => d.revenue / 100),
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₦' + context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₦' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // Orders Chart
    const ordersCtx = document.getElementById('ordersChart');
    if (ordersCtx) {
        const ordersData = JSON.parse(ordersCtx.dataset.chartData || '[]');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ordersData.map(d => d.date),
                datasets: [{
                    label: 'Orders',
                    data: ordersData.map(d => d.count),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Revenue vs Expenses Chart
    const revenueExpensesCtx = document.getElementById('revenueExpensesChart');
    if (revenueExpensesCtx) {
        const revenueData = JSON.parse(revenueExpensesCtx.dataset.revenueData || '[]');
        const expensesData = JSON.parse(revenueExpensesCtx.dataset.expensesData || '[]');
        
        // Combine dates
        const allDates = [...new Set([...revenueData.map(d => d.date), ...expensesData.map(d => d.date)])].sort();
        
        new Chart(revenueExpensesCtx, {
            type: 'line',
            data: {
                labels: allDates,
                datasets: [
                    {
                        label: 'Revenue (₦)',
                        data: allDates.map(date => {
                            const item = revenueData.find(d => d.date === date);
                            return item ? item.revenue / 100 : 0;
                        }),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Expenses (₦)',
                        data: allDates.map(date => {
                            const item = expensesData.find(d => d.date === date);
                            return item ? item.expenses / 100 : 0;
                        }),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₦' + context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₦' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // Payment Methods Chart
    const paymentMethodsCtx = document.getElementById('paymentMethodsChart');
    if (paymentMethodsCtx) {
        const paymentData = JSON.parse(paymentMethodsCtx.dataset.chartData || '[]');
        new Chart(paymentMethodsCtx, {
            type: 'doughnut',
            data: {
                labels: paymentData.map(d => d.method.charAt(0).toUpperCase() + d.method.slice(1).replace('_', ' ')),
                datasets: [{
                    data: paymentData.map(d => d.total / 100),
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ₦' + context.parsed.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                        }
                    }
                }
            }
        });
    }
};

