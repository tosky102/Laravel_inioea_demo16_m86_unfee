@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">


            <div class="card">
                <div class="card-header">{{ $pageTitle }}</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mypage-table">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">{{ __('SaleYmItemId') }}</th>
                                <th scope="col" class="text-center">{{ __('SaleYmItemTitle') }}</th>
                                <th scope="col" class="text-center">{{ __('SaleYmItemTotal') }}</th>
                                <th scope="col" class="text-center">{{ __('SaleYmItemSaleFee') }}</th>
                                <th scope="col" class="text-center">{{ __('SaleYmItemCount') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($result) > 0)
                                @foreach($result as $row)
                                <tr>
                                    <th scope="row" class="text-center">{{ $row['item_id'] }}</th>
                                    <td class="text-center">{{ $row['title'] }}</td>
                                    <td class="text-center">{{ number_format($row['total']) }}</td>
                                    <td class="text-center">{{ number_format($row['sale_fee']) }}</td>
                                    <td class="text-center">{{ number_format($row['qty']) }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <th colspan="5" class="text-center">情報がありません。</th>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


        </div>

    </div>

@endsection
