@props([
    'layout' => 'normal',
    'name' => $name,
    'label' => $label,
    'value' => $value,
    'disabled' => false,
    'note' => false,
])

<div class="form-check form-switch adm_field_cont">
    <input name="{{ $name }}" class="form-check-input @if ($errors->get($name)) is-invalid @endif" type="checkbox" role="switch" id="{{ $name . '_switch' }}" {{ $value ? ' checked' : '' }} {{ $disabled ? 'disabled' : '' }}>
    <label class="form-check-label" for="{{ $name . '_switch' }}">{{ $label }}</label>
    @if ($errors->get($name))
        <div class="invalid-feedback" style="margin-left: -40px">
            {{ $errors->get($name)[0] }}
        </div>
    @endif
    @if($note)
        <div class="small grey_text fst-italic" style="margin-left: -40px">{{ $note }}</div>
    @endif
</div>
