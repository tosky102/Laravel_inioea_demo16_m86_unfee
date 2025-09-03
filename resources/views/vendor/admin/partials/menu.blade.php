@if(Admin::user()->visible(\Illuminate\Support\Arr::get($item, 'roles', [])) && Admin::user()->can(\Illuminate\Support\Arr::get($item, 'permission')))
    @if(!isset($item['children']))
        <li>
            @if(url()->isValidUrl($item['uri']))
                <a href="{{ $item['uri'] }}" target="_blank" class="menu-link" data-uri="{{ $item['uri'] }}">
            @else
                 <a href="{{ admin_url($item['uri']) }}" class="menu-link" data-uri="{{ $item['uri'] }}">
            @endif
                @php
                    // バッジの表示ロジック
                    $badgeCount = 0;
                    if ($item['uri'] == 'userrequest') {
                        $requestModel = config('admin.database.front_users_model');
                        $query = $requestModel::query();
                        if (class_exists($requestModel)) {
                            $query->where('status', 2);
                        }
                        $adminConfirm = \App\Models\AdminConfirm::where('uri', $item['uri'])->first();
                        if ($adminConfirm) {
                            $query->where('updated_at', '>', $adminConfirm->confirmed_at);
                        }
                        $badgeCount = $query->count();
                    } elseif ($item['uri'] == 'orderitem') {
                        $orderItemModel = config('admin.database.order_items_model');
                        $query = $orderItemModel::query();
                        $adminConfirm = \App\Models\AdminConfirm::where('uri', $item['uri'])->first();
                        if ($adminConfirm) {
                            $query->where('created_at', '>', $adminConfirm->confirmed_at);
                        }
                        $badgeCount = $query->count();
                    } elseif ($item['uri'] == 'contact') {
                        $contactModel = config('admin.database.contacts_model');
                        $query = $contactModel::query();
                        $adminConfirm = \App\Models\AdminConfirm::where('uri', $item['uri'])->first();
                        if ($adminConfirm) {
                            $query->where('created_at', '>', $adminConfirm->confirmed_at);
                        }
                        $badgeCount = $query->count();
                    }

                @endphp
                <i class="fa {{$item['icon']}}"></i>
                @if (Lang::has($titleTranslation = 'admin.menu_titles.' . trim(str_replace(' ', '_', strtolower($item['title'])))))
                    <span>{{ __($titleTranslation) }}
                        @if($badgeCount > 0)
                            <span class="label label-danger badge-count" data-uri="{{ $item['uri'] }}">{{ $badgeCount }}</span>
                        @endif
                    </span>
                @else
                    <span>{{ admin_trans($item['title']) }}
                        @if($badgeCount > 0)
                            <span class="label label-danger badge-count" data-uri="{{ $item['uri'] }}">{{ $badgeCount }}</span>
                        @endif
                    </span>
                @endif

                @if($badgeCount > 0)
                    <span class="label label-danger badge-count badge-count-standalone" data-uri="{{ $item['uri'] }}">{{ $badgeCount }}</span>
                @endif
                
                @php
                    // バッジの表示ロジック
                    $badgeCount = 0;
                    if ($item['uri'] == 'userrequest') {
                        $requestModel = config('admin.database.front_users_model');
                        $query = $requestModel::query();
                        if (class_exists($requestModel)) {
                            $query->where('status', 2);
                        }
                        $adminConfirm = \App\Models\AdminConfirm::where('uri', $item['uri'])->first();
                        if ($adminConfirm) {
                            $query->where('updated_at', '>', $adminConfirm->confirmed_at);
                        }
                        $badgeCount = $query->count();
                    } elseif ($item['uri'] == 'orderitem') {
                        $orderItemModel = config('admin.database.order_items_model');
                        $query = $orderItemModel::query();
                        $adminConfirm = \App\Models\AdminConfirm::where('uri', $item['uri'])->first();
                        if ($adminConfirm) {
                            $query->where('created_at', '>', $adminConfirm->confirmed_at);
                        }
                        $badgeCount = $query->count();
                    } elseif ($item['uri'] == 'contact') {
                        $contactModel = config('admin.database.contacts_model');
                        $query = $contactModel::query();
                        $adminConfirm = \App\Models\AdminConfirm::where('uri', $item['uri'])->first();
                        if ($adminConfirm) {
                            $query->where('created_at', '>', $adminConfirm->confirmed_at);
                        }
                        $badgeCount = $query->count();
                    }

                @endphp           
            </a>
        </li>
    @else
        <li class="treeview">
            <a href="#">
                <i class="fa {{ $item['icon'] }}"></i>
                @if (Lang::has($titleTranslation = 'admin.menu_titles.' . trim(str_replace(' ', '_', strtolower($item['title'])))))
                    <span>{{ __($titleTranslation) }}</span>
                @else
                    <span>{{ admin_trans($item['title']) }}</span>
                @endif
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @foreach($item['children'] as $item)
                    @include('admin::partials.menu', $item)
                @endforeach
            </ul>
        </li>
    @endif
@endif

<script>
(function(){
  if (window.__adminBadgeScriptLoaded) return; // 重複ロード防止
  window.__adminBadgeScriptLoaded = true;
  var CSRF_TOKEN = '{{ csrf_token() }}';

  // スタイルを一度だけ注入（サイドバー折りたたみ時にもバッジを表示）
  (function injectBadgeStyle(){
    if (document.getElementById('admin-badge-style')) return;
    var style = document.createElement('style');
    style.id = 'admin-badge-style';
    style.textContent = `
      /* アンカーを基準位置に */
      .main-sidebar .sidebar-menu>li>a { position: relative; }

      /* 通常時は従来通りインライン配置（タイトル内） */
      .main-sidebar .sidebar-menu>li>a .badge-count { margin-left: 6px; }
      /* 通常時はスタンドアロンの方は隠す */
      .main-sidebar .sidebar-menu>li>a .badge-count-standalone { display: none; }

      /* 折りたたみ時はタイトル内のバッジを非表示にし、スタンドアロンの方を表示 */
      .sidebar-mini.sidebar-collapse .main-sidebar .sidebar-menu>li>a span .badge-count { display: none !important; }
      .sidebar-mini.sidebar-collapse .main-sidebar .sidebar-menu>li>a .badge-count-standalone {
        display: inline-block !important;
        position: absolute;
        right: 8px;
        top: 6px;
        z-index: 1000;
        font-size: 10px;
        padding: 2px 5px;
      }
      /* 折りたたみ状態でホバー時はツールチップ（タイトル）と衝突するためバッジを一旦非表示 */
      .sidebar-mini.sidebar-collapse .main-sidebar .sidebar-menu > li:hover > a .badge-count-standalone {
        left: inherit;
        width: fit-content;
        right: -175px;
      }
    `;
    document.head.appendChild(style);
  })();

  function confirmBadgeForUri(uri) {
    if (!uri) return;
    try {
      fetch('{{ admin_url('badge/confirm') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({ uris: [uri] }),
        keepalive: true
      }).catch(function(){ /* noop */ });
    } catch (e) { /* noop */ }
  }

  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.menu-link').forEach(function(link){
      link.addEventListener('click', function(){
        var uri = this.getAttribute('data-uri');
        var badges = this.querySelectorAll('.badge-count');
        if (badges && badges.length) {
          badges.forEach(function(b){ if (b && b.parentNode) b.parentNode.removeChild(b); });
          confirmBadgeForUri(uri);
        }
      });
    });
  });
})();
</script>