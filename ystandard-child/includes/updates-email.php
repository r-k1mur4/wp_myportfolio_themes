<?php
// テーマの自動更新の通知メールを停止
add_filter('auto_theme_update_send_email', '__return_false');
// プラグインの自動更新の通知メールを停止
add_filter('auto_plugin_update_send_email', '__return_false');
