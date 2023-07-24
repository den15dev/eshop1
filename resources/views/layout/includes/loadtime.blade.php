<div class="d-none d-xl-block position-fixed small" style="left: 20px; bottom: 40px; color: #9c9c9c">
    Load time: {{ number_format(microtime(true) - LARAVEL_START, 3) }} sec<br>
    DB queries: {{ \App\Services\Site\CommonService::$db_query_num }}
</div>
