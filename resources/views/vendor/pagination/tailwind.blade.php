@php
$hasPages = $paginator->hasPages();
@endphp
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-default rounded-2xl">
                Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-2xl hover:bg-gray-50 transition-colors">
                Sebelumnya
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-2xl hover:bg-gray-50 transition-colors">
                Selanjutnya
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-default rounded-2xl">
                Selanjutnya
            </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-500">
                Menampilkan
                <span class="font-semibold text-gray-700">{{ $paginator->firstItem() ?: 0 }}</span>
                sampai
                <span class="font-semibold text-gray-700">{{ $paginator->lastItem() ?: 0 }}</span>
                dari
                <span class="font-semibold text-gray-700">{{ $paginator->total() }}</span>
                data
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex rounded-2xl shadow-sm">
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="Previous">
                        <span class="relative inline-flex items-center px-2.5 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-200 cursor-default rounded-l-2xl">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2.5 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-l-2xl hover:bg-gray-50 transition-colors" aria-label="Previous">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="relative inline-flex items-center px-3.5 py-2 -ml-px text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-default">{{ $element }}</span>
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span class="relative inline-flex items-center px-3.5 py-2 -ml-px text-sm font-bold text-primary-600 bg-primary-50 border border-primary-200 cursor-default">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}" class="relative inline-flex items-center px-3.5 py-2 -ml-px text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors" aria-label="Page {{ $page }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2.5 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-r-2xl hover:bg-gray-50 transition-colors" aria-label="Next">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="Next">
                        <span class="relative inline-flex items-center px-2.5 py-2 -ml-px text-sm font-medium text-gray-300 bg-white border border-gray-200 cursor-default rounded-r-2xl">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        </span>
                    </span>
                @endif
            </span>
        </div>
    </div>
</nav>
