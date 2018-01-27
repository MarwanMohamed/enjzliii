<?php
// config
$link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>
@if ($paginator->lastPage() > 1)
    <div class="pagi1">
    <ul class="customPagination">
        <li>
            @if($paginator->currentPage() == 1)
               <a class="" disabled=""><i class="icon-arrow-point-to-right"></i></a>
            @else
                <a href="{{ $paginator->url(1) }}"><i class="icon-arrow-point-to-right"></i></a>
            @endif
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $half_total_links = floor($link_limit / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
                $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                <li>
                    @if($paginator->currentPage() ==  $i)
                        <a class="active " disabled="">{{ $i }}</a>
                    @else
                        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    @endif
                </li>
            @endif
        @endfor
        <li>
            @if($paginator->currentPage() ==  $paginator->lastPage())
                <a class="" disabled=""><i class="icon-arrowhead-thin-outline-to-the-left"></i></a>
            @else
                <a href="{{ $paginator->url( $paginator->lastPage()) }}"><i class="icon-arrowhead-thin-outline-to-the-left"></i></a>
            @endif
        </li>
    </ul>
</div>
@endif