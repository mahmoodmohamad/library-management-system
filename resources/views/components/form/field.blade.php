{{-- resources/views/components/form/field.blade.php --}}
@props([
    'name',
    'label',
    'type' => 'text',      {{-- text | email | tel | date | number | select | textarea --}}
    'value' => null,
    'options' => [],       {{-- select only: [value => label] --}}
    'required' => false,
    'hint' => null,
])

@php
    $current = old($name, $value);
    if ($current instanceof \DateTimeInterface) {
        $current = $current->format('Y-m-d');
    }

    $hasError = $errors->has($name);
    $describedBy = trim(($hint ? "{$name}-hint " : '').($hasError ? "{$name}-error" : ''));

    $control = 'block w-full rounded-lg border bg-white px-3 py-2 text-sm text-slate-900 '
        .'placeholder:text-slate-400 outline-none transition focus:ring-2 '
        .($hasError
            ? 'border-red-400 focus:border-red-500 focus:ring-red-100'
            : 'border-slate-300 focus:border-blue-500 focus:ring-blue-100');
@endphp

<div {{ $attributes->only('class') }}>

    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700">
        {{ $label }}
        @if ($required)
            <span class="text-red-500" aria-hidden="true">*</span>
        @endif
    </label>

    @if ($type === 'select')

        <select id="{{ $name }}" name="{{ $name }}"
                @required($required)
                @if ($hasError) aria-invalid="true" @endif
                @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
                {{ $attributes->except('class')->merge(['class' => $control]) }}>
            @foreach ($options as $optValue => $optLabel)
                <option value="{{ $optValue }}" @selected((string) $current === (string) $optValue)>
                    {{ $optLabel }}
                </option>
            @endforeach
        </select>

    @elseif ($type === 'textarea')

        <textarea id="{{ $name }}" name="{{ $name }}" rows="4"
                  @required($required)
                  @if ($hasError) aria-invalid="true" @endif
                  @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
                  {{ $attributes->except('class')->merge(['class' => $control.' resize-y']) }}>{{ $current }}</textarea>

    @else

        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $current }}"
               @required($required)
               @if ($hasError) aria-invalid="true" @endif
               @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
               {{ $attributes->except('class')->merge(['class' => $control]) }}>

    @endif

    @if ($hint)
        <p id="{{ $name }}-hint" class="mt-1.5 text-xs text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p id="{{ $name }}-error" class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
    @enderror

</div>