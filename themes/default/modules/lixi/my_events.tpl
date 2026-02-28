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
            <h2 class="margin-bottom-lg">{LANG.my_events}</h2>
            <div class="list-group">
                <!-- BEGIN: loop -->
                <div class="list-group-item">
                    <div class="pull-right">
                        <a href="{EVENT.detail_url}" class="btn btn-default btn-xs">Chi tiết</a>
                        <a href="{EVENT.link}" class="btn btn-danger btn-xs" target="_blank">Chia sẻ</a>
                    </div>
                    <h4 class="list-group-item-heading">{EVENT.title}</h4>
                    <p class="list-group-item-text">{EVENT.num_participants}/{EVENT.num_envelopes} người - {EVENT.add_time}</p>
                </div>
                <!-- END: loop -->
            </div>
        </div>
    </div>
</div>
<!-- END: main -->
