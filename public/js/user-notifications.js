function unfoldNote(headElem) {
    let noteBody = headElem.parentNode.getElementsByClassName('note_body')[0];
    let headArrow = headElem.getElementsByTagName('span')[0];
    let headTitle = headElem.getElementsByTagName('span')[1];
    let is_unread = headElem.getAttribute('data-unread');
    let notification_id = headElem.getAttribute('data-id');

    if (getComputedStyle(noteBody).display === 'none') {
        noteBody.style.display = 'block';
        headArrow.className = 'bi-caret-down';
        headElem.style.backgroundColor = '#f5f5f5';
        if (is_unread) {
            headTitle.className = 'fw-normal';
            headElem.setAttribute('data-unread', 0);
            Livewire.emit('markAsRead', notification_id);
        }
    } else {
        noteBody.style.display = 'none';
        headArrow.className = 'bi-caret-right';
        headElem.style.background = 'none';
    }
}
