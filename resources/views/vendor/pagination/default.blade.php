{{--@if ($paginator->hasPages())--}}
{{--    <nav>--}}
{{--        <ul class="pagination">--}}
{{--            --}}{{-- Previous Page Link --}}
{{--            @if ($paginator->onFirstPage())--}}
{{--                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">--}}
{{--                    <span aria-hidden="true">&lsaquo;</span>--}}
{{--                </li>--}}
{{--            @else--}}
{{--                <li>--}}
{{--                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>--}}
{{--                </li>--}}
{{--            @endif--}}

{{--            --}}{{-- Pagination Elements --}}
{{--            @foreach ($elements as $element)--}}
{{--                --}}{{-- "Three Dots" Separator --}}
{{--                @if (is_string($element))--}}
{{--                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>--}}
{{--                @endif--}}

{{--                --}}{{-- Array Of Links --}}
{{--                @if (is_array($element))--}}
{{--                    @foreach ($element as $page => $url)--}}
{{--                        @if ($page == $paginator->currentPage())--}}
{{--                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>--}}
{{--                        @else--}}
{{--                            <li><a href="{{ $url }}">{{ $page }}</a></li>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--            @endforeach--}}

{{--            --}}{{-- Next Page Link --}}
{{--            @if ($paginator->hasMorePages())--}}
{{--                <li>--}}
{{--                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>--}}
{{--                </li>--}}
{{--            @else--}}
{{--                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">--}}
{{--                    <span aria-hidden="true">&rsaquo;</span>--}}
{{--                </li>--}}
{{--            @endif--}}
{{--        </ul>--}}
{{--    </nav>--}}
{{--    Элементов на странице:--}}
{{--    @if (request()->is('equipment'))--}}
{{--        <form method="get" action="{{ url('equipment') }}">--}}
{{--            <select name="perpage">--}}
{{--                <option value="2" @if($paginator->perPage() == 2) selected @endif >2</option>--}}
{{--                <option value="5" @if($paginator->perPage() == 5) selected @endif >5</option>--}}
{{--                <option value="8" @if($paginator->perPage() == 8) selected @endif >8</option>--}}
{{--                <option value="12" @if($paginator->perPage() == 12) selected @endif >12</option>--}}
{{--            </select>--}}
{{--            <input type="submit" value="Изменить">--}}
{{--        </form>--}}
{{--    @elseif (request()->is('category'))--}}
{{--        <form method="get" action="{{ url('category') }}">--}}
{{--            <select name="perpage">--}}
{{--                <option value="1" @if($paginator->perPage() == 1) selected @endif >1</option>--}}
{{--                <option value="2" @if($paginator->perPage() == 2) selected @endif >2</option>--}}
{{--                <option value="4" @if($paginator->perPage() == 4) selected @endif >4</option>--}}
{{--                <option value="6" @if($paginator->perPage() == 6) selected @endif >6</option>--}}
{{--            </select>--}}
{{--            <input type="submit" value="Изменить">--}}
{{--        </form>--}}
{{--    @endif--}}
{{--@endif--}}


@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>

    <div class="d-flex justify-content-center align-items-center mt-3">
        <span class="me-2">Элементов на странице:</span>
        <form method="get" action="{{ request()->is('equipment') ? url('equipment') : url('category') }}" class="d-inline">
            <select name="perpage" class="form-select form-select-sm d-inline" style="width: auto;" onchange="this.form.submit()">
                @if (request()->is('equipment'))
                    <option value="2" @if($paginator->perPage() == 2) selected @endif>2</option>
                    <option value="5" @if($paginator->perPage() == 5) selected @endif>5</option>
                    <option value="8" @if($paginator->perPage() == 8) selected @endif>8</option>
                    <option value="12" @if($paginator->perPage() == 12) selected @endif>12</option>
                @elseif (request()->is('category'))
                    <option value="1" @if($paginator->perPage() == 1) selected @endif>1</option>
                    <option value="2" @if($paginator->perPage() == 2) selected @endif>2</option>
                    <option value="4" @if($paginator->perPage() == 4) selected @endif>4</option>
                    <option value="6" @if($paginator->perPage() == 6) selected @endif>6</option>
                @endif
            </select>
        </form>
    </div>
@endif
