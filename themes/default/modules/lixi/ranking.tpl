<!-- BEGIN: main -->
<div class="lixi-module">
    <div class="lixi-header">
        <h1 class="lixi-title">{LANG.lixi_title}</h1>
    </div>
    <ul class="lixi-nav nav nav-tabs">
        <li class="{MENU.active_main}"><a href="{MENU.url_main}">Trang chủ</a></li>
        <li class="{MENU.active_create}"><a href="{MENU.url_create}">{LANG.create_event}</a></li>
        <li class="{MENU.active_my_events}"><a href="{MENU.url_my_events}">{LANG.my_events}</a></li>
        <li class="{MENU.active_history}"><a href="{MENU.url_history}">{LANG.history}</a></li>
        <li class="{MENU.active_ranking}"><a href="{MENU.url_ranking}">{LANG.ranking}</a></li>
    </ul>
    <div class="lixi-content panel panel-default">
        <div class="panel-body">
            <h2 class="margin-bottom-lg">{LANG.ranking}</h2>
            <table class="table table-bordered">
    <thead>
        <tr>
            <th>Hạng</th>
            <th>Họ tên</th>
            <th>Tổng nhận (VNĐ)</th>
        </tr>
    </thead>
    <tbody>
        <!-- BEGIN: loop -->
        <tr>
            <td>{ROW.stt}</td>
            <td>{ROW.fullname}</td>
            <td>{ROW.total}</td>
        </tr>
        <!-- END: loop -->
    </tbody>
</table>
        </div>
    </div>
</div>
<!-- END: main -->
