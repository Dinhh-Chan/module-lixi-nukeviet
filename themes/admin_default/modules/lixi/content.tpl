<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<form method="post" action="{ACTION}">
    <input type="hidden" name="save" value="1">
    <div class="form-group">
        <label>{LANG.title}</label>
        <input type="text" name="title" class="form-control" value="{DATA.title}" required>
    </div>
    <div class="form-group">
        <label>{LANG.description}</label>
        <textarea name="description" class="form-control" rows="3">{DATA.description}</textarea>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{LANG.max_participants}</label>
                <input type="number" name="max_participants" class="form-control" value="{DATA.max_participants}" min="1">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{LANG.num_envelopes}</label>
                <input type="number" name="num_envelopes" class="form-control" value="{DATA.num_envelopes}" min="1">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>{LANG.amount_type}</label>
        <select name="amount_type" class="form-control">
            <option value="fixed"{DATA.amount_type_fixed}>{LANG.amount_type_fixed}</option>
            <option value="random"{DATA.amount_type_random}>{LANG.amount_type_random}</option>
        </select>
    </div>
    <!-- BEGIN: fixed -->
    <div class="form-group">
        <label>{LANG.amount_fixed}</label>
        <input type="number" name="amount_fixed" class="form-control" value="{DATA.amount_fixed}" min="0">
    </div>
    <!-- END: fixed -->
    <!-- BEGIN: random -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{LANG.amount_min}</label>
                <input type="number" name="amount_min" class="form-control" value="{DATA.amount_min}" min="0">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{LANG.amount_max}</label>
                <input type="number" name="amount_max" class="form-control" value="{DATA.amount_max}" min="0">
            </div>
        </div>
    </div>
    <!-- END: random -->
    <div class="form-group">
        <label>{LANG.status}</label>
        <select name="status" class="form-control">
            <option value="1"{DATA.status_active}>{LANG.active}</option>
            <option value="0"{DATA.status_inactive}>{LANG.inactive}</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">{LANG.save}</button>
</form>
<!-- END: main -->
