@props(['href', 'active' => false, 'icon' => null])

<a href="{{ $href }}"
   @class([
       'mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium',
       'bg-blue-50 text-blue-700' => $active,
       'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! $active,
   ])>
    @if ($icon)
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{{ $icon }}</svg>
    @endif

    {{ $slot }}
</a>