<div class="row">
  <div class="col-md-4 col-12">
    <div class="box box-default">
      <div class="box-body">
        <h5 class="text-center text-tag text-bold">会員登録数</h5>
        <p class="text-center text-bold tag-count">{{ $users }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-12">
    <div class="box box-default">
      <div class="box-body">
        <h5 class="text-center text-tag text-bold">累計お問合せ件数</h5>
        <p class="text-center text-bold tag-count">{{ $contacts }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-12">
    <div class="box box-default">
      <div class="box-body">
        <h5 class="text-center text-tag text-bold">掲載案件件数</h5>
        <p class="text-center text-bold tag-count">{{ $items }}</p>
      </div>
    </div>
  </div>
</div>

<div class="box box-default">
  <div class="box-body">
    <h4 class="text-bold" style="padding: 0 8px;">最近30日間のアクセス</h4>

    <div class="tab" style="padding: 0 8px;">
      <div class="tab-item {{ !request()->has('type') || request()->has('type') && request()->get('type') == 'pv' ? 'active' : '' }}">
        <a href="{{ route(config('admin.route.prefix') . '.admin.dashboard', ['type' => 'pv']) }}">PV</a>
      </div>
      <div class="tab-item {{ request()->has('type') && request()->get('type') == 'uu' ? 'active' : '' }}">
        <a href="{{ route(config('admin.route.prefix') . '.admin.dashboard', ['type' => 'uu']) }}">UU</a>
      </div>
      <div class="tab-item {{ request()->has('type') && request()->get('type') == 'session' ? 'active' : '' }}">
        <a href="{{ route(config('admin.route.prefix') . '.admin.dashboard', ['type' => 'session']) }}">セッション</a>
      </div>
    </div>

    <div class="chart">
      <div class="chart-title">
        合計<span class="text-bold total-count">{{ number_format($totalCount) }}</span><span class="text-bold">{{ $titleType }}</span>
      </div>
      <p class="chart-period">集計期間 {{ $chartPeriod }}</p>
      <div class="chart-graph" style="height: 400px;">
          <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-body">
        <h4 class="text-bold" style="padding: 0 8px;">運営からのお知らせ</h4>

        @if ($notifications->count() > 0)
        <table class="table table-hover grid-table">
          <tbody>
            @foreach ($notifications as $notification)
            <tr class="cursor-pointer border-bottom last-no-border">
              <td>
                <a class="d-block w-full" href="{{ route(config('admin.route.prefix') . '.admin.notification.show', $notification->id) }}">
                  <div class="text-white mb-0 w-100" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $notification->comment }}</div>
                  <p class="text-gray">{{ $notification->created_at }}</p>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="text-center">
          <p>
            <a class="text-danger" href="{{ route(config('admin.route.prefix') . '.admin.notification.index') }}">すべて見る</a>
          </p>
        </div>
        @else
          <div class="text-center">
            <p>お知らせはありません</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        const ctx = document.getElementById('myChart').getContext('2d');
        const chartData = @json($chartData);
        
        if (!chartData || chartData.length === 0 || !chartData[0].data) {
            return;
        }
        
        const labels = Object.keys(chartData[0].data);
        const datasets = chartData.map(function(item) {
            return {
                label: item.label,
                data: Object.values(item.data),
                backgroundColor: item.backgroundColor,
                borderWidth: 0
            };
        });

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        stacked: true,
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            display: true
                        },
                        border: {
                            display: true,
                            color: 'rgba(127, 205, 205, 1)',
                            width: 1,
                            dash: [10, 5]
                        },
                        stacked: true,
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 20,
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    })();
</script>