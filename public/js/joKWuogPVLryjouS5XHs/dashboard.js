const dashboardCont = document.getElementById('dashboard');
const yearSelect = document.getElementById('year_select');
const monthSelect = document.getElementById('month_select');

function updateDashboard() {
    const year = yearSelect.value;
    const month = monthSelect.value;
    const category_id = document.getElementById('category_select').value;

    $.ajax({
        url: '/admin/ajax',
        method: 'get',
        dataType: 'text',
        data: {
            service: 'dashboard',
            action: 'get_dashboard_content',
            year: year,
            month: month,
            category_id: category_id
        },
        success: function(data){
            dashboardCont.innerHTML = data;
            const categorySelect = document.getElementById('category_select');
            categorySelect.onchange = updateDashboard;
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

yearSelect.onchange = updateDashboard;
monthSelect.onchange = updateDashboard;
document.getElementById('category_select').onchange = updateDashboard;
