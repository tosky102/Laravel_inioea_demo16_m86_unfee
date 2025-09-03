<?php

$currentPage = $paginator->currentPage();
$total = $paginator->lastPage();

$pageMin = $currentPage > 5 ? $currentPage - 4 : 1;
$pageMax = $currentPage + 4 > $total ? $total : $currentPage + 4;

$spPageMin = $currentPage > 3 ? $currentPage - 2 : 1;
$spPageMax = $currentPage + 2 > $total ? $total : $currentPage + 2;
?>
@if ($paginator->hasPages())
    <div class="pagination">
        <div class="pagination__inner">
            @if ($paginator->onFirstPage())
                <a href="#" class="pagination__prev"><i class="icon font-arrow-left"></i></a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination__prev"><i class="icon font-arrow-left"></i></a>
            @endif


            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif


                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if($page >= $pageMin && $page <= $pageMax)
                            @if ($page == $paginator->currentPage())
                                <a href="#" class="pagination__num current">{{ $page }}</a>
                            @else
                                <a href="{{ $url }}" class="pagination__num">{{ $page }}</a>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination__next"><i class="icon font-arrow-right"></i></a>
            @else
                <a href="#" class="pagination__next"><i class="icon font-arrow-right"></i></a>
            @endif
        </div>
    </div>


    <div class="sp-pagination">
        <div class="pagination__inner">
            @if ($paginator->onFirstPage())
                <a href="#" class="pagination__prev"><i class="icon font-arrow-left"></i></a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination__prev"><i class="icon font-arrow-left"></i></a>
            @endif


            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif


                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if($page >= $spPageMin && $page <= $spPageMax)
                            @if ($page == $paginator->currentPage())
                                <a href="#" class="pagination__num current">{{ $page }}</a>
                            @else
                                <a href="{{ $url }}" class="pagination__num">{{ $page }}</a>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination__next"><i class="icon font-arrow-right"></i></a>
            @else
                <a href="#" class="pagination__next"><i class="icon font-arrow-right"></i></a>
            @endif
        </div>
    </div>

@endif
