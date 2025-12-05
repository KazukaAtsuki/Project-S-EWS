@extends('layouts.admin')

@section('title', 'Monitoring Report')

@section('content')

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm samu-page-header">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-2">
                            <div class="samu-icon-header me-3">
                                <i class="bx bx-line-chart"></i>
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold">Monitoring Report</h3>
                                <p class="text-muted mb-0">Real-time analytics & data tracking system</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <button class="btn samu-btn-export">
                            <i class="bx bx-download me-2"></i> Export Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 1. Filter Section (Tetap Rounded) -->
<div class="card border-0 shadow-sm samu-filter-card mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center">
                <div class="samu-icon-sm samu-icon-filter me-2">
                    <i class="bx bx-filter"></i>
                </div>
                <h5 class="mb-0 fw-bold">Filter Data</h5>
            </div>
            <div class="btn-group samu-period-group" role="group">
                <button type="button" class="btn samu-period-btn active period-btn" data-value="today">
                    <i class="bx bx-calendar-alt me-1"></i> Today
                </button>
                <button type="button" class="btn samu-period-btn period-btn" data-value="week">
                    <i class="bx bx-calendar-week me-1"></i> Last Week
                </button>
                <button type="button" class="btn samu-period-btn period-btn" data-value="month">
                    <i class="bx bx-calendar me-1"></i> Last Month
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">
                    <i class="bx bx-layer me-1 text-primary"></i> Stack
                </label>
                <select id="filter_stack" class="form-select samu-select">
                    <option value="">All Stack</option>
                    @foreach($stacks as $stack)
                        <option value="{{ $stack->id }}">{{ $stack->stack_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">
                    <i class="bx bx-slider me-1 text-primary"></i> Parameter
                </label>
                <select id="filter_parameter" class="form-select samu-select">
                    <option value="">All Parameter</option>
                    @foreach($parameters as $param)
                        <option value="{{ $param->id }}">{{ $param->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">
                    <i class="bx bx-calendar-event me-1 text-primary"></i> Date Start
                </label>
                <input type="date" id="date_start" class="form-control samu-input">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">
                    <i class="bx bx-calendar-check me-1 text-primary"></i> Date End
                </label>
                <input type="date" id="date_end" class="form-control samu-input">
            </div>
        </div>
        <div class="mt-4 text-end">
            <button id="btn_apply_filter" class="btn samu-btn-apply px-4">
                <i class="bx bx-filter-alt me-2"></i> Apply Filter
            </button>
        </div>
    </div>
</div>

<!-- 2. Analytics Section (Tetap Rounded) -->
<div class="card border-0 shadow-sm samu-chart-card mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex align-items-center">
            <div class="samu-icon-sm samu-icon-chart me-2">
                <i class="bx bx-bar-chart-alt-2"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold">Analytics Overview</h5>
                <small class="text-muted">Data status distribution visualization</small>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <div style="height: 350px; position: relative;">
            <canvas id="analyticsChart"></canvas>
        </div>
    </div>
</div>

<!-- 3. Data Table Section (MODIFIKASI: NO RADIUS) -->
<div class="card border-0 shadow-sm samu-table-card">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center">
                <div class="samu-icon-sm samu-icon-table me-2">
                    <i class="bx bx-data"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Monitoring Data Logs</h5>
                    <small class="text-muted">Complete tracking records</small>
                </div>
            </div>
            <span class="badge samu-badge-info px-3 py-2">
                <i class="bx bx-time-five me-1"></i> Live Data
            </span>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table samu-table table-hover" id="monitoringTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Stack</th>
                        <th width="15%">Parameter</th>
                        <th width="15%">Time Group</th>
                        <th width="12%">Data Status</th>
                        <th width="10%">Measured</th>
                        <th width="14%">Corrective</th>
                        <th width="14%">Problem</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* ========================================
       SAMU MONITORING REPORT STYLES
       ======================================== */

    :root {
        --samu-gold: #D4A12A;
        --samu-gold-light: #E5B13A;
        --samu-gold-soft: #FFF8E7;
        --samu-blue: #1E6BA8;
        --samu-blue-light: #2874B5;
        --samu-blue-soft: #E8F4FF;
        --samu-cyan: #2EBAC6;
        --samu-cyan-light: #40C4CF;
        --samu-cyan-soft: #E6F9FB;
        --samu-dark: #1a1d2e;
        --samu-gray: #6c757d;
    }

    /* ========================================
       TABLE HEADER STYLING (DIPERBAIKI)
       ======================================== */
    .samu-table thead {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
    }

    .samu-table thead th {
        color: #ffffff !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border: none;
        vertical-align: middle;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    /* [MODIFIKASI] Hapus radius di header table agar kotak */
    .samu-table thead th:first-child {
        border-top-left-radius: 0 !important;
    }

    .samu-table thead th:last-child {
        border-top-right-radius: 0 !important;
    }

    /* ========================================
       FILTER CARD
       ======================================== */
    .samu-filter-card {
        border-radius: 1.25rem !important;
        border: 2px solid #e8ecef;
    }

    .samu-icon-sm {
        width: 40px;
        height: 40px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .samu-icon-filter {
        background: linear-gradient(135deg, var(--samu-gold-soft) 0%, #FFFBF0 100%);
        color: var(--samu-gold);
    }

    /* Period Button Group */
    .samu-period-group {
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .samu-period-btn {
        border: none;
        background: white;
        color: var(--samu-gray);
        font-weight: 600;
        padding: 0.6rem 1.25rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .samu-period-btn:hover {
        background: var(--samu-blue-soft);
        color: var(--samu-blue);
    }

    .samu-period-btn.active {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(30, 107, 168, 0.3);
    }

    /* Form Controls */
    .samu-select, .samu-input {
        border: 2px solid #e8ecef;
        border-radius: 0.75rem;
        padding: 0.65rem 1rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .samu-select:focus, .samu-input:focus {
        border-color: var(--samu-cyan);
        box-shadow: 0 0 0 0.2rem rgba(46, 186, 198, 0.15);
    }

    .samu-btn-apply {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 107, 168, 0.25);
    }

    .samu-btn-apply:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 107, 168, 0.35);
        background: linear-gradient(135deg, var(--samu-cyan) 0%, var(--samu-blue) 100%);
    }

    /* ========================================
       CHART CARD
       ======================================== */
    .samu-chart-card {
        border-radius: 1.25rem !important;
        border: 2px solid #e8ecef;
    }

    .samu-icon-chart {
        background: linear-gradient(135deg, var(--samu-cyan-soft) 0%, #F0FCFD 100%);
        color: var(--samu-cyan);
    }

    /* ========================================
       TABLE CARD (MODIFIKASI: RADIUS 0)
       ======================================== */
    .samu-table-card {
        border-radius: 0 !important; /* UBAH JADI 0 (KOTAK) */
        border: 2px solid #e8ecef;
    }

    .samu-icon-table {
        background: linear-gradient(135deg, var(--samu-blue-soft) 0%, #F0F8FF 100%);
        color: var(--samu-blue);
    }

    .samu-badge-info {
        background: linear-gradient(135deg, var(--samu-cyan) 0%, var(--samu-cyan-light) 100%);
        color: white;
        font-weight: 600;
        border-radius: 50px;
    }

    /* Table Styling */
    .samu-table {
        margin-bottom: 0;
    }

    .samu-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f4f8;
    }

    .samu-table tbody tr:hover {
        background: linear-gradient(135deg, var(--samu-blue-soft) 0%, var(--samu-cyan-soft) 100%);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .samu-table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        font-weight: 500;
        color: var(--samu-dark);
    }

    /* DataTables Custom Styling */
    .dataTables_wrapper .dataTables_length select {
        border: 2px solid #e8ecef;
        border-radius: 0.5rem;
        padding: 0.4rem 0.75rem;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #e8ecef;
        border-radius: 0.5rem;
        padding: 0.4rem 0.75rem;
        margin-left: 0.5rem;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--samu-cyan);
        outline: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%) !important;
        border: none !important;
        color: white !important;
        border-radius: 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--samu-blue-soft) !important;
        border: none !important;
        color: var(--samu-blue) !important;
        border-radius: 0.5rem;
    }

    .dataTables_wrapper .dataTables_info {
        color: var(--samu-gray);
        font-weight: 500;
    }

    /* ========================================
       STATUS BADGES
       ======================================== */
    .badge.badge-abnormal {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
    }
    .badge.badge-overrange {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-blue-light) 100%);
        color: white;
    }
    .badge.badge-not-recorded {
        background: linear-gradient(135deg, var(--samu-gold) 0%, var(--samu-gold-light) 100%);
        color: white;
    }
    .badge.badge-not-sent {
        background: linear-gradient(135deg, var(--samu-cyan) 0%, var(--samu-cyan-light) 100%);
        color: white;
    }
    .badge.badge-normal {
        background: linear-gradient(135deg, #51cf66 0%, #37b24d 100%);
        color: white;
    }

    /* ========================================
       PAGE HEADER (Tetap Rounded)
       ======================================== */
    .samu-page-header {
        border-radius: 1.25rem !important;
        border-left: 5px solid var(--samu-gold);
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }
    .samu-icon-header {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        box-shadow: 0 4px 15px rgba(30, 107, 168, 0.2);
    }
    .samu-btn-export {
        background: linear-gradient(135deg, var(--samu-gold) 0%, var(--samu-gold-light) 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.65rem 1.5rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(212, 161, 42, 0.25);
    }
    .samu-btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 161, 42, 0.35);
        color: white;
    }

    /* ========================================
       ACTIVE STATE (Efek Tekan)
       ======================================== */
    .samu-btn-export:active,
    .samu-btn-apply:active {
        transform: translateY(0) scale(0.95) !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        transition: all 0.1s;
    }
    .samu-period-btn:active {
        background-color: var(--samu-blue-soft);
        transform: scale(0.95);
    }
    .samu-table tbody tr:active {
        background-color: var(--samu-cyan-soft) !important;
        transform: scale(0.99);
    }

    /* ========================================
       LOADING ANIMATION
       ======================================== */
    .samu-loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

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
        ],
        language: {
            processing: '<div class="samu-loading"></div>',
            search: '<i class="bx bx-search"></i>',
            lengthMenu: '_MENU_ per page',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: {
                first: '<i class="bx bx-chevrons-left"></i>',
                last: '<i class="bx bx-chevrons-right"></i>',
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        }
    });

    // 2. Initialize Chart with SAMU Colors
    var ctx = document.getElementById('analyticsChart').getContext('2d');
    var analyticsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Abnormal', 'Overrange', 'Not Recorded', 'Not Sent'],
            datasets: [{
                label: 'Total Data',
                data: [0, 0, 0, 0],
                backgroundColor: [
                    'rgba(255, 107, 107, 0.85)',  // Abnormal (Merah)
                    'rgba(40, 116, 181, 0.85)',   // Overrange (SAMU Blue)
                    'rgba(229, 177, 58, 0.85)',   // Not Recorded (SAMU Gold)
                    'rgba(64, 196, 207, 0.85)'    // Not Sent (SAMU Cyan)
                ],
                borderColor: [
                    'rgb(255, 107, 107)',
                    'rgb(30, 107, 168)',
                    'rgb(212, 161, 42)',
                    'rgb(46, 186, 198)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                barThickness: 60
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(26, 29, 46, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#40C4CF',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y + ' records';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6c757d',
                        font: {
                            weight: 600
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#1a1d2e',
                        font: {
                            weight: 600,
                            size: 12
                        }
                    }
                }
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
                analyticsChart.update('active');
            }
        });
    }

    // Load initial chart data
    loadChartData();

    // 3. Handle Filter Button with Animation
    $('#btn_apply_filter').click(function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        // Loading state
        $btn.prop('disabled', true).html('<span class="samu-loading"></span> Filtering...');

        currentPeriod = '';
        $('.period-btn').removeClass('active');

        setTimeout(function() {
            table.draw();
            loadChartData();

            // Reset button
            $btn.prop('disabled', false).html(originalHtml);
        }, 500);
    });

    // 4. Handle Period Buttons
    $('.period-btn').click(function() {
        $('.period-btn').removeClass('active');
        $(this).addClass('active');

        currentPeriod = $(this).data('value');
        $('#date_start').val('');
        $('#date_end').val('');

        table.draw();
        loadChartData();
    });

    // 5. Export Button (placeholder)
    $('.samu-btn-export').click(function() {
        var $btn = $(this);
        var originalHtml = $btn.html();

        $btn.prop('disabled', true).html('<span class="samu-loading"></span> Exporting...');

        setTimeout(function() {
            alert('📊 Export feature coming soon!');
            $btn.prop('disabled', false).html(originalHtml);
        }, 1000);
    });
});
</script>
@endpush