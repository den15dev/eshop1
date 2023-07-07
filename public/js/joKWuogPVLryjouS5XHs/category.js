/* -------------------- Update sort select ----------------------- */

const parentSelect = document.getElementById('parent_id_select');
const sortSelect = document.getElementById('sort_select');

function updateSortSelect() {
    const parent_id = parentSelect.value === '' ? 0 : parseInt(parentSelect.value, 10);

    let data = {
        service: 'category',
        action: 'get_children_num',
        parent_id: parent_id
    };

    $.ajax({
        url: '/admin/ajax',
        method: 'get',
        dataType: 'text',
        data: data,
        success: function (data) {
            while (sortSelect.firstChild) {
                sortSelect.removeChild(sortSelect.firstChild);
            }

            if (!creating_new_category) {
                if (parent_id === old_parent_id) data--;
            }

            for (let i=0; i<=data; i++) {
                let option = document.createElement('option');
                option.appendChild(document.createTextNode(i + 1));
                option.value = i + 1;
                sortSelect.appendChild(option);

                if (parent_id === old_parent_id && i === (old_sort - 1)) {
                    option.selected = true;
                }
            }
        },
        error: function (jqXHR) {
            showMessage({
                'type': 'note',
                'icon': 'warning',
                'message': 'Ошибка:<br>' + jqXHR.status + ' (' + jqXHR.statusText + ')',
            });
        }
    });
}

parentSelect.onchange = updateSortSelect;
