/* ----------------- Is_active switch ------------------ */

$('#is_active_ui_switch').on('change', function() {
    const is_active_input = $('#is_active_input');
    $(this).is(':checked') ? is_active_input.val(1) : is_active_input.val(0);
});
