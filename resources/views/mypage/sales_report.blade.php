@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">売上レポート</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mypage-table">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">{{ __('SalesReportMonth') }}</th>
                                <th scope="col" class="text-center">{{ __('SalesReportCount') }}</th>
                                <th scope="col" class="text-center">{{ __('SalesReportTotal') }}</th>
                                <th scope="col" class="text-center">{{ __('SalesReportSaleFee') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($result) > 0)
                                @foreach($result as $row)
                                <tr>
                                    <th scope="row" class="text-center"><a href="{{ route('mypage.sale_ym', ['ym' => $row['sale_ym']]) }}">{{ substr($row['sale_ym'],0,4) }}年{{ substr($row['sale_ym'],4,2) }}月</a></th>
                                    <td class="text-center">{{ number_format($row['qty']) }}</td>
                                    <td class="text-center">{{ number_format($row['total']) }}</td>
                                    <td class="text-center">{{ number_format($row['sale_fee']) }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <th colspan="4" class="text-center">情報がありません。</th>
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
