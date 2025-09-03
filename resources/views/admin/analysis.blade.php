<div class="analysis">
  <div class="row">
    <div class="col-md-3 col-12">
      <div class="form-group">
        <select name="month" id="month" class="form-control">
          @foreach ($months as $m)
            <option value="{{ $m }}" @if(isset($month) && $month == $m) selected @endif>{{ $m }}のデータ分析</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  
  <div class="row mt-3">
    <div class="col-md-6 col-12">
      <div class="box match-analysis-box">
        <div class="box-body">
          <div class="chart-title">
            <h5 class="text-bold">マッチング件数</h5>
            <p class="text-bold">{{ number_format($totalMatchingCount) }}</p>
          </div>
          <div class="chart-graph" style="height: 400px;">
            <canvas id="match-chart"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="box pv-analysis-box">
        <div class="box-body">
          <div class="chart-title">
            <h5 class="text-bold">PV数</h5>
            <p class="text-bold">{{ number_format($totalPVCount) }}</p>
          </div>
          <div class="chart-graph" style="height: 400px;">
            <canvas id="pv-chart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="box box-default">
    <div class="box-body">
      <h4 class="text-bold">主要指標</h4>

      <div class="graph">
        <div class="graph-item">
          <div class="graph-header">
            <div class="graph-header-item text-center text-bold" style="flex: 2">サイト流入</div>
            <div class="graph-header-item text-center text-bold" style="flex: 1">検討</div>
            <div class="graph-header-item text-center text-bold" style="flex: 1">マッチング</div>
          </div>
          <div class="graph-body-container">
            <div class="graph-body-bg">
              <div class="graph-body-bg-item graph-body-bg-item-1"></div>
              <div class="graph-body-bg-item graph-body-bg-item-2"></div>
              <div class="graph-body-bg-item graph-body-bg-item-3"></div>
              <div class="graph-body-bg-item graph-body-bg-item-4"></div>
              <div class="graph-body-bg-item graph-body-bg-item-5"></div>
              <div class="graph-body-bg-item graph-body-bg-item-6"></div>
              <div class="graph-body-bg-item graph-body-bg-item-7"></div>
            </div>
            <div class="graph-body">
              <div class="graph-body-item">
                <div class="graph-card">
                  <div class="graph-card-title text-left">新規ユーザー数</div>
                  <div class="graph-card-value">
                    <div class="text-bold">{{ number_format($data['currentNewUsers']) }}</div>
                    <span class="text-bold">人</span>
                  </div>
                  <div class="graph-card-compare">
                    <span class="text-secondary">前月比</span>
                    <span class="text-bold <?php echo $data['currentNewUserPercentage'] == '-' ? 'text-secondary' : ($data['currentNewUserPercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                      @if ($data['currentNewUserPercentage'] == '-')
                        <i class="fa fa-minus"></i>
                      @else
                        @if ($data['currentNewUserPercentage'] > 0)
                            <i class="fa fa-caret-up"></i>
                        @elseif($data['currentNewUserPercentage'] < 0)
                            <i class="fa fa-caret-down"></i>
                        @endif
                        {{ $data['currentNewUserPercentage'] == '-' ? '-' : number_format(($data['currentNewUserPercentage']), 2) }}
                      @endif％
                    </span>
                  </div>
                </div>
              </div>
              <div class="graph-body-item">
                <div class="graph-card">
                  <div class="graph-card-title text-left">すべての訪問者数</div>
                  <div class="graph-card-value">
                    <div class="text-bold">{{ number_format($data['currentAllUsers']) }}</div>
                    <span class="text-bold">人</span>
                  </div>
                  <div class="graph-card-compare">
                    <span class="text-secondary">前月比</span>
                    <span class="text-bold <?php echo $data['currentAllUserPercentage'] == '-' ? 'text-secondary' : ($data['currentAllUserPercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                      @if ($data['currentAllUserPercentage'] == '-')
                        <i class="fa fa-minus"></i>
                      @else
                        @if ($data['currentAllUserPercentage'] > 0)
                            <i class="fa fa-caret-up"></i>
                        @elseif($data['currentAllUserPercentage'] < 0)
                            <i class="fa fa-caret-down"></i>
                        @endif
                        {{ $data['currentAllUserPercentage'] == '-' ? '-' : number_format(($data['currentAllUserPercentage']), 2) }}
                      @endif％
                    </span>
                  </div>
                </div>
              </div>
              <div class="graph-body-item">
                <div class="graph-card">
                  <div class="graph-card-title text-left">詳細ページ訪問者数</div>
                  <div class="graph-card-value">
                    <div class="text-bold">{{ number_format($data['currentDetailPVCount']) }}</div>
                    <span class="text-bold">人</span>
                  </div>
                  <div class="graph-card-compare">
                    <span class="text-secondary">前月比</span>
                    <span class="text-bold <?php echo $data['currentDetailPVPercentage'] == '-' ? 'text-secondary' : ($data['currentDetailPVPercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                      @if ($data['currentDetailPVPercentage'] == '-')
                        <i class="fa fa-minus"></i>
                      @else
                        @if ($data['currentDetailPVPercentage'] > 0)
                            <i class="fa fa-caret-up"></i>
                        @elseif($data['currentDetailPVPercentage'] < 0)
                            <i class="fa fa-caret-down"></i>
                        @endif
                        {{ $data['currentDetailPVPercentage'] == '-' ? '-' : number_format(($data['currentDetailPVPercentage']), 2) }}
                      @endif％
                    </span>
                  </div>
                </div>
              </div>
              <div class="graph-body-item">
                <div class="graph-card">
                  <div class="graph-card-title text-left">マッチングしたユーザー数</div>
                  <div class="graph-card-value">
                    <div class="text-bold">{{ number_format($data['currentMatchingUsers']) }}</div>
                    <span class="text-bold">人</span>
                  </div>
                  <div class="graph-card-compare">
                    <span class="text-secondary">前月比</span>
                    <span class="text-bold <?php echo $data['currentMatchingUserPercentage'] == '-' ? 'text-secondary' : ($data['currentMatchingUserPercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                      @if ($data['currentMatchingUserPercentage'] == '-')
                        <i class="fa fa-minus"></i>
                      @else
                        @if ($data['currentMatchingUserPercentage'] > 0)
                            <i class="fa fa-caret-up"></i>
                        @elseif($data['currentMatchingUserPercentage'] < 0)
                            <i class="fa fa-caret-down"></i>
                        @endif
                        {{ $data['currentMatchingUserPercentage'] == '-' ? '-' : number_format(($data['currentMatchingUserPercentage']), 2) }}
                      @endif％
                    </span>
                  </div>
                </div>
              </div>
              <div class="graph-body-item">
                <div class="graph-card">
                  <div class="graph-card-title text-left">リピーター数</div>
                  <div class="graph-card-value">
                    <div class="text-bold">{{ $data['currentOldUsers'] == '-' ? '-' : number_format($data['currentOldUsers']) }}</div>
                    <span class="text-bold">人</span>
                  </div>
                  <div class="graph-card-compare">
                    <span class="text-secondary">前月比</span>
                    <span class="text-bold <?php echo $data['currentOldUserPercentage'] == '-' ? 'text-secondary' : ($data['currentOldUserPercentage'] > 0 ? 'text-[#34cccc]' : 'text-secondary'); ?>">
                      @if ($data['currentOldUserPercentage'] == '-')
                        <i class="fa fa-minus"></i>
                      @else
                        @if ($data['currentOldUserPercentage'] > 0)
                            <i class="fa fa-caret-up"></i>
                        @elseif($data['currentOldUserPercentage'] < 0)
                            <i class="fa fa-caret-down"></i>
                        @endif
                        {{ $data['currentOldUserPercentage'] == '-' ? '-' : number_format(($data['currentOldUserPercentage']), 2) }}
                      @endif％
                    </span>
                  </div>
                </div>
              </div>
              <div class="graph-body-item">
                <div class="graph-card graph-card-primary">
                  <div class="graph-card-title text-left">詳細ページ遷移率</div>
                  <div class="graph-card-value">
                    <div class="text-bold">{{ $data['currentDetailPVRate'] == '-' ? '-' : number_format($data['currentDetailPVRate']) }}</div>
                    <span class="text-bold">％</span>
                  </div>
                  <div class="graph-card-compare">
                    <span class="text-secondary">前月比</span>
                    <span class="text-bold <?php echo $data['currentDetailPVRatePercentage'] == '-' ? 'text-secondary' : ($data['currentDetailPVRatePercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                      @if ($data['currentDetailPVRatePercentage'] == '-')
                        <i class="fa fa-minus"></i>
                      @else
                        @if ($data['currentDetailPVRatePercentage'] > 0)
                            <i class="fa fa-caret-up"></i>
                        @elseif($data['currentDetailPVRatePercentage'] < 0)
                            <i class="fa fa-caret-down"></i>
                        @endif
                        {{ $data['currentDetailPVRatePercentage'] == '-' ? '-' : number_format(($data['currentDetailPVRatePercentage']), 2) }}
                      @endif％
                    </span>
                  </div>
                </div>
              </div>
              <div class="graph-body-item">
                <div class="graph-card graph-card-primary">
                  <div class="graph-card-title text-left">詳細ページ訪問者のマッチング率</div>
                  <div class="graph-card-value">
                    <div class="text-bold">{{ $data['currentDetailPVMatchingRate'] == '-' ? '-' : number_format($data['currentDetailPVMatchingRate']) }}</div>
                    <span class="text-bold">％</span>
                  </div>
                  <div class="graph-card-compare">
                    <span class="text-secondary">前月比</span>
                    <span class="text-bold <?php echo $data['currentDetailPVMatchingRatePercentage'] == '-' ? 'text-secondary' : ($data['currentDetailPVMatchingRatePercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                      @if ($data['currentDetailPVMatchingRatePercentage'] == '-')
                        <i class="fa fa-minus"></i>
                      @else
                        @if ($data['currentDetailPVMatchingRatePercentage'] > 0)
                            <i class="fa fa-caret-up"></i>
                        @elseif($data['currentDetailPVMatchingRatePercentage'] < 0)
                            <i class="fa fa-caret-down"></i>
                        @endif
                        {{ $data['currentDetailPVMatchingRatePercentage'] == '-' ? '-' : number_format(($data['currentDetailPVMatchingRatePercentage']), 2) }}
                      @endif pt
                    </span>
                  </div>
                </div>
              </div>
            </div>  
          </div>
        </div>
        <div class="graph-header">
          <div class="graph-header-item text-center text-bold" style="flex: 2">案件</div>
          <div class="graph-header-item text-center text-bold" style="flex: 1">提案</div>
          <div class="graph-header-item text-center text-bold" style="flex: 1">マッチング</div>
        </div>
        <div class="graph-body-container">
          <div class="graph-body-bg">
            <div class="graph-body-bg-item graph-body-bg-item-1"></div>
            <div class="graph-body-bg-item graph-body-bg-item-2"></div>
            <div class="graph-body-bg-item graph-body-bg-item-3"></div>
            <div class="graph-body-bg-item graph-body-bg-item-4"></div>
            <div class="graph-body-bg-item graph-body-bg-item-5"></div>
            <div class="graph-body-bg-item graph-body-bg-item-6"></div>
            <div class="graph-body-bg-item graph-body-bg-item-7"></div>
          </div>
          <div class="graph-body">
            <div class="graph-body-item">
              <div class="graph-card">
                <div class="graph-card-title text-left">新規案件数</div>
                <div class="graph-card-value">
                  <div class="text-bold">{{ number_format($data['currentNewItems']) }}</div>
                  <span class="text-bold">件</span>
                </div>
                <div class="graph-card-compare">
                  <span class="text-secondary">前月比</span>
                  <span class="text-bold <?php echo $data['currentNewItemPercentage'] == '-' ? 'text-secondary' : ($data['currentNewItemPercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                    @if ($data['currentNewItemPercentage'] == '-')
                      <i class="fa fa-minus"></i>
                    @else
                      @if ($data['currentNewItemPercentage'] > 0)
                        <i class="fa fa-caret-up"></i>
                      @elseif($data['currentNewItemPercentage'] < 0)
                        <i class="fa fa-caret-down"></i>
                      @endif
                      {{ $data['currentNewItemPercentage'] == '-' ? '-' : number_format(($data['currentNewItemPercentage']), 2) }}
                    @endif％
                  </span>
                </div>
              </div>
            </div>
            <div class="graph-body-item">
              <div class="graph-card">
                <div class="graph-card-title text-left">すべての案件数</div>
                <div class="graph-card-value">
                  <div class="text-bold">{{ number_format($data['currentAllItems']) }}</div>
                  <span class="text-bold">件</span>
                </div>
                <div class="graph-card-compare">
                  <span class="text-secondary">前月比</span>
                  <span class="text-bold <?php echo $data['currentAllItemPercentage'] == '-' ? 'text-secondary' : ($data['currentAllItemPercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                    @if ($data['currentAllItemPercentage'] == '-')
                      <i class="fa fa-minus"></i>
                    @else
                      @if ($data['currentAllItemPercentage'] > 0)
                        <i class="fa fa-caret-up"></i>
                      @elseif($data['currentAllItemPercentage'] < 0)
                        <i class="fa fa-caret-down"></i>
                      @endif
                      {{ $data['currentAllItemPercentage'] == '-' ? '-' : number_format(($data['currentAllItemPercentage']), 2) }}
                    @endif％
                  </span>
                </div>
              </div>
            </div>
            <div class="graph-body-item">
              <div class="graph-card">
                <div class="graph-card-title text-left">提案を受けた案件数</div>
                <div class="graph-card-value">
                  <div class="text-bold">{{ number_format($data['currentProposedItems']) }}</div>
                  <span class="text-bold">件</span>
                </div>
                <div class="graph-card-compare">
                  <span class="text-secondary">前月比</span>
                  <span class="text-bold <?php echo $data['currentProposedItemPercentage'] == '-' ? 'text-secondary' : ($data['currentProposedItemPercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                    @if ($data['currentProposedItemPercentage'] == '-')
                      <i class="fa fa-minus"></i>
                    @else
                      @if ($data['currentProposedItemPercentage'] > 0)
                        <i class="fa fa-caret-up"></i>
                      @elseif($data['currentProposedItemPercentage'] < 0)
                        <i class="fa fa-caret-down"></i>
                      @endif
                      {{ $data['currentProposedItemPercentage'] == '-' ? '-' : number_format(($data['currentProposedItemPercentage']), 2) }}
                    @endif％
                  </span>
                </div>
              </div>
            </div>
            <div class="graph-body-item">
              <div class="graph-card">
                <div class="graph-card-title text-left">マッチングした案件数</div>
                <div class="graph-card-value">
                  <div class="text-bold">{{ number_format($data['currentMatchingItems']) }}</div>
                  <span class="text-bold">件</span>
                </div>
                <div class="graph-card-compare">
                  <span class="text-secondary">前月比</span>
                  <span class="text-bold <?php echo $data['currentMatchingItemPercentage'] == '-' ? 'text-secondary' : ($data['currentMatchingItemPercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                    @if ($data['currentMatchingItemPercentage'] == '-')
                      <i class="fa fa-minus"></i>
                    @else
                      @if ($data['currentMatchingItemPercentage'] > 0)
                        <i class="fa fa-caret-up"></i>
                      @elseif($data['currentMatchingItemPercentage'] < 0)
                        <i class="fa fa-caret-down"></i>
                      @endif
                      {{ $data['currentMatchingItemPercentage'] == '-' ? '-' : number_format(($data['currentMatchingItemPercentage']), 2) }}
                    @endif％
                  </span>
                </div>
              </div>
            </div>
            <div class="graph-body-item">
              <div class="graph-card">
                <div class="graph-card-title text-left">既存案件数</div>
                <div class="graph-card-value">
                  <div class="text-bold">{{ number_format($data['currentOldItems']) }}</div>
                  <span class="text-bold">件</span>
                </div>
                <div class="graph-card-compare">
                  <span class="text-secondary">前月比</span>
                  <span class="text-bold <?php echo $data['currentOldItemPercentage'] == '-' ? 'text-secondary' : ($data['currentOldItemPercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                    @if ($data['currentOldItemPercentage'] == '-')
                      <i class="fa fa-minus"></i>
                    @else
                      @if ($data['currentOldItemPercentage'] > 0)
                        <i class="fa fa-caret-up"></i>
                      @elseif($data['currentOldItemPercentage'] < 0)
                        <i class="fa fa-caret-down"></i>
                      @endif
                      {{ $data['currentOldItemPercentage'] == '-' ? '-' : number_format(($data['currentOldItemPercentage']), 2) }}
                    @endif％
                  </span>
                </div>
              </div>
            </div>
            <div class="graph-body-item">
              <div class="graph-card graph-card-primary">
                <div class="graph-card-title text-left">案件あたり提案率</div>
                <div class="graph-card-value">
                  <div class="text-bold">{{ $data['currentProposedItemRate'] == '-' ? '-' : number_format($data['currentProposedItemRate']) }}</div>
                  <span class="text-bold">％</span>
                </div>
                <div class="graph-card-compare">
                  <span class="text-secondary">前月比</span>
                  <span class="text-bold <?php echo $data['currentProposedItemRatePercentage'] == '-' ? 'text-secondary' : ($data['currentProposedItemRatePercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                    @if ($data['currentProposedItemRatePercentage'] == '-')
                      <i class="fa fa-minus"></i>
                    @else
                      @if ($data['currentProposedItemRatePercentage'] > 0)
                        <i class="fa fa-caret-up"></i>
                      @elseif($data['currentProposedItemRatePercentage'] < 0)
                        <i class="fa fa-caret-down"></i>
                      @endif
                      {{ $data['currentProposedItemRatePercentage'] == '-' ? '-' : number_format(($data['currentProposedItemRatePercentage']), 2) }}
                    @endif％
                  </span>
                </div>
              </div>
            </div>
            <div class="graph-body-item">
              <div class="graph-card graph-card-primary">
                <div class="graph-card-title text-left">提案を受けた案件のマッチング率</div>
                <div class="graph-card-value">
                  <div class="text-bold">{{ $data['currentProposedItemMatchingRate'] == '-' ? '-' : number_format($data['currentProposedItemMatchingRate']) }}</div>
                  <span class="text-bold">％</span>
                </div>
                <div class="graph-card-compare">
                  <span class="text-secondary">前月比</span>
                  <span class="text-bold <?php echo $data['currentProposedItemMatchingRatePercentage'] == '-' ? 'text-secondary' : ($data['currentProposedItemMatchingRatePercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                    @if ($data['currentProposedItemMatchingRatePercentage'] == '-')
                      <i class="fa fa-minus"></i>
                    @else
                      @if ($data['currentProposedItemMatchingRatePercentage'] > 0)
                        <i class="fa fa-caret-up"></i>
                      @elseif($data['currentProposedItemMatchingRatePercentage'] < 0)
                        <i class="fa fa-caret-down"></i>
                      @endif
                      {{ $data['currentProposedItemMatchingRatePercentage'] == '-' ? '-' : number_format(($data['currentProposedItemMatchingRatePercentage']), 2) }}
                    @endif％
                  </span>
                </div>
              </div>
            </div>
            <div class="graph-body-item"></div>
            <div class="graph-body-item"></div>
            <div class="graph-body-item">
              <div class="graph-card">
                <div class="graph-card-title text-left">案件あたり平均提案数</div>
                <div class="graph-card-value">
                  <div class="text-bold">{{ $data['currentAverageProposedItemRate'] == '-' ? '-' : number_format($data['currentAverageProposedItemRate']) }}</div>
                  <span class="text-bold">件</span>
                </div>
                <div class="graph-card-compare">
                  <span class="text-secondary">前月比</span>
                  <span class="text-bold <?php echo $data['currentAverageProposedItemRatePercentage'] == '-' ? 'text-secondary' : ($data['currentAverageProposedItemRatePercentage'] > 0 ? 'text-tag' : 'text-secondary'); ?>">
                    @if ($data['currentAverageProposedItemRatePercentage'] == '-')
                      <i class="fa fa-minus"></i>
                    @else
                      @if ($data['currentAverageProposedItemRatePercentage'] > 0)
                        <i class="fa fa-caret-up"></i>
                      @elseif($data['currentAverageProposedItemRatePercentage'] < 0)
                        <i class="fa fa-caret-down"></i>
                      @endif
                      {{ $data['currentAverageProposedItemRatePercentage'] == '-' ? '-' : number_format(($data['currentAverageProposedItemRatePercentage']), 2) }}
                    @endif％
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      {{-- <div class="tab" style="padding: 0 8px;">
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
          合計<span class="text-bold total-count">{{ $totalCount }}</span><span class="text-bold">{{ $titleType }}</span>
        </div>
        <p class="chart-period">集計期間 {{ $chartPeriod }}</p>
        <div class="chart-graph" style="height: 400px;">
            <canvas id="myChart"></canvas>
        </div>
      </div> --}}
    </div>
  </div>
{{--   
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
  </div> --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function() {
        $('#month').on('change', function() {
            var selectedMonth = $(this).val();
            if (selectedMonth) {
                var url = new URL(window.location.href);
                url.searchParams.set('month', selectedMonth);
                window.location.href = url.toString();
            }
        });
    });

    const matchingData = @json($matchingData);
    console.log(matchingData);
    const pvData = @json($pvData);
    console.log(pvData);

    const matchChart = new Chart(document.getElementById('match-chart'), {
        type: 'bar',
        data: {
            labels: Object.keys(matchingData),
            datasets: [{
                label: 'マッチング件数',
                data: Object.values(matchingData),
                backgroundColor: '#0e83c5', 
                fill: false,
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
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
                }
            }
        }
    });

    const pvChart = new Chart(document.getElementById('pv-chart'), {
        type: 'bar',
        data: {
            labels: Object.keys(pvData),
            datasets: [{
                label: 'PV数',
                data: Object.values(pvData),
                backgroundColor: '#34cccc', 
                fill: false,
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
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
                }
            }
        }
    });
</script>