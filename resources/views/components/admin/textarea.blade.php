@props([
    'layout' => 'normal',
    'name' => $name,
    'label' => $label,
    'value' => $value,
    'note' => false,
])

<div class="{{ $layout == 'column' ? 'col' : 'adm_field_cont' }}">
    <label for="{{ $name . '_textarea' }}" class="form-label grey_text">{{ $label }}:</label>
    @if($note)
        <div class="small grey_text fst-italic mb-2" style="margin-top: -6px">{!! $note !!}</div>
    @endif
    <textarea name="{{ $name }}" class="form-control @if ($errors->get($name)) is-invalid @endif" id="{{ $name . '_textarea' }}">{!! old($name, $value) !!}</textarea>
    @if ($errors->get($name))
        <div class="invalid-feedback">
            {{ $errors->get($name)[0] }}
        </div>
    @endif
</div>
