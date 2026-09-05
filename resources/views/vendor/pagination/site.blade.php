{{-- Apna pagination.

     Laravel ka default Tailwind ke liye bana hai. Is site par Tailwind
     nahi hai, isliye uske SVG arrow apne asli naap (bahut bade) mein
     aa jaate the aur "Showing 1 to 9" do baar dikhta tha -- ek mobile
     wale hisse se, ek desktop wale se.

     Ye version saada HTML hai jo site ki apni CSS se rang leta hai. --}}

@if ($paginator->hasPages())
<nav class="pg" role="navigation" aria-label="Pagination">

    @if ($paginator->onFirstPage())
        <span class="pg-btn is-off" aria-disabled="true">&larr; Previous</span>
    @else
        <a class="pg-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr; Previous</a>
    @endif

    <span class="pg-nums">
        @foreach ($elements as $element)
            {{-- "..." --}}
            @if (is_string($element))
                <span class="pg-gap">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pg-num is-on" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="pg-num" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </span>

    @if ($paginator->hasMorePages())
        <a class="pg-btn" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &rarr;</a>
    @else
        <span class="pg-btn is-off" aria-disabled="true">Next &rarr;</span>
    @endif

</nav>

<p class="pg-count">
    Showing {{ $paginator->firstItem() }}&ndash;{{ $paginator->lastItem() }}
    of {{ $paginator->total() }}
</p>
@endif
