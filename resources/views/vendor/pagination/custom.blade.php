@if ($paginator->hasPages())
    <style>
        .custom-pagination {
            display: flex;
            align-items: center;
            gap: 1rem;
            list-style: none;
            padding: 0;
            margin: 0;
            background: #fff;
            padding: .75rem 1.5rem;
            border-radius: 16px;
        }
        .custom-pagination .page-item {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .custom-pagination .page-link {
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            font-weight: 500;
            font-size: .95rem;
            color: #64748b;
            transition: all 0.2s;
            cursor: pointer;
        }
        .custom-pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .custom-pagination .page-link.number {
            width: 36px;
            height: 36px;
        }
        .custom-pagination .page-link.number:hover {
            color: #8b5cf6;
        }
        
        /* Diamond Active State */
        .custom-pagination .page-item.active .page-link.diamond {
            width: 34px;
            height: 34px;
            background: #8b5cf6;
            color: #fff;
            border-radius: 8px;
            transform: rotate(45deg);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
            margin: 0 .25rem;
            cursor: default;
        }
        .custom-pagination .page-item.active .diamond-text {
            transform: rotate(-45deg);
            display: inline-block;
            font-weight: 600;
            font-size: .95rem;
        }

        /* Prev / Next Buttons */
        .custom-pagination .prev-link, 
        .custom-pagination .next-link {
            width: 36px;
            height: 36px;
            border-radius: 10px;
        }
        .custom-pagination .prev-link {
            border: 1px solid #e2e8f0;
            color: #8b5cf6;
        }
        .custom-pagination .prev-link:not(.disabled):hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        .custom-pagination .next-link {
            background: #8b5cf6;
            color: #fff;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }
        .custom-pagination .next-link:not(.disabled):hover {
            background: #7c3aed;
            box-shadow: 0 6px 16px rgba(139, 92, 246, 0.4);
        }
        
        .custom-pagination [data-lucide] {
            width: 18px;
            height: 18px;
            stroke-width: 2.5;
        }

        /* Dark Mode Adjustments */
        [data-bs-theme="dark"] .custom-pagination {
            background: var(--bs-card-bg, #1e293b);
        }
        [data-bs-theme="dark"] .custom-pagination .page-link {
            color: #94a3b8;
        }
        [data-bs-theme="dark"] .custom-pagination .page-link.number:hover {
            color: #8b5cf6;
        }
        [data-bs-theme="dark"] .custom-pagination .prev-link {
            border-color: var(--bs-border-color, #334155);
        }
        [data-bs-theme="dark"] .custom-pagination .prev-link:not(.disabled):hover {
            background: var(--bs-body-bg, #0f172a);
            border-color: #475569;
        }
    </style>

    <ul class="custom-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link prev-link"><i data-lucide="chevron-left"></i></span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link prev-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i data-lucide="chevron-left"></i></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link dots">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link diamond"><span class="diamond-text">{{ $page }}</span></span>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link number" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link next-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i data-lucide="chevron-right"></i></a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link next-link"><i data-lucide="chevron-right"></i></span>
            </li>
        @endif
    </ul>
    
    {{-- Re-initialize Lucide icons for dynamically loaded pagination (if applicable) --}}
    <script>
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
@endif
