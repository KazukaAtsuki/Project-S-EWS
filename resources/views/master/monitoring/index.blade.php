@extends('layouts.admin')

@section('title', 'Monitoring Report')

@section('content')
<!-- 1. Filter Section -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Filter Data</h5>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary btn-sm period-btn active" data-value="today">Today</button>
            <button type="button" class="btn btn-outline-primary btn-sm period-btn" data-value="week">Last Week</button>
            <button type="button" class="btn btn-outline-primary btn-sm period-btn" data-value="month">Last Month</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Stack</label>
                <select id="filter_stack" class="form-select">
                    <option value="">All Stack</option>
                    @foreach($stacks as $stack)
                        <option value="{{ $stack->id }}">{{ $stack->stack_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Parameter</label>
                <select id="filter_parameter" class="form-select">
                    <option value="">All Parameter</option>
                    @foreach($parameters as $param)
                        <option value="{{ $param->id }}">{{ $param->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date Start</label>
                <input type="date" id="date_start" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date End</label>
                <input type="date" id="date_end" class="form-control">
            </div>
        </div>
        <div class="mt-3 text-end">
            <button id="btn_apply_filter" class="btn btn-primary">
                <i class="bx bx-filter-alt me-1"></i> Apply Filter
            </button>
        </div>
    </div>
</div>

<!-- 2. Analytics Section (Chart) -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Analytics</h5>
    </div>
    <div class="card-body">
        <div style="height: 300px;">
            <canvas id="analyticsChart"></canvas>
        </div>
    </div>
</div>

<!-- 3. Data Table Section -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Monitoring Data Logs</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="monitoringTable" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Stack</th>
                        <th>Parameter</th>
                        <th>Time Group</th>
                        <th>Data Status</th>
                        <th>Measured</th>
                        <th>Corrective</th>
                        <th>Problem</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    let currentPeriod = 'today';

    // 1. Initialize DataTable
    var table = $('#monitoringTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('monitoring.data') }}",
            data: function (d) {
                d.stack_id = $('#filter_stack').val();
                d.parameter_id = $('#filter_parameter').val();
                d.start_date = $('#date_start').val();
                d.end_date = $('#date_end').val();
                d.period = currentPeriod;
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'stack_name', name: 'stack.stack_name' },
            { data: 'parameter_name', name: 'parameter.name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'data_status', name: 'data_status' },
            { data: 'measured', name: 'value' },
            { data: 'corrective', name: 'corrective', orderable: false },
            { data: 'problem', name: 'problem', orderable: false },
        ]
    });

    // 2. Initialize Chart
    var ctx = document.getElementById('analyticsChart').getContext('2d');
    var analyticsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Abnormal', 'Overrange', 'Not Recorded', 'Not Sent'],
            datasets: [{
                label: 'Total Data',
                data: [0, 0, 0, 0], // Default 0, nanti diupdate ajax
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)', // Abnormal (Merah)
                    'rgba(54, 162, 235, 0.7)', // Overrange (Biru)
                    'rgba(255, 206, 86, 0.7)', // Not Recorded (Kuning)
                    'rgba(75, 192, 192, 0.7)'  // Not Sent (Hijau)
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Function to load chart data
    function loadChartData() {
        $.ajax({
            url: "{{ route('monitoring.chart') }}",
            data: {
                stack_id: $('#filter_stack').val(),
                parameter_id: $('#filter_parameter').val(),
                start_date: $('#date_start').val(),
                end_date: $('#date_end').val(),
                period: currentPeriod
            },
            success: function(response) {
                analyticsChart.data.datasets[0].data = [
                    response.abnormal,
                    response.overrange,
                    response.not_recorded,
                    response.not_sent
                ];
                analyticsChart.update();
            }
        });
    }

    // Load initial chart data
    loadChartData();

    // 3. Handle Filter Button
    $('#btn_apply_filter').click(function() {
        currentPeriod = ''; // Reset period jika manual filter dipakai
        $('.period-btn').removeClass('active');

        table.draw(); // Refresh Table
        loadChartData(); // Refresh Chart
    });

    // 4. Handle Period Buttons (Today, Week, Month)
    $('.period-btn').click(function() {
        $('.period-btn').removeClass('active');
        $(this).addClass('active');

        currentPeriod = $(this).data('value');
        // Reset manual date inputs
        $('#date_start').val('');
        $('#date_end').val('');

        table.draw();
        loadChartData();
    });
});
</script>
@endpush