@extends('layouts.app')

@section('content')
<div class="container py-4" style="font-family: 'Helvetica Neue', sans-serif; max-width: 1000px; margin: 0 auto;">

    <style>
    .design10 {
        width: 100%;
        text-align: center;
        border-collapse: collapse;
        border-spacing: 0;
        margin-top: 1rem;
        background-color: #fff;
    }
    .design10 th {
        padding: 10px;
        border-bottom: solid 4px #778ca3;
        color: #778ca3;
        font-weight: 600;
    }
    .design10 td {
        padding: 10px;
        border-bottom: solid 1px #778ca3;
        color: #333;
    }
    .top-tabs {
        position: fixed; left: 220px; right: 0; top: 0;
        height: 50px; background-color: #e7ecec;
        display: flex; align-items: center;
        padding: 0 24px; border-bottom: 1px solid #ccc;
        z-index: 1000; transition: left 0.3s ease;
    }
    .top-tabs.collapsed { left: 50px; }
    .top-tabs button {
        background: none; border: none; font-size: 15px;
        color: #333; margin-right: 20px; cursor: pointer;
        padding: 4px 8px;
    }
    .top-tabs button:hover {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 3px;
    }
    .main-content {
        margin-left: 220px; padding: 80px 24px 24px 24px;
        min-height: 100vh; transition: margin-left 0.3s ease;
    }
    .main-content.collapsed {
        margin-left: 50px;
    }

    .tab-button.active {
        font-weight: bold;
        border-bottom: 2px solid #333;
    }
    .hidden { display: none; }

</style>

<div class="top-tabs" id="topTabs">
    <button class="tab-button active" data-tab="pie">カテゴリー別割合</button>
    <button class="tab-button" data-tab="bar">年間レポート</button>
</div>

<!-- 今月のカテゴリ別支出割合 -->
<div id="pieTab" class="tab-content">
    <h2 class="mb-4 text-center" style="font-weight: 600; color: #333;">今月のカテゴリ別支出割合</h2>
    <canvas id="categoryPieChart" height="100" class="mb-5"></canvas>
</div>

<!-- 月別支出の推移 -->
<div id="barTab" class="tab-content hidden">
    <h2 class="mb-4 text-center" style="font-weight: 600; color: #333;">月別支出の推移</h2>
    <canvas id="monthlyChart" height="100" class="mb-5"></canvas>
</div>

<h2 class="mt-5 mb-3 text-center" style="font-weight: 600; color: #333;">収支一覧（直近30件）</h2>

<div class="table-responsive">
    <table class="design10 mx-auto">
        <thead>
            <tr>
                <th>日付</th>
                <th>種別</th>
                <th>カテゴリ</th>
                <th>金額</th>
                <th>メモ</th>
            </tr>
        </thead>
        <tbody>
            @php $currentMonth = null; @endphp
            @foreach($transactions as $item)
                @php
                    $month = \Carbon\Carbon::parse($item->date)->format('Y年m月');
                    $date = \Carbon\Carbon::parse($item->date)->format('m/d');
                @endphp
                <tr>
                    <td>{{ $date }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->category }}</td>
                    <td style="color: {{ $item->type === '支出' ? '#8B0000' : '#006666' }}">
                        {{ $item->type === '支出' ? '-' : '+' }}¥{{ number_format($item->amount) }}
                    </td>
                    <td>{{ $item->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0 "></script>
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');

    // 12ヶ月分の空データベース
    const months = [...Array(12)].map((_, i) => {
        const d = new Date();
        d.setMonth(d.getMonth() - (11 - i));
        return d.toISOString().slice(0, 7); // YYYY-MM
    });

    const dataFromServer = {!! json_encode($monthlyExpenses->pluck('total', 'month')) !!};
    const data = months.map(m => dataFromServer[m] ?? 0);

    const monthlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: '月別総支出（円）',
                data: data,
                fill: false,
                borderColor: 'rgba(0, 150, 150, 0.8)',
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#333'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#555'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#555',
                        callback: function(value) {
                            return '¥' + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: '#eee'
                    }
                }
            }
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.getElementById('sidebar');
        const topTabs = document.getElementById('topTabs');
        const mainContent = document.getElementById('mainContent');
        const icon = document.getElementById('toggleIcon');

        // 初期状態の読み込み
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            topTabs.classList.add('collapsed');
            mainContent.classList.add('collapsed');
            icon.classList.remove('fa-angle-double-left');
            icon.classList.add('fa-angle-double-right');
        }

        // トグル機能
        window.toggleSidebar = () => {
            sidebar.classList.toggle('collapsed');
            topTabs.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');

            const collapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', collapsed);

            if (collapsed) {
                icon.classList.remove('fa-angle-double-left');
                icon.classList.add('fa-angle-double-right');
            } else {
                icon.classList.remove('fa-angle-double-right');
                icon.classList.add('fa-angle-double-left');
            }
        };
    });
</script>

<script>
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', () => {
        // 全ボタンのactiveクラスを外す
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // すべてのタブを非表示にし、選択されたタブだけ表示
        const selected = button.dataset.tab;
        document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
        document.getElementById(selected + 'Tab').classList.remove('hidden');
    });
});

</script>

<script>
    // 円グラフ（カテゴリ別）
    const pieCtx = document.getElementById('categoryPieChart').getContext('2d');
    const categoryLabels = {!! json_encode($categoryExpenses->keys()) !!};
    const categoryData = {!! json_encode($categoryExpenses->values()) !!};

    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'カテゴリ別支出',
                data: categoryData,
                backgroundColor: categoryLabels.map(() =>
                    `rgba(${Math.floor(Math.random()*255)},${Math.floor(Math.random()*255)},${Math.floor(Math.random()*255)},0.6)`
                ),
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        
        options: {
            plugins: {
                tooltip: {
                    enabled: false
                },
                datalabels: {
                    color:"#fff",
                    font: {
                        size: 30
                    },
                    formatter: function( value, context ) {
                        return value.toString() + '円';
                    }
                }
            }
        },
        plugins: [
            ChartDataLabels,
        ],
    });
</script>


@endsection