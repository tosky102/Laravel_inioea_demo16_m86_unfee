<?php

namespace App\Admin\Controllers;

use App\Models\Browse;
use App\Models\User;
use App\Models\Contact;
use App\Models\Item;
use App\Models\Notification;
use App\Models\OrderItem;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class HomeController extends AdminController
{
    protected function title()
    {
        return trans('admin.dashboard');
    }

    public function index(Content $content)
    {
        $users = User::all()->count();
        $contacts = Contact::all()->count();
        $items = Item::all()->count();
        $notifications = Notification::all();

        $type = request()->get('type', 'pv');
        
        $titleType = 'PV';
        if ($type == 'uu') {
            $titleType = 'UU';
        } else if ($type == 'session') {
            $titleType = 'セッション';
        }
        
        $endDate = Carbon::now()->addDay();
        $startDate = Carbon::now()->subDays(29);
        
        $chartPeriod = $startDate->format('Y/m/d') . ' ~ ' . $endDate->copy()->subDay()->format('Y/m/d');
        
        $chartData = [];
        $chartDataAuth = [];
        $chartDataGuest = [];
        $totalCount = 0;
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if ($type == 'pv') {
                $authData = Browse::whereBetween('created_at', [$date->format('Y-m-d 00:00:00'), $date->format('Y-m-d 23:59:59')])->whereHas('user')->count();
                $guestData = Browse::whereBetween('created_at', [$date->format('Y-m-d 00:00:00'), $date->format('Y-m-d 23:59:59')])->whereDoesntHave('user')->count();

                $chartDataGuest[$date->format('m-d')] = $guestData;
                $totalCount += $guestData;
            } else if ($type == 'uu') {
                $authData = User::whereBetween('created_at', [$date->format('Y-m-d 00:00:00'), $date->format('Y-m-d 23:59:59')])->count();
            } else if ($type == 'session') {
                $authData = OrderItem::whereNotNull('matched_at')->whereBetween('matched_at', [$date->format('Y-m-d 00:00:00'), $date->format('Y-m-d 23:59:59')])->count();
            }
            
            $chartDataAuth[$date->format('m-d')] = $authData;
            $totalCount += $authData;
        }
        $chartData[] = [
            'label' => $type == 'pv' ? 'ログイン状態' : $titleType,
            'data' => $chartDataAuth,
            'backgroundColor' => '#34cccc',
        ];
        if ($type == 'pv') {
            $chartData[] = [
                'label' => '未ログイン状態・非会員',
                'data' => $chartDataGuest,
                'backgroundColor' => '#40f7f7',
            ];
        }

        $content = new Content();
        $content->header(trans('admin.dashboard'));
        $content->description(' ');
        
        $content->body(view('admin.dashboard', compact('users', 'contacts', 'items', 'notifications', 'chartPeriod', 'chartData', 'totalCount', 'titleType')));
        return $content;
    }
}
