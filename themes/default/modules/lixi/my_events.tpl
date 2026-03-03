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
                <a class="active" href="{MENU.url_my_events}">{LANG.my_events}</a>
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

    <main class="lixi-main lixi-myevents-main">
        <div class="lixi-myevents-content">
                <div class="lixi-myevents-page-header">
                    <div>
                        <h2 class="lixi-myevents-page-title">{LANG.my_events}</h2>
                        <p class="lixi-myevents-page-desc">{LANG.my_events_desc}</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="lixi-myevents-stats">
                    <div class="lixi-myevents-stat-card">
                        <div class="lixi-myevents-stat-head">
                            <span class="lixi-myevents-stat-label">{LANG.total_events}</span>
                            <div class="lixi-myevents-stat-icon lixi-myevents-stat-icon-blue">
                                <span class="material-symbols-outlined">event</span>
                            </div>
                        </div>
                        <div class="lixi-myevents-stat-value">{STATS.total_events}</div>
                    </div>
                    <div class="lixi-myevents-stat-card">
                        <div class="lixi-myevents-stat-head">
                            <span class="lixi-myevents-stat-label">{LANG.total_distributed}</span>
                            <div class="lixi-myevents-stat-icon lixi-myevents-stat-icon-primary">
                                <span class="material-symbols-outlined">payments</span>
                            </div>
                        </div>
                        <div class="lixi-myevents-stat-value">{STATS.total_distributed_fmt} <span class="lixi-myevents-stat-unit">VND</span></div>
                    </div>
                    <div class="lixi-myevents-stat-card">
                        <div class="lixi-myevents-stat-head">
                            <span class="lixi-myevents-stat-label">{LANG.claims_ratio}</span>
                            <div class="lixi-myevents-stat-icon lixi-myevents-stat-icon-orange">
                                <span class="material-symbols-outlined">pie_chart</span>
                            </div>
                        </div>
                        <div class="lixi-myevents-stat-value">{STATS.claims_ratio}% <span class="lixi-myevents-stat-unit">{STATS.claims_ratio_text}</span></div>
                    </div>
                    <div class="lixi-myevents-stat-card">
                        <div class="lixi-myevents-stat-head">
                            <span class="lixi-myevents-stat-label">{LANG.active_envelopes}</span>
                            <div class="lixi-myevents-stat-icon lixi-myevents-stat-icon-green">
                                <span class="material-symbols-outlined">drafts</span>
                            </div>
                        </div>
                        <div class="lixi-myevents-stat-value">{STATS.active_envelopes} <span class="lixi-myevents-stat-unit">phong bì</span></div>
                    </div>
                </div>

                <!-- BEGIN: has_events -->
                <div class="lixi-myevents-table-wrap">
                    <table class="lixi-myevents-table">
                        <thead>
                            <tr>
                                <th>{LANG.event_name}</th>
                                <th>Trạng thái</th>
                                <th>{LANG.claims}</th>
                                <th>{LANG.total_distributed}</th>
                                <th class="lixi-myevents-th-actions">{LANG.actions}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="lixi-myevents-row{EVENT.row_class}">
                                <td>
                                    <div class="lixi-myevents-event-cell">
                                        <div class="lixi-myevents-event-avatar" style="background:{EVENT.avatar_color}">{EVENT.avatar_initials}</div>
                                        <div>
                                            <p class="lixi-myevents-event-title">{EVENT.title}</p>
                                            <p class="lixi-myevents-event-date">Tạo {EVENT.add_time_fmt}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="lixi-myevents-badge lixi-myevents-badge-{EVENT.status_class}">{EVENT.status_label}</span>
                                </td>
                                <td>
                                    <div class="lixi-myevents-progress-wrap">
                                        <div class="lixi-myevents-progress-head">
                                            <span class="lixi-myevents-progress-pct">{EVENT.progress}%</span>
                                            <span class="lixi-myevents-progress-count">{EVENT.num_participants}/{EVENT.num_envelopes}</span>
                                        </div>
                                        <div class="lixi-myevents-progress-bar">
                                            <div class="lixi-myevents-progress-fill" style="width:{EVENT.progress}%;background:{EVENT.avatar_color}"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="lixi-myevents-amount">{EVENT.total_distributed_fmt} <span class="lixi-myevents-vnd">VND</span></td>
                                <td class="lixi-myevents-actions">
                                    <a href="{EVENT.detail_url}" class="lixi-myevents-action-btn" title="{LANG.view_details}">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                    <a href="{EVENT.link}" class="lixi-myevents-action-btn" title="{LANG.share}" target="_blank">
                                        <span class="material-symbols-outlined">share</span>
                                    </a>
                                    <a href="{EVENT.url_edit}" class="lixi-myevents-action-btn" title="Sửa">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="{EVENT.url_export}" class="lixi-myevents-action-btn" title="Xuất Excel">
                                        <span class="material-symbols-outlined">file_download</span>
                                    </a>
                                </td>
                            </tr>
                            <!-- END: loop -->
                        </tbody>
                    </table>
                </div>
                <!-- END: has_events -->

                <!-- BEGIN: empty -->
                <div class="lixi-myevents-empty">
                    <p>{LANG.no_events}</p>
                    <a href="{MENU.url_create}" class="lixi-myevents-btn-create">{LANG.create_event}</a>
                </div>
                <!-- END: empty -->

                <!-- Decorative Banner -->
                <div class="lixi-myevents-banner">
                    <div class="lixi-myevents-banner-content">
                        <h3 class="lixi-myevents-banner-title">{LANG.celebrate_title}</h3>
                        <p class="lixi-myevents-banner-desc">{LANG.celebrate_desc}</p>
                        <a href="{MENU.url_create}" class="lixi-myevents-banner-btn">{LANG.get_festive_now}</a>
                    </div>
                    <div class="lixi-myevents-banner-icon">
                        <span class="material-symbols-outlined">redeem</span>
                    </div>
                </div>
            </div>
    </main>
</div>
<!-- END: main -->
