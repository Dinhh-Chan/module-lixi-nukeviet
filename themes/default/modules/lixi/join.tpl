<!-- BEGIN: main -->
<div class="lixi-wrapper">
    <header class="lixi-header">
        <div class="lixi-header-brand">
            <div class="lixi-logo">
                <span class="material-symbols-outlined">celebration</span>
            </div>
            <h2 class="lixi-brand-text">NukeViet <span>{LANG.lixi_title}</span></h2>
            <div class="lixi-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" placeholder="{LANG.search_events}" disabled>
            </div>
        </div>
        <div class="lixi-header-actions">
            <nav class="lixi-nav">
                <a href="{MENU.url_main}">{LANG.home}</a>
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

    <main class="lixi-main lixi-join-main">
        <div class="lixi-join-content">
            <!-- Hero -->
            <div class="lixi-join-hero">
                <div class="lixi-join-hero-left">
                    <div class="lixi-join-tag">
                        <span class="material-symbols-outlined">auto_awesome</span>
                        <span>{LANG.lixi_title}</span>
                    </div>
                    <h1 class="lixi-join-title">{EVENT.title}</h1>
                    <p class="lixi-join-desc">{EVENT.description}</p>
                </div>
                <div class="lixi-join-hero-right">
                    <a href="#event-rules" class="lixi-join-btn-rules">
                        <span class="material-symbols-outlined">info</span>
                        {LANG.event_rules}
                    </a>
                </div>
            </div>

            <!-- BEGIN: error -->
            <div class="lixi-alert lixi-alert-danger">{ERROR}</div>
            <!-- END: error -->

            <!-- BEGIN: form -->
            <div class="lixi-join-grid">
                <div class="lixi-join-envelope-wrap">
                    <div class="lixi-envelope lixi-envelope-locked">
                        <div class="lixi-envelope-inner">
                            <div class="lixi-envelope-top"></div>
                            <div class="lixi-envelope-fu">福</div>
                            <p class="lixi-envelope-label">Lì Xì</p>
                            <p class="lixi-envelope-sublabel">Chữ Lộc Đầu Năm</p>
                            <span class="material-symbols-outlined lixi-envelope-icon">stat_3</span>
                        </div>
                    </div>
                    <p class="lixi-join-envelope-hint">{LANG.complete_form_hint}</p>
                </div>
                <div class="lixi-join-form-wrap">
                    <div class="lixi-join-form-card">
                        <div class="lixi-join-form-header">
                            <span class="material-symbols-outlined">person_add</span>
                            <h3>{LANG.registration_form}</h3>
                        </div>
                        <form method="post" action="{FORM_ACTION}">
                            <input type="hidden" name="submit" value="1">
                            <div class="lixi-join-form-group">
                                <label>{LANG.fullname} *</label>
                                <div class="lixi-input-icon">
                                    <span class="material-symbols-outlined">person</span>
                                    <input type="text" name="fullname" placeholder="Nguyễn Văn A" required>
                                </div>
                            </div>
                            <div class="lixi-join-form-row">
                                <div class="lixi-join-form-group">
                                    <label>{LANG.birthyear}</label>
                                    <input type="text" name="birthyear" placeholder="1995">
                                </div>
                                <div class="lixi-join-form-group">
                                    <label>{LANG.bank_name}</label>
                                    <select name="bank_name">
                                        <!-- BEGIN: bank_option -->
                                        <option value="{BANK_OPTION.value}">{BANK_OPTION.label}</option>
                                        <!-- END: bank_option -->
                                    </select>
                                </div>
                            </div>
                            <div class="lixi-join-form-group">
                                <label>{LANG.bank_account}</label>
                                <div class="lixi-input-icon">
                                    <span class="material-symbols-outlined">account_balance_wallet</span>
                                    <input type="text" name="bank_account" placeholder="0123456789">
                                </div>
                            </div>
                            <div class="lixi-join-form-submit">
                                <button type="submit" class="lixi-join-btn-submit">
                                    <span>{LANG.receive_lucky_money}</span>
                                    <span class="material-symbols-outlined">rocket_launch</span>
                                </button>
                                <p class="lixi-join-terms">{LANG.join_terms}</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: form -->

            <!-- BEGIN: success -->
            <div class="lixi-join-success-wrap">
                <div class="lixi-join-envelope-wrap lixi-join-envelope-success">
                    <div class="lixi-envelope lixi-envelope-clickable" id="lixi-envelope-reveal" data-amount="{RESULT_AMOUNT}" role="button" tabindex="0">
                        <div class="lixi-envelope-inner">
                            <div class="lixi-envelope-top"></div>
                            <div class="lixi-envelope-fu">福</div>
                            <p class="lixi-envelope-label">Lì Xì</p>
                            <p class="lixi-envelope-sublabel lixi-envelope-click-hint">{LANG.click_to_open}</p>
                            <div class="lixi-envelope-amount-wrap" style="display:none">
                                <p class="lixi-envelope-amount" id="lixi-reveal-amount">{RESULT_AMOUNT}</p>
                                <span class="lixi-envelope-vnd">VND</span>
                            </div>
                            <span class="material-symbols-outlined lixi-envelope-icon lixi-envelope-icon-bounce">stat_3</span>
                        </div>
                    </div>
                </div>
                <div class="lixi-join-reveal-panel" id="lixi-reveal-panel" style="display:none">
                    <div class="lixi-join-reveal-card">
                        <span class="material-symbols-outlined lixi-reveal-deco lixi-reveal-deco-1">celebration</span>
                        <span class="material-symbols-outlined lixi-reveal-deco lixi-reveal-deco-2">stars</span>
                        <span class="material-symbols-outlined lixi-reveal-deco lixi-reveal-deco-3">auto_awesome</span>
                        <div class="lixi-reveal-trophy">
                            <span class="material-symbols-outlined">emoji_events</span>
                        </div>
                        <h2 class="lixi-reveal-title">{LANG.congratulations}</h2>
                        <p class="lixi-reveal-desc">{LANG.opened_envelope}</p>
                        <div class="lixi-reveal-amount-card">
                            <p class="lixi-reveal-amount-label">{LANG.you_won}</p>
                            <p class="lixi-reveal-amount-value"><span id="lixi-reveal-amount-value">{RESULT_AMOUNT}</span> <span class="lixi-reveal-vnd">VND</span></p>
                        </div>
                        <div class="lixi-reveal-btns">
                            <a href="javascript:void(0)" class="lixi-reveal-btn lixi-reveal-btn-primary" id="lixi-share-btn" data-url="{FORM_ACTION}" data-amount="{RESULT_AMOUNT}" data-title="{EVENT.title}">
                                <span class="material-symbols-outlined">share</span>
                                {LANG.share_result}
                            </a>
                            <a href="{MENU.url_history}" class="lixi-reveal-btn lixi-reveal-btn-secondary">{LANG.view_history}</a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            (function() {
                var env = document.getElementById('lixi-envelope-reveal');
                var panel = document.getElementById('lixi-reveal-panel');
                if (!env || !panel) return;
                var opened = false;
                function openEnvelope() {
                    if (opened) return;
                    opened = true;
                    env.classList.add('lixi-envelope-opened');
                    var hint = env.querySelector('.lixi-envelope-click-hint');
                    if (hint) hint.style.display = 'none';
                    var amountWrap = env.querySelector('.lixi-envelope-amount-wrap');
                    var icon = env.querySelector('.lixi-envelope-icon-bounce');
                    if (amountWrap) amountWrap.style.display = 'block';
                    if (icon) icon.style.display = 'none';
                    panel.style.display = 'block';
                    panel.classList.add('lixi-reveal-panel-visible');
                }
                env.addEventListener('click', openEnvelope);
                env.addEventListener('keydown', function(e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openEnvelope(); } });
                var shareBtn = document.getElementById('lixi-share-btn');
                if (shareBtn) {
                    shareBtn.addEventListener('click', function() {
                        var url = shareBtn.getAttribute('data-url') || window.location.href;
                        var amount = shareBtn.getAttribute('data-amount') || '';
                        var title = shareBtn.getAttribute('data-title') || '';
                        var text = (amount ? 'Tôi vừa nhận được ' + amount + ' VND từ ' + title + '! ' : '') + url;
                        if (navigator.share) {
                            navigator.share({ title: title, text: text, url: url }).catch(function(){});
                        } else {
                            navigator.clipboard.writeText(text).then(function(){ alert('Đã sao chép link!'); }).catch(function(){});
                        }
                    });
                }
            })();
            </script>
            <!-- END: success -->

            <!-- BEGIN: already_joined -->
            <div class="lixi-alert lixi-alert-info">Bạn đã tham gia sự kiện này rồi.</div>
            <!-- END: already_joined -->

            <!-- BEGIN: full -->
            <div class="lixi-alert lixi-alert-warning">Sự kiện đã đủ người tham gia.</div>
            <!-- END: full -->

            <div id="event-rules" class="lixi-join-rules">
                <h4>{LANG.event_rules}</h4>
                <p>{EVENT.description}</p>
            </div>
        </div>
    </main>
</div>
<!-- END: main -->
