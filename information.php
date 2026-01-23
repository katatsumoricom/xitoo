<?php include('components/head.php'); ?>
<?php
// 共通ファイルを読み込み
require_once('components/microcmsShow.php');

// URLに 'id' パラメータがあるかチェック
$content_id = isset($_GET['id']) ? $_GET['id'] : null;

// 変数の初期化
$is_detail_mode = false;
$detail_post = [];

if ($content_id) {
  // ----------------------------------------------
  // A. 詳細モード (記事単体表示)
  // ----------------------------------------------
  $is_detail_mode = true;

  // 単体取得のエンドポイントは 'information/記事ID' になります
  // 第2引数は不要なので空配列
  $detail_post = fetchMicroCMS('information/' . $content_id);
} else {
  // ==================================================
  // 0. カテゴリー設定 (ここを手動で設定します！)
  // ==================================================
  // microCMSのセレクトフィールドで設定した「値」と、表示したい「名前」を定義してください
  $categoryList = [
    // 'セレクトフィールドの値' => '画面に表示する名前'
    'RELEASE' => 'RELEASE',
    'EVENT' => 'EVENT',
    'GOODS' => 'GOODS',
    'NEWS' => 'NEWS',
    'COLLAB' => 'COLLAB',
  ];

  // ==================================================
  // 1. パラメータ取得 & 設定
  // ==================================================
  $limit = 3; // 1ページに表示する件数
  $page = getCurrentPage(); // 現在のページ番号 (1, 2, 3...)
  $offset = ($page - 1) * $limit; // 何件スキップするか計算

  // URLからカテゴリーIDを取得 (例: ?category=xxxxx)
  $current_category_id = isset($_GET['category']) ? $_GET['category'] : null;

  // ==================================================
  // 2. microCMS データ取得
  // ==================================================

  // APIパラメータ設定
  $params = [
    'limit'  => $limit,
    'offset' => $offset,
    'orders' => '-publishedAt' // 公開日順（降順）
  ];

  // カテゴリーが選択されている場合、filtersパラメータを追加
  // microCMSのフィルタ形式: fieldId[equals]value
  if ($current_category_id && array_key_exists($current_category_id, $categoryList)) {
    // セレクトフィールドが「複数選択」の場合は [contains]、「単一選択」の場合は [equals] を使います
    // ここでは単一選択として [equals] を使用
    $params['filters'] = "categories[contains]{$current_category_id}";
  }

  // データ取得実行 (endpoint名は 'information' と想定)
  $data = fetchMicroCMS('information', $params);

  // データの取り出し & ページネーション計算
  $contents = $data['contents'] ?? [];
  $totalCount = $data['totalCount'] ?? 0;
  $totalPages = getTotalPages($totalCount, $limit);
}

// ==================================================
// 3. リンク生成用ヘルパー関数
// (ページ切り替え時にもカテゴリー情報を維持するため)
// ==================================================
function buildUrl($page, $categoryId = null)
{
  $query = ['page' => $page];
  if ($categoryId) {
    $query['category'] = $categoryId;
  }
  // http_build_queryが ?page=2&category=abc を自動生成してくれます
  return '?' . http_build_query($query);
}

?>

<div class="c-layout__bgnoise"></div>
<div class="c-layout">

  <?php include('components/header.php'); ?>

  <main class="c-layout__container c-layout__subpage p-information">
    <h2><a href="information"><img src="./static/img/information.svg" alt="INFORMATION" /></a></h2>

    <?php
    // ====================================================================
    // 表示パターン A: 詳細モード (id指定がある場合)
    // ====================================================================
    if ($is_detail_mode):
    ?>
      <div class="c-filter__back">
        <a href="information" class="c-textlink">&lt; BACK TO LIST</a>
      </div>
      <?php if (!empty($detail_post)): ?>
        <div class="c-layout__content p-information__content">
          <div class="p-information__flex">
            <p><?php echo date('Y.m.d', strtotime($detail_post['data'])); ?></p>
            <?php $catVal = is_array($detail_post['categories']) ? $detail_post['categories'][0] : $detail_post['categories'];
            echo '<a href="?category=' . htmlspecialchars($catVal) . '" class="c-textlink c-category-tag">' . htmlspecialchars($catVal) . '</a>';
            ?>
            </a>
          </div>

          <h3><?php echo $detail_post['title']; ?></h3>
          <section>
            <?php if (isset($detail_post['thumb']['url'])): ?>
              <figure>
                <img
                  src="<?php echo $detail_post['thumb']['url']; ?>"
                  alt="サムネイル画像" />
              </figure>
            <?php endif; ?>
            <?php
            if (isset($detail_post['content'])) {
              echo $detail_post['content'];
            } ?>
          </section>
          <?php if (isset($detail_post['link']['url'])): ?>
            <p class="p-information__flex"><span>関連リンク：</span><a href="<?php echo $detail_post['link']['url']; ?>" class="c-textlink" target="_blank">
                <?php echo $detail_post['link']['title'] ?? $detail_post['link']['url']; ?>
              </a></p>
          <?php endif; ?>
        </div>
        <!-- /.c-layout__content -->
      <?php endif ?>

    <?php
    // ====================================================================
    // 表示パターン B: 一覧モード (通常時)
    // ====================================================================
    else: ?>
      <nav class="c-filter__list">
        <a href="?" class="c-textlink c-filter__tag <?php echo $current_category_id === null ? 'is-active' : ''; ?>">
          ALL
        </a>

        <?php foreach ($categoryList as $key => $label): ?>
          <a href="?category=<?php echo htmlspecialchars($key); ?>"
            class="c-textlink c-filter__tag <?php echo $current_category_id === $key ? 'is-active' : ''; ?>">
            <?php echo htmlspecialchars($label); ?>
          </a>
        <?php endforeach; ?>
      </nav>
      <?php if (!empty($contents)):
        foreach ($contents as $post): ?>
          <div class="c-layout__content p-information__content">
            <div class="p-information__flex">
              <p><?php echo date('Y.m.d', strtotime($post['data'])); ?></p>
              <?php $catVal = is_array($post['categories']) ? $post['categories'][0] : $post['categories'];
              echo '<a href="?category=' . htmlspecialchars($catVal) . '" class="c-textlink c-category-tag">' . htmlspecialchars($catVal) . '</a>';
              ?>
              </a>
            </div>

            <h3><?php echo $post['title']; ?></h3>
            <section>
              <?php if (isset($post['thumb']['url'])): ?>
                <figure>
                  <img
                    src="<?php echo $post['thumb']['url']; ?>"
                    alt="サムネイル画像" />
                </figure>
              <?php endif; ?>
              <?php
              if (isset($post['content'])) {
                echo $post['content'];
              } ?>
            </section>
            <?php if (isset($post['link']['url'])): ?>
              <p class="p-information__flex"><span>関連リンク：</span><a href="<?php echo $post['link']['url']; ?>" class="c-textlink" target="_blank">
                  <?php echo $post['link']['title'] ?? $post['link']['url']; ?>
                </a></p>
            <?php endif; ?>
          </div>
          <!-- /.c-layout__content -->
        <?php endforeach; ?>
      <?php else: ?>
        <div class="c-layout__content p-information__content" style="display: grid; place-items: center; min-height: 200px;">
          <p>現在公開されている記事はありません。</p>
        </div>
      <?php endif ?>

      <?php if ($totalPages > 1): ?>
        <nav class="c-filter__pagination">

          <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="c-textlink">PREV</a>
          <?php else: ?>
            <span class="is-active">PREV</span>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $page): ?>
              <span class="num is-active"><?php echo $i; ?></span>
            <?php else: ?>
              <a href="?page=<?php echo $i; ?>" class="c-textlink"><?php echo $i; ?></a>
            <?php endif; ?>
          <?php endfor; ?>

          <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="c-textlink">NEXT</a>
          <?php else: ?>
            <span class="is-active">NEXT</span>
          <?php endif; ?>

        </nav>
      <?php endif; ?>

    <?php endif; ?>

  </main>
  <!-- /.c-layout__container -->
</div>
<!-- /.c-layout -->

<?php include('components/footer.php'); ?>
