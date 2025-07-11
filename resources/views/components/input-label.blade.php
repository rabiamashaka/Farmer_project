@props(['value'])

<label {{ $attributes->merge(['class' => ' class="block text-sm font-medium text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>

                       