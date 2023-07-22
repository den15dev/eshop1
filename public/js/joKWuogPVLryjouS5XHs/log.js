let todayCont = document.getElementById('today_cont');

function getLog() {
    $.ajax({
        url: '/admin/ajax',
        method: 'get',
        dataType: 'text',
        data: {
            service: 'log',
            action: 'get_todays_log_view'
        },
        success: function(data){
            todayCont.innerHTML = data;
            updateRefreshTime();

            let curDate = todayCont.getAttribute('data-date');
            let newDate = todayCont.getElementsByTagName('table')[0].getAttribute('data-date');
            if (curDate !== newDate) {
                location.replace(location.href);
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


function updateRefreshTime() {
    let current = new Date();
    let h = current.getHours();
    let m = current.getMinutes();
    if (m < 10) { m = '0' + m; }
    let s = current.getSeconds();
    if (s < 10) { s = '0' + s; }

    document.getElementById('refresh_time').innerHTML = h + ':' + m + ':' + s;
}

setInterval('getLog()', 30000);
