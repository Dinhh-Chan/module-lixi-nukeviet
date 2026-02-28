<!-- BEGIN: main -->
<div class="lixi-wrapper">
    <!-- Top Navigation Bar -->
    <header class="lixi-header">
        <div class="lixi-header-brand">
            <div class="lixi-logo">
                <span class="material-symbols-outlined">celebration</span>
            </div>
            <h2 class="lixi-brand-text">NukeViet <span>Lì xì</span></h2>
            <div class="lixi-search">
                <span class="material-symbols-outlined">search</span>
                <input type="text" placeholder="{LANG.search_events}" disabled>
            </div>
        </div>
        <div class="lixi-header-actions">
            <nav class="lixi-nav">
                <a class="active" href="{MENU.url_main}">{LANG.home}</a>
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

    <main class="lixi-main">
        <!-- Hero Banner -->
        <div class="lixi-hero">
            <div class="lixi-hero-bg"></div>
            <div class="lixi-hero-content">
                <span class="lixi-hero-tag">{LANG.hero_tag}</span>
                <h1>{LANG.hero_title}</h1>
                <p>{LANG.hero_desc}</p>
                <div class="lixi-hero-btns">
                    <a href="{MENU.url_create}" class="btn-primary-custom">{LANG.start_giving}</a>
                    <a href="{MENU.url_main}" class="btn-outline-custom">{LANG.how_it_works}</a>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="lixi-stats">
            <div class="lixi-stat-card">
                <div class="lixi-stat-icon"><span class="material-symbols-outlined">payments</span></div>
                <div>
                    <p class="lixi-stat-label">{LANG.total_distributed}</p>
                    <p class="lixi-stat-value">{STATS.total_distributed_fmt} <span style="font-size:0.75rem">VND</span></p>
                </div>
            </div>
            <div class="lixi-stat-card">
                <div class="lixi-stat-icon"><span class="material-symbols-outlined">groups</span></div>
                <div>
                    <p class="lixi-stat-label">{LANG.participants}</p>
                    <p class="lixi-stat-value">{STATS.total_participants_fmt}</p>
                </div>
            </div>
            <div class="lixi-stat-card">
                <div class="lixi-stat-icon"><span class="material-symbols-outlined">mail</span></div>
                <div>
                    <p class="lixi-stat-label">{LANG.envelopes_sent}</p>
                    <p class="lixi-stat-value">{STATS.total_envelopes_fmt}</p>
                </div>
            </div>
            <div class="lixi-stat-card">
                <div class="lixi-stat-icon"><span class="material-symbols-outlined">emoji_events</span></div>
                <div>
                    <p class="lixi-stat-label">{LANG.luckiest_streak}</p>
                    <p class="lixi-stat-value">x5</p>
                </div>
            </div>
        </div>

        <!-- Active Events -->
        <div class="lixi-events-header">
            <div class="lixi-events-title">
                <h2>{LANG.active_events}</h2>
                <span class="lixi-events-badge">{EVENT_COUNT} {LANG.ongoing}</span>
            </div>
            <a href="{MENU.url_main}" class="lixi-view-all">
                {LANG.view_all} <span class="material-symbols-outlined" style="font-size:1.125rem;margin-left:0.25rem">chevron_right</span>
            </a>
        </div>

        <div class="lixi-events-grid">
            <!-- BEGIN: empty_events -->
            <div class="lixi-empty-events">
                <p>{LANG.no_events}</p>
                <a href="{MENU.url_create}" class="lixi-btn-create">{LANG.create_event}</a>
            </div>
            <!-- END: empty_events -->
            <!-- BEGIN: loop -->
            <div class="lixi-event-card">
                <div class="lixi-event-img">
                    <div class="lixi-event-img-placeholder">
                        <span class="material-symbols-outlined">redeem</span>
                    </div>
                    <!-- BEGIN: countdown -->
                    <div class="lixi-event-countdown">
                        <span class="material-symbols-outlined">timer</span>
                        <span class="lixi-countdown-js" data-seconds="{EVENT.countdown_seconds}">{EVENT.countdown_formatted}</span>
                    </div>
                    <!-- END: countdown -->
                </div>
                <div class="lixi-event-body">
                    <h3 class="lixi-event-title"><a href="{EVENT.join_url}" style="color:inherit;text-decoration:none">{EVENT.title}</a></h3>
                    <div class="lixi-event-progress">
                        <div class="lixi-event-progress-header">
                            <span>{LANG.available_envelopes}</span>
                            <span>{EVENT.remaining}/{EVENT.num_envelopes}</span>
                        </div>
                        <div class="lixi-event-progress-bar">
                            <div class="lixi-event-progress-fill" style="width:{EVENT.progress}%"></div>
                        </div>
                    </div>
                    <a href="{EVENT.join_url}" class="lixi-btn-join">{LANG.join}</a>
                </div>
            </div>
            <!-- END: loop -->
        </div>

        <!-- Leaderboard -->
        <!-- BEGIN: leaderboard -->
        <div class="lixi-leaderboard">
            <div class="lixi-leaderboard-inner">
                <div class="lixi-leaderboard-content">
                    <h2>{LANG.luckiest_participants}</h2>
                    <p class="lixi-leaderboard-desc">{LANG.luckiest_desc}</p>
                    <div class="lixi-leader-list">
                        <!-- BEGIN: loop -->
                        <div class="lixi-leader-item{LEADER.leader_class}">
                            <span class="lixi-leader-rank">{LEADER.stt}</span>
                            <div class="lixi-leader-avatar">{LEADER.initial}</div>
                            <span class="lixi-leader-name">{LEADER.fullname}</span>
                            <span class="lixi-leader-amount">{LEADER.total_fmt} VND</span>
                        </div>
                        <!-- END: loop -->
                        <!-- BEGIN: empty_leaderboard -->
                        <p class="lixi-empty-leaderboard">{LANG.no_leaderboard}</p>
                        <!-- END: empty_leaderboard -->
                    </div>
                </div>
                <div class="lixi-leaderboard-icon">
                    <div style="position:relative">
                        <div class="lixi-medal-glow"></div>
                        <span class="material-symbols-outlined">military_tech</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: leaderboard -->
    </main>
</div>
<!-- END: main -->
