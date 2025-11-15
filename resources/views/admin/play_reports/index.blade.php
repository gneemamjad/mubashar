@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h3>Google Play Reports</h3>
    <button id="fetchReports" class="btn btn-primary mb-3">تحديث البيانات</button>

    <div>
        <canvas id="installsChart" height="100"></canvas>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>المصدر</th>
                <th>عدد المستخدمين الجدد</th>
                <th>نسبة التحويل</th>
            </tr>
        </thead>
        <tbody id="acquisitionTable"></tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.getElementById('fetchReports').addEventListener('click', async () => {
    const res = await fetch('/admin/play-reports/fetch');
    const data = await res.json();

    // رسم البيانات (أمثلة وهمية)
    const ctx = document.getElementById('installsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr'],
            datasets: [{
                label: 'Installs',
                data: [500, 700, 1200, 900],
                borderWidth: 2
            }]
        }
    });

    // تعبئة جدول الاكتساب (أمثلة)
    const table = document.getElementById('acquisitionTable');
    table.innerHTML = `
        <tr><td>Organic</td><td>1200</td><td>45%</td></tr>
        <tr><td>Ads</td><td>500</td><td>20%</td></tr>
    `;
});
</script>
@endsection
