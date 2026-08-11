@props(['paginator'])

@if($paginator->hasPages())
<div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
    <!-- Results Info -->
    <div class="text-sm text-slate-600 dark:text-zink-300">
        Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} results
    </div>
    
    <!-- Pagination -->
    <div class="flex items-center gap-2">
        <!-- Previous Button -->
        @if($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm text-slate-400 dark:text-zink-400 bg-slate-100 dark:bg-zink-600/50 border border-slate-200 dark:border-zink-500 rounded-lg cursor-not-allowed">
                « Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-sm text-slate-700 dark:text-zink-100 bg-white dark:bg-zink-700 border border-slate-200 dark:border-zink-600 rounded-lg hover:bg-slate-50 dark:hover:bg-zink-600 transition-colors">
                « Previous
            </a>
        @endif
        
        <!-- Page Numbers -->
        <div class="flex items-center bg-white dark:bg-zink-700 border border-slate-200 dark:border-zink-600 rounded-lg overflow-hidden">
            @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="px-3 py-2 text-sm font-medium text-white bg-custom-500 dark:bg-custom-500 border-r border-custom-500">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="px-3 py-2 text-sm text-slate-700 dark:text-zink-100 hover:bg-slate-50 dark:hover:bg-zink-600 transition-colors border-r border-slate-200 dark:border-zink-600 last:border-r-0">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        </div>
        
        <!-- Next Button -->
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-sm text-slate-700 dark:text-zink-100 bg-white dark:bg-zink-700 border border-slate-200 dark:border-zink-600 rounded-lg hover:bg-slate-50 dark:hover:bg-zink-600 transition-colors">
                Next »
            </a>
        @else
            <span class="px-3 py-2 text-sm text-slate-400 dark:text-zink-400 bg-slate-100 dark:bg-zink-600/50 border border-slate-200 dark:border-zink-500 rounded-lg cursor-not-allowed">
                Next »
            </span>
        @endif
    </div>
</div>
@endif
