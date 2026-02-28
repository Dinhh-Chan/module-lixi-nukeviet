<!-- BEGIN: main -->
<div class="lixi-wrapper">
    <header class="lixi-header">
        <div class="lixi-header-brand">
            <div class="lixi-logo">
                <span class="material-symbols-outlined">redeem</span>
            </div>
            <h2 class="lixi-brand-text">NukeViet <span>Lì xì</span></h2>
        </div>
        <div class="lixi-header-actions">
            <nav class="lixi-nav">
                <a href="{MENU.url_main}">{LANG.home}</a>
                <a class="active" href="{MENU.url_create}">{LANG.create_event}</a>
                <a href="{MENU.url_my_events}">{LANG.my_events}</a>
                <a href="{MENU.url_history}">{LANG.history}</a>
                <a href="{MENU.url_ranking}">{LANG.ranking}</a>
            </nav>
            <a href="{MENU.url_create}" class="lixi-btn-create">
                <span class="material-symbols-outlined" style="margin-right:0.5rem;font-size:1.125rem">add_circle</span>
                {LANG.create_event}
            </a>
            <a href="{USER_LINK}" title="Tài khoản"><img class="lixi-avatar" src="{USER_AVATAR}" alt="Avatar" width="40" height="40"></a>
        </div>
    </header>

    <main class="lixi-main lixi-create-main">
        <div class="lixi-create-content">
            <div class="lixi-breadcrumb">
                <a href="{MENU.url_main}" class="lixi-breadcrumb-link">{LANG.active_events}</a>
                <span class="lixi-breadcrumb-sep">/</span>
                <span class="lixi-breadcrumb-current">{LANG.create_form_title}</span>
            </div>

            <div class="lixi-create-header">
                <span class="material-symbols-outlined lixi-create-header-icon">celebration</span>
                <h1>{LANG.create_form_title}</h1>
                <p>{LANG.create_form_desc}</p>
            </div>

            <!-- BEGIN: error -->
            <div class="lixi-alert lixi-alert-danger">{ERROR}</div>
            <!-- END: error -->
            <!-- BEGIN: success -->
            <div class="lixi-alert lixi-alert-success">{LANG.create_success}</div>
            <!-- END: success -->

            <form method="post" action="{FORM_ACTION}" class="lixi-create-form">
                <input type="hidden" name="submit" value="1">

                <section class="lixi-form-section">
                    <div class="lixi-form-section-title">
                        <span class="material-symbols-outlined">info</span>
                        <h2>{LANG.general_info}</h2>
                    </div>
                    <div class="lixi-form-grid">
                        <div class="lixi-form-group">
                            <label>{LANG.event_title} <span class="required">*</span></label>
                            <input type="text" name="title" value="{DATA.title}" placeholder="{LANG.event_title_ph}" required>
                        </div>
                        <div class="lixi-form-group">
                            <label>{LANG.description}</label>
                            <textarea name="description" rows="4" placeholder="{LANG.description_ph}">{DATA.description}</textarea>
                        </div>
                    </div>
                </section>

                <section class="lixi-form-section">
                    <div class="lixi-form-section-title">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                        <h2>{LANG.distribution_limits}</h2>
                    </div>
                    <div class="lixi-form-grid lixi-form-grid-2">
                        <div class="lixi-form-group">
                            <label>{LANG.max_participants} <span class="required">*</span></label>
                            <div class="lixi-input-icon">
                                <span class="material-symbols-outlined">groups</span>
                                <input type="number" name="max_participants" value="{DATA.max_participants}" min="1">
                            </div>
                        </div>
                        <div class="lixi-form-group">
                            <label>{LANG.total_envelopes} <span class="required">*</span></label>
                            <div class="lixi-input-icon">
                                <span class="material-symbols-outlined">mail</span>
                                <input type="number" name="num_envelopes" value="{DATA.num_envelopes}" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="lixi-form-group">
                        <label>{LANG.amount_type_label}</label>
                        <div class="lixi-radio-cards">
                            <label class="lixi-radio-card">
                                <input type="radio" name="amount_type" value="fixed" {DATA.amount_type_fixed}>
                                <div class="lixi-radio-card-inner">
                                    <span class="material-symbols-outlined">equalizer</span>
                                    <div>
                                        <p class="lixi-radio-card-title">{LANG.amount_type_fixed}</p>
                                        <p class="lixi-radio-card-desc">{LANG.amount_type_fixed_desc}</p>
                                    </div>
                                </div>
                            </label>
                            <label class="lixi-radio-card">
                                <input type="radio" name="amount_type" value="random" {DATA.amount_type_random}>
                                <div class="lixi-radio-card-inner">
                                    <span class="material-symbols-outlined">shuffle</span>
                                    <div>
                                        <p class="lixi-radio-card-title">{LANG.amount_type_random}</p>
                                        <p class="lixi-radio-card-desc">{LANG.amount_type_random_desc}</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="lixi-form-grid lixi-form-grid-2">
                        <div class="lixi-form-group lixi-amount-fixed-block">
                            <label>{LANG.amount_per_envelope}</label>
                            <div class="lixi-input-currency">
                                <span class="lixi-currency-symbol">₫</span>
                                <input type="number" name="amount_fixed" value="{DATA.amount_fixed}" min="0" placeholder="10.000">
                            </div>
                        </div>
                        <div class="lixi-form-group lixi-amount-random-block">
                            <label>{LANG.amount_min_range}</label>
                            <div class="lixi-input-currency">
                                <span class="lixi-currency-symbol">₫</span>
                                <input type="number" name="amount_min" value="{DATA.amount_min}" min="0" placeholder="1.000">
                            </div>
                        </div>
                        <div class="lixi-form-group lixi-amount-random-block">
                            <label>{LANG.amount_max_range}</label>
                            <div class="lixi-input-currency">
                                <span class="lixi-currency-symbol">₫</span>
                                <input type="number" name="amount_max" value="{DATA.amount_max}" min="0" placeholder="100.000">
                            </div>
                        </div>
                    </div>
                </section>

                <section class="lixi-form-section">
                    <div class="lixi-form-section-title">
                        <span class="material-symbols-outlined">schedule</span>
                        <h2>{LANG.event_timing}</h2>
                    </div>
                    <div class="lixi-form-grid lixi-form-grid-2">
                        <div class="lixi-form-group">
                            <label>{LANG.start_datetime} <span class="required">*</span></label>
                            <div class="lixi-input-icon">
                                <span class="material-symbols-outlined">calendar_today</span>
                                <input type="datetime-local" name="start_datetime" value="{DATA.start_datetime}">
                            </div>
                        </div>
                        <div class="lixi-form-group">
                            <label>{LANG.end_datetime} <span class="required">*</span></label>
                            <div class="lixi-input-icon">
                                <span class="material-symbols-outlined">event_busy</span>
                                <input type="datetime-local" name="end_datetime" value="{DATA.end_datetime}">
                            </div>
                        </div>
                    </div>
                </section>

                <div class="lixi-form-actions">
                    <a href="{MENU.url_main}" class="lixi-btn-secondary">{LANG.save_draft}</a>
                    <button type="submit" class="lixi-btn-primary">
                        <span class="material-symbols-outlined">rocket_launch</span>
                        {LANG.create_event_btn}
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="lixi-create-footer">
        <div class="lixi-footer-inner">
            <span class="material-symbols-outlined">shield</span>
            <span>Tất cả giao dịch lì xì đều ảo và an toàn</span>
        </div>
        <p class="lixi-footer-copy">Powered by NukeViet CMS © 2024</p>
    </footer>
</div>
<script>
document.querySelectorAll('.lixi-create-form input[name="amount_type"]').forEach(function(r) {
    r.addEventListener('change', function() {
        var fixed = document.querySelectorAll('.lixi-amount-fixed-block');
        var random = document.querySelectorAll('.lixi-amount-random-block');
        if (this.value === 'fixed') {
            fixed.forEach(function(el){ el.style.display = ''; });
            random.forEach(function(el){ el.style.display = 'none'; });
        } else {
            fixed.forEach(function(el){ el.style.display = 'none'; });
            random.forEach(function(el){ el.style.display = ''; });
        }
    });
});
var at = document.querySelector('.lixi-create-form input[name="amount_type"]:checked');
if (at) at.dispatchEvent(new Event('change'));
</script>
<!-- END: main -->
