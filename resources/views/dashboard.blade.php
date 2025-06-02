@extends('layouts.app')

@section('content')
<div class="container">

    <h2>月別支出の棒グラフ</h2>
    <canvas id="monthlyChart" width="400" height="200"></canvas>

    <h2 class="mt-4">収支一覧（直近30件）</h2>
    <table class="table">
        <thead><tr><th>日付</th><th>種別</th><th>カテゴリ</th><th>金額</th><th>メモ</th></tr></thead>
        <tbody>
            @foreach($transactions as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->type === '支出' ? '-' : '+' }}¥{{ number_format($item->amount) }}</td>
                    <td>{{ $item->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyExpenses->pluck('month')) !!},
            datasets: [{
                label: '月別総支出（円）',
                data: {!! json_encode($monthlyExpenses->pluck('total')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '¥' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection