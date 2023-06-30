@props([
    'layout' => 'normal',
    'name' => $name,
    'label' => $label,
    'value' => $value,
    'disabled' => false,
    'note' => false,
])

<div class="{{ $layout == 'column' ? 'col' : 'adm_field_cont' }}">
    <label for="{{ $name . '_input' }}" class="form-label grey_text">{{ $label }}:</label>
    @if($note)
        <div class="small grey_text fst-italic mb-2" style="margin-top: -6px">{{ $note }}</div>
    @endif
    <input type="text" name="{{ $name }}" class="form-control @if ($errors->get($name)) is-invalid @endif" id="{{ $name . '_input' }}" value="{{ old($name, $value) }}" {{ $disabled ? 'disabled' : '' }}>
    @if ($errors->get($name))
        <div class="invalid-feedback">
            {{ $errors->get($name)[0] }}
        </div>
    @endif
</div>
