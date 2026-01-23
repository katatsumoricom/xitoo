<?php
// microcms データ取得
// ==================================================
// 設定 (APIキーなどはここで一元管理)
// ==================================================
define('MICROCMS_API_KEY', 'BYrIGg2JIyTUvA7H2637PRHRdF2rGLiiuejg');
define('MICROCMS_SERVICE_ID', 'xitoo');

// ==================================================
// 共通関数: microCMSからデータを取得する
// $endpoint: 'profile' や 'information' など
// $params: ['limit' => 5] などの追加パラメータ
// ==================================================
function fetchMicroCMS($endpoint, $params = [])
{
    // パラメータがあればクエリ文字列を作成
    $query = !empty($params) ? '?' . http_build_query($params) : '';

    // URL作成
    $url = "https://" . MICROCMS_SERVICE_ID . ".microcms.io/api/v1/{$endpoint}" . $query;

    // ヘッダー設定
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "X-MICROCMS-API-KEY: " . MICROCMS_API_KEY
        ]
    ];

    // 取得実行
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    // エラー時は空配列を返す（サイトを落とさないため）
    if ($response === false) {
        return [];
    }

    return json_decode($response, true);
}

// ==================================================
// ページ内で使うデータをここでまとめて取得しておく
// ==================================================

// 1. プロフィール (オブジェクト形式)
$profileData = fetchMicroCMS('profile');

// 2. インフォメーション (リスト形式)
// ※トップページ用なので最新3件だけ取得する例
$infoData = fetchMicroCMS('information', ['limit' => 3]);

// 3. Works
$worksData = fetchMicroCMS('works', ['limit' => 100]);
$worksContents = $worksData['contents'] ?? [];

$works = [];
foreach ($worksContents as $item) {
    // カテゴリー配列の0番目を取得 (例: 'music', 'game')
    $catKey = $item['category'][0] ?? null;
    if ($catKey) {
        $works[$catKey] = $item;
    }
}

/**
 * 現在のページ番号をURLパラメータから安全に取得する関数
 * 例: ?page=2 なら 2 を返す。なければ 1 を返す。
 */
function getCurrentPage()
{
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = (int)$_GET['page'];
        return $page > 0 ? $page : 1;
    }
    return 1;
}

/**
 * ページネーション計算用ヘルパー
 * 全件数と1ページあたりの件数から、総ページ数を算出
 */
function getTotalPages($totalCount, $limit)
{
    if ($totalCount === 0) return 1;
    return ceil($totalCount / $limit);
}
