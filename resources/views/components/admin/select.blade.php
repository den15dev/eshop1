@props([
    'layout' => 'normal',
    'name' => $name,
    'label' => $label,
    'data' => $data,
    'selected' => $selected,
    'note' => false,
    'nullable' => true,
])

<div class="{{ $layout == 'column' ? 'col' : 'adm_field_cont' }}">
    <label for="{{ $name . '_select' }}" class="form-label grey_text">{{ $label }}:</label>
    @if($note)
        <div class="small grey_text fst-italic mb-2" style="margin-top: -6px">{{ $note }}</div>
    @endif
    <select name="{{ $name }}" class="form-select @if ($errors->get($name)) is-invalid @endif" id="{{ $name . '_select' }}">
        <option {{ $nullable ? '' : ' disabled hidden' }}{{ $selected ? '' : ' selected' }}>Нет</option>
        @foreach($data as $item)
        <option value="{{ $item->id }}"{{ $item->id === $selected ? ' selected' : '' }}>{{ $item->name }}</option>
        @endforeach
    </select>

    @if ($errors->get($name))
        <div class="invalid-feedback">
            {{ $errors->get($name)[0] }}
        </div>
    @endif
</div>
