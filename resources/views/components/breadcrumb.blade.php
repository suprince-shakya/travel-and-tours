@props(['items' => []])
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}"><i class="bi bi-house-door"></i></a>
        </li>
        @foreach ($items as $item)
            @if ($loop->last)
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item['label'] ?? $item }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] ?? '#' }}">{{ $item['label'] ?? $item }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
