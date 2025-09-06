<?php

namespace App\Admin\Controllers;

use App\Models\Browse;
use App\Models\Item;
use App\Models\OrderItem;
use App\Models\Room;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalysisController extends AdminController
{
    public function index(Content $content)
    {
        $month = request()->get('month', date('Y-m'));
        $initialItem = Item::orderBy('created_at', 'asc')->first();
        if ($initialItem) {
            $initialMonth = Carbon::parse($initialItem->created_at)->format('Y-m');
        } else {
            $initialMonth = date('Y-m');
        }

        $start = Carbon::parse($initialMonth);
        $end = Carbon::now();
        $period = CarbonPeriod::create($start, '1 month', $end);
        $months = [];
        foreach ($period as $dt) {
            $months[] = $dt->format('Y-m');
        }

        $totalMatchingCount = OrderItem::where('matched_at', '<=', Carbon::parse($month)->endOfMonth())->count();
        $matchingData = OrderItem::where('matched_at', '<=', Carbon::parse($month)->endOfMonth())
            ->groupBy('ym')
            ->select(DB::raw("DATE_FORMAT(matched_at, '%Y年%m月') as ym"), DB::raw('COUNT(*) as count'))
            ->pluck('count', 'ym');

        $totalPVCount = Browse::where('created_at', '<=', Carbon::parse($month)->endOfMonth())->count();
        $pvData = Browse::where('created_at', '<=', Carbon::parse($month)->endOfMonth())
            ->groupBy('ym')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y年%m月') as ym"), DB::raw('COUNT(*) as count'))
            ->pluck('count', 'ym');

        // 新規ユーザー数
        $currentNewUsers = User::whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->count();
        $beforeNewUsers = User::whereBetween('created_at', [Carbon::parse($month)->startOfMonth()->subMonth(), Carbon::parse($month)->endOfMonth()->subMonth()])->count();
        $currentNewUserPercentage = $beforeNewUsers > 0 ? ($currentNewUsers - $beforeNewUsers) * 100.0 / $beforeNewUsers : '-';
        
        // レピーター数
        $currentOldUsers = User::where('created_at', '<', Carbon::parse($month)->startOfMonth()->format('Y-m-d 00:00:00'))->count();
        $beforeOldUsers = User::where('created_at', '<', Carbon::parse($month)->startOfMonth()->subMonth()->format('Y-m-d 00:00:00'))->count();
        $currentOldUserPercentage = $beforeOldUsers > 0 ? ($currentOldUsers - $beforeOldUsers) * 100.0 / $beforeOldUsers : '-';
        // dd($currentOldUserPercentage);

        // すべての訪問者数
        $currentAllUsers = $currentNewUsers + $currentOldUsers;
        $beforeAllUsers = $beforeNewUsers + $beforeOldUsers;
        $currentAllUserPercentage = $beforeAllUsers > 0 ? ($currentAllUsers - $beforeAllUsers) * 100.0 / $beforeAllUsers : '-';

        // 詳細ページ訪問者数
        $currentDetailPVCount = User::whereHas('visit_users', function($query) use ($month) {
            $query->whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()]);
        })->count();
        $beforeDetailPVCount = User::whereHas('visit_users', function($query) use ($month) {
            $query->whereBetween('created_at', [Carbon::parse($month)->startOfMonth()->subMonth()->format('Y-m-d 00:00:00'), Carbon::parse($month)->endOfMonth()->subMonth()->format('Y-m-d 23:59:59')]);
        })->count();
        $currentDetailPVPercentage = $beforeDetailPVCount > 0 ? ($currentDetailPVCount - $beforeDetailPVCount) * 100.0 / $beforeDetailPVCount : '-';

        // 詳細ページ遷移率
        $currentDetailPVRate = $currentAllUsers > 0 ? $currentDetailPVCount * 100.0 / $currentAllUsers : '-';
        $beforeDetailPVRate = $beforeAllUsers > 0 ? $beforeDetailPVCount * 100.0 / $beforeAllUsers : '-';
        $currentDetailPVRatePercentage = $currentDetailPVRate !== '-' && $beforeDetailPVRate !== '-' ? $currentDetailPVRate - $beforeDetailPVRate : '-';

        // マッチングしたユーザー数
        $currentMatchingUsers = User::whereHas('items', function ($query) use ($month) {
            $query->whereHas('order_items', function ($subquery) use ($month) {
                $subquery->whereBetween('matched_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()]);
            });
        })->count();
        $beforeMatchingUsers = User::whereHas('items', function ($query) use ($month) {
            $query->whereHas('order_items', function ($subquery) use ($month) {
                $subquery->whereBetween('matched_at', [Carbon::parse($month)->startOfMonth()->subMonth(), Carbon::parse($month)->endOfMonth()->subMonth()]);
            });
        })->count();
        $currentMatchingUserPercentage = $beforeMatchingUsers > 0 ? ($currentMatchingUsers - $beforeMatchingUsers) * 100.0 / $beforeMatchingUsers : '-';

        // 詳細ページ訪問者のマッチング率
        $currentDetailPVMatchingRate = $currentDetailPVCount > 0 ? $currentMatchingUsers * 100.0 / $currentDetailPVCount : '-';
        $beforeDetailPVMatchingRate = $beforeDetailPVCount > 0 ? $beforeMatchingUsers * 100.0 / $beforeDetailPVCount : '-';
        $currentDetailPVMatchingRatePercentage = $currentDetailPVMatchingRate !== '-' && $beforeDetailPVMatchingRate !== '-' ? $currentDetailPVMatchingRate - $beforeDetailPVMatchingRate : '-';

        // 新規案件数
        $currentNewItems = Item::whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->count();
        $beforeNewItems = Item::whereBetween('created_at', [Carbon::parse($month)->startOfMonth()->subMonth(), Carbon::parse($month)->endOfMonth()->subMonth()])->count();
        $currentNewItemPercentage = $beforeNewItems > 0 ? ($currentNewItems - $beforeNewItems) * 100.0 / $beforeNewItems : '-';

        // 既存案件数
        $currentOldItems = Item::where('created_at', '<', Carbon::parse($month)->startOfMonth()->format('Y-m-d 00:00:00'))->count();
        $beforeOldItems = Item::where('created_at', '<', Carbon::parse($month)->startOfMonth()->subMonth()->format('Y-m-d 00:00:00'))->count();
        $currentOldItemPercentage = $beforeOldItems > 0 ? ($currentOldItems - $beforeOldItems) * 100.0 / $beforeOldItems : '-';

        // すべての案件数
        $currentAllItems = $currentNewItems + $currentOldItems;
        $beforeAllItems = $beforeNewItems + $beforeOldItems;
        $currentAllItemPercentage = $beforeAllItems > 0 ? ($currentAllItems - $beforeAllItems) * 100.0 / $beforeAllItems : '-';

        // 提案を受けた案件数
        $currentProposedItems = Item::whereHas('rooms', function($query) use ($month) {
            $query->whereBetween('suggested_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()]);
        })->count();
        $beforeProposedItems = Item::whereHas('rooms', function($query) use ($month) {
            $query->whereBetween('suggested_at', [Carbon::parse($month)->startOfMonth()->subMonth(), Carbon::parse($month)->endOfMonth()->subMonth()]);
        })->count();
        $currentProposedItemPercentage = $beforeProposedItems > 0 ? ($currentProposedItems - $beforeProposedItems) * 100.0 / $beforeProposedItems : '-';

        // 案件あたり提案率
        $currentProposedItemRate = $currentAllItems > 0 ? $currentProposedItems * 100.0 / $currentAllItems : '-';
        $beforeProposedItemRate = $beforeAllItems > 0 ? $beforeProposedItems * 100.0 / $beforeAllItems : '-';
        $currentProposedItemRatePercentage = $currentProposedItemRate !== '-' && $beforeProposedItemRate !== '-' ? $currentProposedItemRate - $beforeProposedItemRate : '-';

        // 案件あたり平均提案率
        $currentTotalProposes = Room::whereBetween('suggested_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->count();
        $currentAverageProposedItemRate = $currentAllItems > 0 ? $currentTotalProposes * 100.0 / $currentAllItems : '-';
        $beforeTotalProposes = Room::whereBetween('suggested_at', [Carbon::parse($month)->startOfMonth()->subMonth(), Carbon::parse($month)->endOfMonth()->subMonth()])->count();
        $beforeAverageProposedItemRate = $beforeAllItems > 0 ? $beforeTotalProposes * 100.0 / $beforeAllItems : '-';
        $currentAverageProposedItemRatePercentage = $currentAverageProposedItemRate !== '-' && $beforeAverageProposedItemRate !== '-' ? $currentAverageProposedItemRate - $beforeAverageProposedItemRate : '-';

        // マッチングした案件数
        $currentMatchingItems = Item::whereHas('order_items', function($subquery) use ($month) {
            $subquery->whereBetween('matched_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()]);
        })->count();
        $beforeMatchingItems = Item::whereHas('order_items', function($subquery) use ($month) {
            $subquery->whereBetween('matched_at', [Carbon::parse($month)->startOfMonth()->subMonth(), Carbon::parse($month)->endOfMonth()->subMonth()]);
        })->count();
        $currentMatchingItemPercentage = $beforeMatchingItems > 0 ? ($currentMatchingItems - $beforeMatchingItems) * 100.0 / $beforeMatchingItems : '-';

        // 提案を受けた案件のマッチング率
        $currentProposedItemMatchingRate = $currentProposedItems > 0 ? $currentMatchingItems * 100.0 / $currentProposedItems : '-';
        $beforeProposedItemMatchingRate = $beforeProposedItems > 0 ? $beforeMatchingItems * 100.0 / $beforeProposedItems : '-';
        $currentProposedItemMatchingRatePercentage = $currentProposedItemMatchingRate !== '-' && $beforeProposedItemMatchingRate !== '-' ? $currentProposedItemMatchingRate - $beforeProposedItemMatchingRate : '-';

        $data = [
            'currentNewUsers' => $currentNewUsers,
            'currentOldUsers' => $currentOldUsers,
            'currentAllUsers' => $currentAllUsers,
            'currentDetailPVCount' => $currentDetailPVCount,
            'currentDetailPVRate' => $currentDetailPVRate,
            'currentMatchingUsers' => $currentMatchingUsers,
            'currentDetailPVMatchingRate' => $currentDetailPVMatchingRate,

            'currentMatchingUserPercentage' => $currentMatchingUserPercentage,
            'currentNewUserPercentage' => $currentNewUserPercentage,
            'currentOldUserPercentage' => $currentOldUserPercentage,
            'currentAllUserPercentage' => $currentAllUserPercentage,
            'currentDetailPVPercentage' => $currentDetailPVPercentage,
            'currentDetailPVRatePercentage' => $currentDetailPVRatePercentage,
            'currentDetailPVMatchingRatePercentage' => $currentDetailPVMatchingRatePercentage,
            
            'currentNewItems' => $currentNewItems,
            'currentOldItems' => $currentOldItems,
            'currentAllItems' => $currentAllItems,
            'currentProposedItems' => $currentProposedItems,
            'currentMatchingItems' => $currentMatchingItems,
            'currentProposedItemRate' => $currentProposedItemRate,
            'currentAverageProposedItemRate' => $currentAverageProposedItemRate,
            'currentProposedItemMatchingRate' => $currentProposedItemMatchingRate,
            
            'currentNewItemPercentage' => $currentNewItemPercentage,
            'currentOldItemPercentage' => $currentOldItemPercentage,
            'currentAllItemPercentage' => $currentAllItemPercentage,
            'currentProposedItemPercentage' => $currentProposedItemPercentage,
            'currentMatchingItemPercentage' => $currentMatchingItemPercentage,
            'currentProposedItemRatePercentage' => $currentProposedItemRatePercentage,
            'currentAverageProposedItemRatePercentage' => $currentAverageProposedItemRatePercentage,
            'currentProposedItemMatchingRatePercentage' => $currentProposedItemMatchingRatePercentage,
        ];

        return $content
            ->header(trans('admin.analysis'))
            ->description(' ')
            ->body(view('admin.analysis', compact('month', 'months', 'totalMatchingCount', 'totalPVCount', 'matchingData', 'pvData', 'data')));
    }
}
