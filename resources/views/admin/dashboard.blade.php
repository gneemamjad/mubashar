@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <!-- Payment Status Chart -->
        <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h3 class="card-title fw-bold">{{ __('admin.mainPage.payment_status') }}</h3>
                </div>
                <div class="card-body p-4">
                    <div style="height: 400px;"> <!-- Fixed height container -->
                        <canvas id="paymentStatusChart"></canvas>
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
    // Get the canvas element
    const ctx = document.getElementById('paymentStatusChart').getContext('2d');

    // Define custom colors
    const colors = {
        paid: '#e5a924',     // Gold color
        notPaid: '#07456b'   // Navy blue color
    };

    // Get current locale
    const currentLocale = document.documentElement.lang;

    // Define translations
    const translations = {
        paid: {
            en: 'Paid',
            ar: 'مدفوع'
        },
        notPaid: {
            en: 'Not Paid',
            ar: 'غير مدفوع'
        },
        chartTitle: {
            en: 'Payment Status Distribution (Approved Ads)',
            ar: 'توزع الاعلانات المدفوعة (الإعلانات المقبولة)'
        }
    };

    // Fetch data from the server
    fetch('/admin/dashboard/payment-stats')
        .then(response => response.json())
        .then(data => {
            // Create the doughnut chart
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [
                        translations.paid[currentLocale],
                        translations.notPaid[currentLocale]
                    ],
                    datasets: [{
                        data: [data.paid_count, data.unpaid_count],
                        backgroundColor: [
                            colors.paid,
                            colors.notPaid
                        ],
                        borderColor: [
                            colors.paid,
                            colors.notPaid
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
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
                            text: translations.chartTitle[currentLocale],
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
        .catch(error => console.error('Error loading chart data:', error));
});
</script>
@endsection
