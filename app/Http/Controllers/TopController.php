<?php
namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Models\Contact;
use App\Models\HtmlPart;
use App\Models\Item;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TopController extends Controller
{
    public function index()
    {
        $topSliderSetting = [
            "slidesToShow" => 1,
            "slidesToScroll" => 1,
            'autoplay' => true,
            'dots' => true,
            'arrows' => false,
            'infinite' => true,
            'adaptiveHeight' => true,
            'centerMode' => true,
            'autoplaySpeed' => 5000,
            'variableWidth' => true,
            'responsive' => [
                [
                    'breakpoint' => 640,
                    'settings' => [
                        'slidesToShow' => 1,
                        'slidesToScroll' => 1,
                        'centerPadding' => '0%',
                        'variableWidth' => false
                    ]
                ]
            ]
        ];

        $objHtmlPart = HtmlPart::where('title', 'top_slider')->first();
        $topSliderHtml = $objHtmlPart ? $objHtmlPart->desc : '';
        $contents = explode(PHP_EOL, $topSliderHtml);

        $topSlider = [
            'settings' => $topSliderSetting,
            'contents' => $contents
        ];

        $itemSliderSetting = [
            "slidesToShow" => 1,
            "slidesToScroll" => 5,
            'dots' => false,
            'arrows' => true,
            'adaptiveHeight' => true,
            'variableWidth' => true,
            'infinite' => false,
            'responsive' => [
                [
                    'breakpoint' => 640,
                    'settings' => [
                        'slidesToShow' => 1,
                        'slidesToScroll' => 1,
                        'centerPadding' => '0%',
                        'variableWidth' => false
                    ]
                ]
            ]
        ];
        // 新しい店舗一覧
        // $objNewProducts = Item::where('status', 1)->latest()->limit(20)->get();
        // dd($objNewProducts);

        $objNewProducts = Item::whereHas('user', function($q) {
            $q->where('status', 3)
                ->where('role', 'company');
        })->public()->latest()->limit(20)->get();
        $newProductSlider = [
            'settings' => $itemSliderSetting,
            'contents' => $this->convertItemsToArray($objNewProducts, 'new')
        ];
        // 新しい求職者一覧
        // $objNewUsers = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2])->where('type', 1); })->whereIn('items.status', [1])->latest()->get();
        // $newUsersSlider = [
        //     'settings' => $itemSliderSetting,
        //     'contents' => $this->convertItemsToArray($objNewUsers, 'new')
        // ];

        // おすすめ店舗一覧
        // $objPickupProducts = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2])->where('type', 0); })->whereIn('items.status', [1])->orderBy('price', 'ASC')->take(20)->get();
        // $pickupProductSlider = [
        //     'settings' => $itemSliderSetting,
        //     'contents' => $this->convertItemsToArray($objPickupProducts)
        // ];
        // // おすすめ店舗一覧
        // $objPickupUsers = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2])->where('type', 1); })->whereIn('items.status', [1])->orderBy('price', 'ASC')->take(20)->get();
        // $pickupUsersSlider = [
        //     'settings' => $itemSliderSetting,
        //     'contents' => $this->convertItemsToArray($objPickupUsers)
        // ];

        $title = 'トップ';
        return view('top.index')->with(compact('title', 'topSlider', 'newProductSlider'));
    }


    public function guideBuy()
    {
        $objHtmlPart = HtmlPart::where('title', 'guide_buy')->first();
        $html = $objHtmlPart ? $objHtmlPart->desc : '<div class="l-main"><h2 class="tos-title">コンテンツを用意中です</h2></div>';
        $title = $objHtmlPart ? $objHtmlPart->name : '';
        return view('top.page')->with(compact('title', 'html'));
    }

    public function guideSale()
    {
        $objHtmlPart = HtmlPart::where('title', 'guide_sale')->first();
        $html = $objHtmlPart ? $objHtmlPart->desc : '<div class="l-main"><h2 class="tos-title">コンテンツを用意中です</h2></div>';
        $title = $objHtmlPart ? $objHtmlPart->name : '';
        return view('top.page')->with(compact('title', 'html'));
    }

    public function privacy()
    {
        $objHtmlPart = HtmlPart::where('title', 'privacy')->first();
        $html = $objHtmlPart ? $objHtmlPart->desc : '<div class="l-main"><h2 class="tos-title">コンテンツを用意中です</h2></div>';
        $title = $objHtmlPart ? $objHtmlPart->name : '';
        return view('top.page')->with(compact('title', 'html'));
    }

    public function law()
    {
        $objHtmlPart = HtmlPart::where('title', 'law')->first();
        $html = $objHtmlPart ? $objHtmlPart->desc : '<div class="l-main"><h2 class="tos-title">コンテンツを用意中です</h2></div>';
        $title = $objHtmlPart ? $objHtmlPart->name : '';
        return view('top.page')->with(compact('title', 'html'));
    }

    public function about()
    {
        $objHtmlPart = HtmlPart::where('title', 'about')->first();
        $html = $objHtmlPart ? $objHtmlPart->desc : '<div class="l-main"><h2 class="tos-title">コンテンツを用意中です</h2></div>';
        $title = $objHtmlPart ? $objHtmlPart->name : '';
        return view('top.page')->with(compact('title', 'html'));
    }

    public function faq()
    {
        $objHtmlPart = HtmlPart::where('title', 'faq')->first();
        $html = $objHtmlPart ? $objHtmlPart->desc : '<div class="l-main"><h2 class="tos-title">コンテンツを用意中です</h2></div>';
        $title = $objHtmlPart ? $objHtmlPart->name : '';
        return view('top.page')->with(compact('title', 'html'));
    }

    public function notification()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        $title = 'お知らせ';
        return view('top.notification')->with(compact('title', 'notifications'));
    }
}