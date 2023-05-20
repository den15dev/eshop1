<li class="pt-1 pb-1 ps-3">
    <input class="form-check-input"
           type="checkbox"
           name="{{ $filtername }}[{{ $id }}]{{ $index !== '' ? '[' . $index . ']' : '' }}"
           value="{{ $value }}"
           id="{{ $index !== '' ? $filtername . $id . '_' . $index : $filtername . $id }}"
           @if($index === '')
               @checked(request($filtername . '.' . $id))
           @else
               @checked(request($filtername . '.' . $id . '.' . $index))
           @endif
    >
    <label class="form-check-label ms-1" for="{{ $index !== '' ? $filtername . $id . '_' . $index : $filtername . $id }}">
        {{ $value }} {{ $units }}<span class="lightgrey_text"> ({{ $quantity }})</span>
    </label>
</li>
