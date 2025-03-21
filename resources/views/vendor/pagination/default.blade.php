@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
    Элементов на странице:
    @if (request()->is('equipment'))
        <form method="get" action="{{ url('equipment') }}">
            <select name="perpage">
                <option value="2" @if($paginator->perPage() == 2) selected @endif >2</option>
                <option value="5" @if($paginator->perPage() == 5) selected @endif >5</option>
                <option value="8" @if($paginator->perPage() == 8) selected @endif >8</option>
                <option value="12" @if($paginator->perPage() == 12) selected @endif >12</option>
            </select>
            <input type="submit" value="Изменить">
        </form>
    @elseif (request()->is('category'))
        <form method="get" action="{{ url('category') }}">
            <select name="perpage">
                <option value="1" @if($paginator->perPage() == 1) selected @endif >1</option>
                <option value="2" @if($paginator->perPage() == 2) selected @endif >2</option>
                <option value="4" @if($paginator->perPage() == 4) selected @endif >4</option>
                <option value="6" @if($paginator->perPage() == 6) selected @endif >6</option>
            </select>
            <input type="submit" value="Изменить">
        </form>
    @endif
@endif
