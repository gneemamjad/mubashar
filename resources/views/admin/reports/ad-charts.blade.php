@extends('layouts.main')
<style>
    .chart-row {
        display: flex;
        gap: 20px; /* space between charts */
        justify-content: center; /* center charts horizontally */
        flex-wrap: wrap; /* allow wrapping on small screens */
    }

    .chart-container {
        width: 45%; /* adjust width as needed */
        min-width: 300px; /* prevents it from getting too small */
    }
    .chart-container canvas {
        width: 100%;
        height: auto;
    }
</style>
@section('content')
<div class="container-fluid">
    <!-- Status Trends Chart -->
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold">{{ __('admin.ad_status_trends') }}</h3>

                    <!-- Date Range Filter -->
                    <div class="d-flex align-items-center gap-2">
                        <input type="date" id="startDate" class="input input-sm" style="display: inline; width: 40%;" />
                        <input type="date" id="endDate" class="input input-sm" style="display: inline; width: 40%;" />
                        <button id="filterBtn" class="btn btn-sm btn-primary">{{ __('admin.filter') }}</button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="height: 400px;">
                        <canvas id="adStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Distribution Chart -->
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold">{{ __('admin.ad_distribution_by_category') }}</h3>

                    <!-- Month Year Filter -->
                    <div class="d-flex align-items-center gap-2">
                        <input type="month" id="monthFilter" class="input input-sm " style="display: inline; width: 50%;" />
                        <button id="categoryFilterBtn" class="btn btn-sm btn-primary">{{ __('admin.filter') }}</button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="height: 400px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Added By and Approved By Chart -->
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold">{{ __('admin.ad_added_approved_trends') }}</h3>

                    <!-- Date Range Filter -->
                    <div class="d-flex align-items-center gap-2">
                        <input type="date" id="startDateApproved" class="input input-sm" style="display: inline; width: 40%;" />
                        <input type="date" id="endDateApproved" class="input input-sm" style="display: inline; width: 40%;" />
                        <button id="filterBtnApproved" class="btn btn-sm btn-primary">{{ __('admin.filter') }}</button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div>
                        <div class="chart-row">
                            <div class="chart-container">
                                <canvas id="adAddedChart"></canvas>
                            </div>
                            <div class="chart-container">
                                <canvas id="adApprovedChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // First Chart Code (existing)
    const statusCtx = document.getElementById('adStatusChart').getContext('2d');
    let statusChart;
    
    const addedCtx = document.getElementById('adAddedChart').getContext('2d');
    let addedChart;
    const approvedCtx = document.getElementById('adApprovedChart').getContext('2d');
    let approvedChart;

    // Second Chart Context
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    let categoryChart;

    // Colors
    const colors = {
        approvedRealEstate: '#4caf50',
        pendingRealEstate:  '#2196f3',
        rejectedRealEstate: '#f44336',
        approvedCar: '#e5a924',
        pendingCar:  '#07456b',
        rejectedCar: '#dc3545'
    };

    // Set default dates for status chart (last 2 months)
    const endDate = new Date();
    const startDate = new Date();
    startDate.setMonth(startDate.getMonth() - 2);

    document.getElementById('startDate').value = startDate.toISOString().split('T')[0];
    document.getElementById('endDate').value = endDate.toISOString().split('T')[0];

    // Set default month for category chart (1 year view)
    const defaultMonth = new Date();
    document.getElementById('monthFilter').value = defaultMonth.toISOString().slice(0, 7);

    // Set default dates for status chart (last 2 months)
    const endDateApproved = new Date();
    const startDateApproved = new Date();
    startDate.setMonth(startDate.getMonth() - 2);

    document.getElementById('startDateApproved').value = endDateApproved.toISOString().split('T')[0];
    document.getElementById('endDateApproved').value = startDateApproved.toISOString().split('T')[0];

    // Load Status Chart Data (existing function)
    function loadChartData(start, end) {
        fetch(`/admin/reports/ad-charts/data?start=${start}&end=${end}`)
            .then(response => response.json())
            .then(data => {
                if (statusChart) {
                    statusChart.destroy();
                }

                statusChart = new Chart(statusCtx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Realestates | Approved / موافق عليه',
                                data: data.approvedRealEstate,
                                borderColor: colors.approvedRealEstate,
                                backgroundColor: colors.approvedRealEstate + '20',
                                tension: 0.4
                            },
                            {
                                label: 'Realestates | Pending / قيد الانتظار',
                                data: data.pendingRealEstate,
                                borderColor: colors.pendingRealEstate,
                                backgroundColor: colors.pendingRealEstate + '20',
                                tension: 0.4
                            },
                            {
                                label: 'Realestates | Rejected / مرفوض',
                                data: data.rejectedRealEstate,
                                borderColor: colors.rejectedRealEstate,
                                backgroundColor: colors.rejectedRealEstate + '20',
                                tension: 0.4
                            },
                            {
                                label: 'Cars | Approved / موافق عليه',
                                data: data.approvedCar,
                                borderColor: colors.approvedCar,
                                backgroundColor: colors.approvedCar + '20',
                                tension: 0.4
                            },
                            {
                                label: 'Cars | Pending / قيد الانتظار',
                                data: data.pendingCar,
                                borderColor: colors.pendingCar,
                                backgroundColor: colors.pendingCar + '20',
                                tension: 0.4
                            },
                            {
                                label: 'Cars | Rejected / مرفوض',
                                data: data.rejectedCar,
                                borderColor: colors.rejectedCar,
                                backgroundColor: colors.rejectedCar + '20',
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 14
                                    },
                                    color: '#07456b'
                                }
                            },
                            title: {
                                display: true,
                                text: '{{ __("admin.daily_ad_status_distribution") }}',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 30
                                },
                                color: '#07456b'
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
            })
            .catch(error => console.error('Error loading chart data / خطأ في تحميل بيانات المخطط:', error));
    }

    function loadApprovedChartData(start, end) {
        fetch(`/admin/reports/ad-charts/data-approved?start=${start}&end=${end}`)
            .then(response => response.json())
            .then(data => {
                if (addedChart) {
                    addedChart.destroy();
                }
                if (approvedChart) {
                    approvedChart.destroy();
                }

                const addedLabels = data.dataAdded.map(item => item.name);
                const addedCounts = data.dataAdded.map(item => item.count);

                const approvedLabels = data.dataApproved.map(item => item.name);
                const approvedCounts = data.dataApproved.map(item => item.count);

                addedChart = new Chart(addedCtx, {
                    type: 'doughnut',
                    data: {
                        labels: addedLabels,
                        datasets: [{
                            label: 'Added Ads',
                            data: addedCounts,
                            backgroundColor: ['#e5a924', '#07456b', '#36b9cc'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 14
                                    },
                                    color: '#07456b'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Added Ads Distribution',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 30
                                },
                                color: '#07456b'
                            }
                        }
                    }
                });

                approvedChart = new Chart(approvedCtx, {
                    type: 'doughnut',
                    data: {
                        labels: approvedLabels,
                        datasets: [{
                            label: 'Approved Ads',
                            data: approvedCounts,
                            backgroundColor: ['#e5a924', '#07456b', '#36b9cc'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 14
                                    },
                                    color: '#07456b'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Approved Ads Ads Distribution',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 30
                                },
                                color: '#07456b'
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error loading chart data / خطأ في تحميل بيانات المخطط:', error));
    }

    // Load Category Chart Data
    function loadCategoryData(monthYear) {
        fetch(`/admin/reports/ad-charts/category-data?month_year=${monthYear}`)
            .then(response => response.json())
            .then(data => {
                if (categoryChart) {
                    categoryChart.destroy();
                }

                categoryChart = new Chart(categoryCtx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14
                                    },
                                    color: '#07456b'
                                }
                            },
                            title: {
                                display: true,
                                text: '{{ __("admin.monthly_ad_distribution_by_category") }}',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                color: '#07456b'
                            }
                        },
                        scales: {
                            x: {
                                stacked: false,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                },
                                grid: {
                                    borderDash: [2, 4]
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error loading category data / خطأ في تحميل بيانات الفئات:', error));
    }

    // Initial loads
    loadChartData(
        document.getElementById('startDate').value,
        document.getElementById('endDate').value
    );
    loadCategoryData(document.getElementById('monthFilter').value);
    loadApprovedChartData(
        document.getElementById('startDateApproved').value,
        document.getElementById('endDateApproved').value
    );

    // Event listeners
    document.getElementById('filterBtn').addEventListener('click', function() {
        loadChartData(
            document.getElementById('startDate').value,
            document.getElementById('endDate').value
        );
    });

    // Event listeners
    document.getElementById('filterBtnApproved').addEventListener('click', function() {
        loadApprovedChartData(
            document.getElementById('startDateApproved').value,
            document.getElementById('endDateApproved').value
        );
    });
    
    document.getElementById('categoryFilterBtn').addEventListener('click', function() {
        loadCategoryData(document.getElementById('monthFilter').value);
    });
});
</script>
@endsection
