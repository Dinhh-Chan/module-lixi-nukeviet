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
            <h2 class="margin-bottom-lg">{EVENT.title}</h2>
            <p>Số người đã tham gia: {NUM_PARTICIPANTS} / {EVENT.num_envelopes}</p>
            <!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<!-- BEGIN: success -->
<div class="alert alert-success">
    <strong>Chúc mừng!</strong> Bạn đã bốc được {RESULT_AMOUNT} đ.
</div>
<!-- END: success -->

<!-- BEGIN: already_joined -->
<div class="alert alert-info">Bạn đã tham gia sự kiện này rồi.</div>
<!-- END: already_joined -->

<!-- BEGIN: full -->
<div class="alert alert-warning">Sự kiện đã đủ người tham gia.</div>
<!-- END: full -->

<!-- BEGIN: form -->
<form method="post" action="{FORM_ACTION}">
    <input type="hidden" name="submit" value="1">
    <div class="form-group">
        <label>{LANG.fullname} *</label>
        <input type="text" name="fullname" class="form-control" required>
    </div>
    <div class="form-group">
        <label>{LANG.birthyear}</label>
        <input type="text" name="birthyear" class="form-control" placeholder="VD: 1990">
    </div>
    <div class="form-group">
        <label>{LANG.bank_account}</label>
        <input type="text" name="bank_account" class="form-control">
    </div>
    <div class="form-group">
        <label>{LANG.bank_name}</label>
        <input type="text" name="bank_name" class="form-control" placeholder="VD: Vietcombank">
    </div>
    <button type="submit" class="btn btn-primary">{LANG.join}</button>
</form>
<!-- END: form -->
        </div>
    </div>
</div>
<!-- END: main -->
