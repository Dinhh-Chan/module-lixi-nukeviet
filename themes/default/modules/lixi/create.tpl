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
            <h2 class="margin-bottom-lg">{LANG.create_event}</h2>
            <!-- BEGIN: error -->
            <div class="alert alert-danger">{ERROR}</div>
            <!-- END: error -->
            <!-- BEGIN: success -->
            <div class="alert alert-success">Tạo sự kiện thành công!</div>
            <!-- END: success -->
            <form method="post">
    <input type="hidden" name="submit" value="1">
    <div class="form-group">
        <label>Tiêu đề *</label>
        <input type="text" name="title" class="form-control" value="{DATA.title}" required>
    </div>
    <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description" class="form-control" rows="2">{DATA.description}</textarea>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Số người tối đa</label>
                <input type="number" name="max_participants" class="form-control" value="{DATA.max_participants}" min="1">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Số phong bì</label>
                <input type="number" name="num_envelopes" class="form-control" value="{DATA.num_envelopes}" min="1">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Loại lì xì</label>
        <select name="amount_type" class="form-control">
            <option value="fixed"{DATA.amount_type_fixed}>Cố định</option>
            <option value="random"{DATA.amount_type_random}>Ngẫu nhiên</option>
        </select>
    </div>
    <div class="form-group" id="amount_fixed_block">
        <label>Số tiền cố định (VNĐ)</label>
        <input type="number" name="amount_fixed" class="form-control" value="{DATA.amount_fixed}" min="0">
    </div>
    <div class="row" id="amount_random_block">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Số tiền tối thiểu (VNĐ)</label>
                <input type="number" name="amount_min" class="form-control" value="{DATA.amount_min}" min="0">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Số tiền tối đa (VNĐ)</label>
                <input type="number" name="amount_max" class="form-control" value="{DATA.amount_max}" min="0">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">{GLANG.save}</button>
</form>
        </div>
    </div>
</div>
<!-- END: main -->
