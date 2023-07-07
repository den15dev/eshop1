@props([
    'layout' => 'normal',
    'name' => $name,
    'label' => $label,
    'collection' => $collection,
    'value' => 'id',
    'option' => 'name',
    'selected' => false,
    'note' => false,
    'nullable' => true,
    'novalue' => '',
])

<div class="{{ $layout == 'column' ? 'col' : 'adm_field_cont' }}">
    <label for="{{ $name . '_select' }}" class="form-label grey_text">{{ $label }}:</label>
    @if($note)
        <div class="small grey_text fst-italic mb-2" style="margin-top: -6px">{{ $note }}</div>
    @endif
    <select name="{{ $name }}" class="form-select @if ($errors->get($name)) is-invalid @endif" id="{{ $name . '_select' }}">
        <option value="{{ $novalue }}" {{ $nullable ? '' : ' disabled hidden' }}{{ $selected ? '' : ' selected' }}>Нет</option>
        @foreach($collection as $item)
        <option value="{{ $item->$value }}"{{ $item->$value == $selected ? ' selected' : '' }}>{{ $item->$option }}</option>
        @endforeach
    </select>

    @if ($errors->get($name))
        <div class="invalid-feedback">
            {{ $errors->get($name)[0] }}
        </div>
    @endif
</div>
