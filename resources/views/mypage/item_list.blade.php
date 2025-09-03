@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">求人リスト</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form action="{{ route('mypage.item_all_del') }}" method="post" id="item_all_del_form">
                            @csrf
                            <table class="table mypage-table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">{{ __('ItemListSelect') }}</th>
                                    <th scope="col">{{ __('ItemListId') }}</th>
                                    <th scope="col" style="width: 100px">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('ItemListImage') }}</th>
                                    <th scope="col">{{ __('ItemListPrice') }}</th>
                                    <th scope="col">{{ __('ItemListStatus') }}</th>
                                    <th scope="col">{{ __('ItemListPurchase') }}</th>
                                    <th scope="col">{{ __('ItemListDownload') }}</th>
                                    <th scope="col">{{ __('ItemListReview') }}</th>
                                    <th scope="col">{{ __('ItemListEdit') }}</th>
                                    <th scope="col">{{ __('ItemListDelete') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($items) > 0)

                                    @foreach($items as $item)
                                    <tr>
                                        <th scope="row" class="text-center"><input type="checkbox" name="ids[]" class="item_list_delete" value="{{ $item->id }}" /></th>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td><img src="{{ $item->main_image_url }}" /></td>
                                        <td>{{ number_format($item->price) }}</td>
                                        <td>{{ $item->status_text }}</td>
                                        <td>{{ number_format($item->order_items()->count()) }}</td>
                                        <td>
                                            @if($item->file_exist)
                                                <a href="{{ route('mypage.download', ['id' => $item->id]) }}">{{ __('ItemListDownload') }}</a>
                                            @else
                                                <span>ー</span>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('mypage.item_review', ['id' => $item->id]) }}">{{ __('ItemListReview') }}</a></td>
                                        <td><a href="{{ route('mypage.item', ['id' => $item->id]) }}">{{ __('ItemListEdit') }}</a></td>
                                        <td><a href="{{ route('mypage.item_del', ['id' => $item->id]) }}">{{ __('ItemListDelete') }}</a></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <th colspan="9" class="text-center">情報がありません。</th>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>

                            {{ $items->links('vendor.pagination.custom') }}

                            <div class="form-group" style="margin-top:15px;">
                                <button type="button" class="btn btn-primary" onclick="checkAllItems();">全選択</button>
                                <button type="button" class="btn btn-warning" onclick="submitDelete();">選択した求人を削除</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
