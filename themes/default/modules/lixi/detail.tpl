<!-- BEGIN: main -->
<div class="lixi-wrapper">
    <!-- Top Navigation -->
    <header class="lixi-header lixi-header-compact">
        <div class="lixi-header-brand">
            <div class="lixi-logo">
                <span class="material-symbols-outlined">celebration</span>
            </div>
            <h2 class="lixi-brand-text">{LANG.lixi_title}</h2>
            <nav class="lixi-topnav">
                <a href="{MENU.url_main}">{LANG.home}</a>
                <a href="{MENU.url_history}">{LANG.history}</a>
                <a class="active" href="{MENU.url_ranking}">{LANG.ranking}</a>
                <a href="#event-rules">{LANG.event_rules}</a>
            </nav>
        </div>
        <div class="lixi-header-actions">
            <div class="lixi-icon-btns">
                <button type="button" class="lixi-icon-btn" aria-label="Thông báo">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button type="button" class="lixi-icon-btn" aria-label="Cài đặt">
                    <span class="material-symbols-outlined">settings</span>
                </button>
            </div>
            <a class="lixi-balance-pill" href="{USER_LINK}" title="Tài khoản">
                <span class="lixi-balance-amount">{USER_BALANCE}đ</span>
                <img class="lixi-avatar" src="{USER_AVATAR}" alt="Avatar" width="28" height="28">
            </a>
        </div>
    </header>

    <main class="lixi-main lixi-ranking-main">
        <div class="lixi-ranking-content">
            <!-- Hero -->
            <div class="lixi-ranking-hero lixi-detail-hero">
                <div class="lixi-ranking-hero-left">
                    <h1 class="lixi-ranking-title">{LANG.ranking_top_earners}</h1>
                    <p class="lixi-ranking-desc">{LANG.ranking_desc}</p>
                    <p class="lixi-ranking-current">{RANKING_FOR}</p>
                    <!-- BEGIN: event_switch -->
                    <div class="lixi-ranking-switch">
                        <span class="lixi-ranking-filter-label">{LANG.ranking_event_filter_label}:</span>
                        <select class="lixi-ranking-select" onchange="if(this.value){window.location=this.value;}">
                            <option value="{FILTER_ALL.url}">{LANG.ranking_for_all}</option>
                            <!-- BEGIN: loop -->
                            <option value="{FILTER_EVENT.url}"{FILTER_EVENT.selected}>{FILTER_EVENT.title}</option>
                            <!-- END: loop -->
                        </select>
                    </div>
                    <!-- END: event_switch -->
                </div>
                <a href="{MENU.url_create}" class="lixi-ranking-btn-create">
                    <span class="material-symbols-outlined">add_circle</span>
                    {LANG.create_event}
                </a>
            </div>

            <!-- Top 3 Podium -->
            <!-- BEGIN: podium -->
            <div class="lixi-ranking-podium">
                <!-- Silver - Rank 2 -->
                <!-- BEGIN: silver -->
                <div class="lixi-podium-card lixi-podium-silver">
                    <div class="lixi-podium-avatar" style="{PODIUM_SILVER.avatar_style}">{PODIUM_SILVER.initial}</div>
                    <div class="lixi-podium-body">
                        <span class="material-symbols-outlined lixi-podium-icon lixi-podium-icon-silver">military_tech</span>
                        <h3 class="lixi-podium-name">{PODIUM_SILVER.fullname}</h3>
                        <p class="lixi-podium-amount">{PODIUM_SILVER.total_fmt}đ</p>
                        <span class="lixi-podium-badge lixi-podium-badge-silver">{LANG.silver_medal}</span>
                    </div>
                </div>
                <!-- END: silver -->

                <!-- Gold - Rank 1 -->
                <!-- BEGIN: gold -->
                <div class="lixi-podium-card lixi-podium-gold">
                    <div class="lixi-podium-avatar lixi-podium-avatar-gold" style="{PODIUM_GOLD.avatar_style}">{PODIUM_GOLD.initial}</div>
                    <div class="lixi-podium-body">
                        <span class="material-symbols-outlined lixi-podium-icon lixi-podium-icon-gold">workspace_premium</span>
                        <h3 class="lixi-podium-name">{PODIUM_GOLD.fullname}</h3>
                        <p class="lixi-podium-amount">{PODIUM_GOLD.total_fmt}đ</p>
                        <span class="lixi-podium-badge lixi-podium-badge-gold">{LANG.champion}</span>
                    </div>
                </div>
                <!-- END: gold -->

                <!-- Bronze - Rank 3 -->
                <!-- BEGIN: bronze -->
                <div class="lixi-podium-card lixi-podium-bronze">
                    <div class="lixi-podium-avatar" style="{PODIUM_BRONZE.avatar_style}">{PODIUM_BRONZE.initial}</div>
                    <div class="lixi-podium-body">
                        <span class="material-symbols-outlined lixi-podium-icon lixi-podium-icon-bronze">looks_3</span>
                        <h3 class="lixi-podium-name">{PODIUM_BRONZE.fullname}</h3>
                        <p class="lixi-podium-amount">{PODIUM_BRONZE.total_fmt}đ</p>
                        <span class="lixi-podium-badge lixi-podium-badge-bronze">{LANG.bronze_medal}</span>
                    </div>
                </div>
                <!-- END: bronze -->
            </div>
            <!-- END: podium -->

            <!-- Table -->
            <!-- BEGIN: table -->
            <div class="lixi-ranking-table-card">
                <div class="lixi-ranking-table-controls">
                    <div class="lixi-ranking-search-wrap">
                        <span class="material-symbols-outlined">search</span>
                        <input id="lixi-rank-search" type="text" placeholder="{LANG.search_users}">
                    </div>
                </div>

                <div class="lixi-ranking-table-wrap">
                    <table class="lixi-ranking-table" id="lixi-ranking-table">
                        <thead>
                            <tr>
                                <th>{LANG.rank}</th>
                                <th>{LANG.lucky_user}</th>
                                <th>{LANG.total_received_col}</th>
                                <th>{LANG.events_joined}</th>
                                <th>{LANG.last_gift_from}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BEGIN: loop -->
                            <tr class="lixi-ranking-row">
                                <td><span class="lixi-ranking-rank">{ROW.rank}</span></td>
                                <td>
                                    <div class="lixi-ranking-user-cell">
                                        <div class="lixi-ranking-row-avatar" style="{ROW.avatar_style}">{ROW.initial}</div>
                                        <span class="lixi-ranking-row-name lixi-ranking-name">{ROW.fullname}</span>
                                    </div>
                                </td>
                                <td><span class="lixi-ranking-row-amount">{ROW.total_fmt}đ</span></td>
                                <td class="lixi-ranking-row-events">{ROW.events_joined_text}</td>
                                <td class="lixi-ranking-row-last">{ROW.last_ago}</td>
                            </tr>
                            <!-- END: loop -->
                            <!-- BEGIN: empty -->
                            <tr>
                                <td colspan="5" class="lixi-ranking-empty">{LANG.no_leaderboard}</td>
                            </tr>
                            <!-- END: empty -->
                        </tbody>
                    </table>
                </div>

                <div class="lixi-ranking-pagination">
                    <p class="lixi-ranking-pagination-info">{SHOWING_RANKING}</p>
                </div>
            </div>
            <!-- END: table -->

            <!-- Stats Footer -->
            <div class="lixi-ranking-stats">
                <div class="lixi-ranking-stat-card">
                    <span class="material-symbols-outlined">volunteer_activism</span>
                    <p class="lixi-ranking-stat-value">{STATS.total_distributed_fmt} đ</p>
                    <p class="lixi-ranking-stat-label">{LANG.total_distributed_stat}</p>
                </div>
                <div class="lixi-ranking-stat-card">
                    <span class="material-symbols-outlined">groups</span>
                    <p class="lixi-ranking-stat-value">{STATS.total_participants_fmt}</p>
                    <p class="lixi-ranking-stat-label">{LANG.active_participants}</p>
                </div>
                <div class="lixi-ranking-stat-card">
                    <span class="material-symbols-outlined">event_available</span>
                    <p class="lixi-ranking-stat-value">{STATS.events_hosted_fmt}</p>
                    <p class="lixi-ranking-stat-label">{LANG.events_hosted}</p>
                </div>
                <div class="lixi-ranking-stat-card">
                    <span class="material-symbols-outlined">trending_up</span>
                    <p class="lixi-ranking-stat-value">{STATS.avg_amount_fmt} đ</p>
                    <p class="lixi-ranking-stat-label">{LANG.avg_lucky_amount}</p>
                </div>
            </div>

            <div id="event-rules" class="lixi-detail-rules">
                <h3 class="lixi-detail-rules-title">{LANG.event_rules}</h3>
                <p class="lixi-detail-rules-desc">{EVENT.description}</p>
            </div>
        </div>
    </main>
</div>

<script>
(function() {
    var input = document.getElementById('lixi-rank-search');
    var table = document.getElementById('lixi-ranking-table');
    if (!input || !table) return;
    input.addEventListener('input', function() {
        var q = (input.value || '').toLowerCase().trim();
        var rows = table.querySelectorAll('tbody tr.lixi-ranking-row');
        rows.forEach(function(tr) {
            var name = tr.querySelector('.lixi-ranking-name');
            var text = name ? (name.textContent || '').toLowerCase() : '';
            tr.style.display = (!q || text.indexOf(q) !== -1) ? '' : 'none';
        });
    });
})(); 
</script>
<!-- END: main -->
