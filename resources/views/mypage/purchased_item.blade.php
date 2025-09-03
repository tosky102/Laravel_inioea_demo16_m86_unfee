@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

                <div class="card">
                    <div class="card-header">購入済み求人</div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center th-header">{{ __('PurchasedItemId') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('PurchasedItemDate') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('PurchasedItemTitle') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('PurchasedItemImage') }}</th>
                                    <th scope="col" class="text-center th-header">購入金額</th>
                                    <!--<th scope="col" class="text-center th-header">{{ __('PurchasedItemSaleFee') }}</th>-->
                                    <th scope="col" class="text-center th-header">{{ __('PurchasedItemDownload') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($orderItems) > 0)
                                    @foreach($orderItems as $orderItem)
                                        <tr>
                                            <td>{{ $orderItem->item_id }}</td>
                                            <td class="text-center">{{ date('Y.m.d H:i:s', strtotime($orderItem->created_at)) }}</td>
                                            <td class="text-center">
                                                @if($orderItem->item->deleted_at)
                                                    {{ $orderItem->title }}
                                                @else
                                                    <a href="{{ route('item.show', ['id' => $orderItem->item_id]) }}" target="_blank">{{ $orderItem->title }}</a>
                                                @endif
                                            </td>
                                            <td class="text-center"><img src="{{ $orderItem->item->main_image_url }}" /></td>
                                            <td class="text-center">{{ number_format($orderItem->total) }}</td>
                                            <!--<td class="text-center">{{ number_format($orderItem->sale_fee) }}</td>-->
                                            <td class="text-center">
                                                <div class="pc-only">
                                                @if(is_null($orderItem->item->deleted_at) && $orderItem->item->file_exist)
                                                <a href="{{ route('item.download', ['id' => $orderItem->item_id]) }}">ダウンロード</a>
                                                @else
                                                <span>ー</span>
                                                @endif
                                                </div>
                                                <div class="sp-only">
                                                    ダウンロードはPC版から行なってください
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                メッセージ：<br>
                                                <?php echo nl2br($orderItem->item->message); ?>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <th colspan="7" class="text-center">情報がありません。</th>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            {{ $orderItems->links('vendor.pagination.custom') }}

                        </div>



                    </div>
                </div>

        </div>

    </div>
@endsection