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
                <a class="active" href="{MENU.url_history}">{LANG.history}</a>
                <a href="{MENU.url_ranking}">{LANG.ranking}</a>
            </nav>
            <a href="{MENU.url_create}" class="lixi-btn-create">
                <span class="material-symbols-outlined" style="margin-right:0.5rem;font-size:1.125rem">add_circle</span>
                {LANG.create_event}
            </a>
            <a href="{USER_LINK}" title="Tài khoản"><img class="lixi-avatar" src="{USER_AVATAR}" alt="Avatar" width="40" height="40"></a>
        </div>
    </header>

    <main class="lixi-main lixi-history-main">
        <div class="lixi-history-content">
            <!-- Page Title & Summary -->
            <div class="lixi-history-header">
                <div class="lixi-history-header-left">
                    <div class="lixi-history-tag">
                        <span class="material-symbols-outlined">history</span>
                        <span>{LANG.history_rewards_log}</span>
                    </div>
                    <h1 class="lixi-history-title">{LANG.history_personal_title}</h1>
                    <p class="lixi-history-desc">{LANG.history_desc}</p>
                </div>
                <div class="lixi-history-summary-card">
                    <div class="lixi-history-summary-icon">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <p class="lixi-history-summary-label">{LANG.total_received}</p>
                    <div class="lixi-history-summary-value">
                        <span class="lixi-history-summary-amount">{TOTAL_RECEIVED}</span>
                        <span class="lixi-history-summary-unit">VND</span>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="lixi-history-table-card">
                <!-- Filters -->
                <div class="lixi-history-filters">
                    <div class="lixi-history-filter-btns">
                        <button type="button" class="lixi-history-btn-filter">
                            <span class="material-symbols-outlined">filter_list</span>
                            {LANG.filter}
                        </button>
                        <button type="button" class="lixi-history-btn-period">{LANG.this_month}</button>
                    </div>
                    <p class="lixi-history-showing">{SHOWING_ENTRIES}</p>
                </div>

                <!-- Table -->
                <div class="lixi-history-table-wrap">
                    <table class="lixi-history-table">
                        <thead>
                            <tr>
                                <th>{LANG.event_name}</th>
                                <th>{LANG.date_time}</th>
                                <th class="lixi-history-th-right">{LANG.amount_received}</th>
                                <th class="lixi-history-th-center">{LANG.payment_status}</th>
                                <th class="lixi-history-th-actions"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="lixi-history-row">
                                <td>
                                    <div class="lixi-history-event-cell">
                                        <div class="lixi-history-event-icon {ROW.icon_class}">
                                            <span class="material-symbols-outlined">{ROW.icon}</span>
                                        </div>
                                        <a href="{ROW.detail_url}" class="lixi-history-event-title">{ROW.event_title}</a>
                                    </div>
                                </td>
                                <td>
                                    <span class="lixi-history-date">{ROW.join_date}</span>
                                    <span class="lixi-history-time">{ROW.join_time_fmt}</span>
                                </td>
                                <td class="lixi-history-amount-cell">
                                    {ROW.amount_received_fmt} <span class="lixi-history-vnd">VND</span>
                                </td>
                                <td>
                                    <div class="lixi-history-status-wrap">
                                        <span class="lixi-history-badge lixi-history-badge-success">
                                            <span class="lixi-history-badge-dot"></span>
                                            {LANG.transferred}
                                        </span>
                                    </div>
                                </td>
                                <td class="lixi-history-actions-cell">
                                    <button type="button" class="lixi-history-btn-more" title="Thao tác">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <!-- END: loop -->
                            <!-- BEGIN: empty -->
                            <tr>
                                <td colspan="5" class="lixi-history-empty-cell">{LANG.no_history}</td>
                            </tr>
                            <!-- END: empty -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Footer -->
            <div class="lixi-history-footer">
                <div class="lixi-history-footer-left">
                    <div class="lixi-history-footer-icon">
                        <span class="material-symbols-outlined">help</span>
                    </div>
                    <div>
                        <p class="lixi-history-footer-title">{LANG.questions_payments}</p>
                        <p class="lixi-history-footer-desc">{LANG.payments_help_desc}</p>
                    </div>
                </div>
                <a href="{MENU.url_ranking}" class="lixi-history-footer-btn">{LANG.view_detailed_report}</a>
            </div>
        </div>
    </main>
</div>
<!-- END: main -->
