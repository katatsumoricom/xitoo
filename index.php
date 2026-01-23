<?php include('components/head.php'); ?>
<?php require_once('components/microcmsShow.php'); ?>


<!-- TODO:テストサイト公開（phpを静的サイトにしてgithub pageとか？　file_get_contents()） -->

<!-- TODO:納品前 micro cms隠匿化 -->
<!-- TODO: 納品前 SEO対策 -->
<!-- TODO: 納品前 不要なSCSS消す -->

<!-- <div class="c-layout__scanlines"></div> -->
<div class="c-layout__bgnoise"></div>
<div class="c-layout">

  <?php include('components/header.php'); ?>

  <div id="profile" class="p-profile">
    <div class="p-profile__layout">
      <div class="p-profile__bg-image">
        <img src="./static/img/bg.jpg" alt="背景画像">
      </div>
      <h2>
        <img
          src="./static/img/top.svg"
          alt="蟹木しとお VOCALOIDプロデューサー インディーズゲームクリエイター イラストレーター" />
      </h2>
    </div>
    <div class="p-profile__biography">
      <div class="p-profile__biography__grid">
        <span>
          <h3>蟹木しとお</h3>
          <p><?php
              if (isset($profileData['position'])) {
                echo $profileData['position'];
              } ?>
          </p>
        </span>
        <figure><?php if (isset($profileData['profile_photo']['url'])): ?>
            <img
              src="<?php echo $profileData['profile_photo']['url']; ?>"
              alt="蟹木しとお プロフィール写真" />
          <?php endif; ?>
        </figure>
      </div>
      <div class="p-profile__details__pc">
        <?php
        if (isset($profileData['biography'])) {
          echo $profileData['biography'];
        } ?>
      </div>
      <details class="p-profile__details__sp">
        <summary class="c-button c-button__biography">BIOGRAPHY</summary>
        <?php
        if (isset($profileData['biography'])) {
          echo $profileData['biography'];
        } ?>
      </details>
    </div>
  </div>
  <main class="c-layout__container">
    <div class="c-layout__content p-info">
      <section class="p-info-news">
        <h2>
          <img src="./static/img/information.svg" alt="INFORMATION" />
        </h2>
        <dl class="p-info-news__list">
          <?php if (isset($infoData['contents']) && !empty($infoData['contents'])) {
            foreach ($infoData['contents'] as $info): ?>
              <a href="information?id=<?php echo $info['id'] ?>" class="p-info-news__item">
                <dt><?php echo date('Y.m.d', strtotime($info['data'])) ?></dt>
                <dd><?php echo $info['title'] ?></dd>
              </a>
          <?php endforeach;
          } ?>

        </dl>
        <a href="information" class="c-button">READ MORE</a>
      </section>
      <section class="c-layout__content p-info-link">
        <h2><img src="./static/img/link.svg" alt="LINK" /></h2>
        <div class="p-info-link__list">
          <?php if (isset($profileData['link'])) {
            foreach ($profileData['link'] as $link): ?>
              <a href="<?php echo htmlspecialchars($link['url']); ?>" class="c-button" target="_blank"><?php echo $link['title']; ?></a>
          <?php endforeach;
          } ?>
        </div>
        <a class="c-textlink" href="guideline">作品使用についてのガイドライン</a>
      </section>
    </div>
    <!-- /.p-info -->
    <div id="works" class="c-layout__content p-works">
      <h2><img src="./static/img/works.svg" alt="WORKS" /></h2>
      <a class="c-textlink" href="guideline">作品使用についてのガイドライン</a>

      <section class="p-works__music">
        <h3><img src="./static/img/music.svg" alt="MUSIC" /></h3>
        <div class="p-works__content">
          <div class="youtube p-works__hover">
            <iframe
              width="560"
              height="315"
              src="https://www.youtube.com/embed/videoseries?si=YcOjYUwFW3VvsUUC&amp;list=PLordceDMCDfmJnDUtsBXrRGJEqrUQAGxm"
              title="YouTube video player"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              referrerpolicy="strict-origin-when-cross-origin"
              allowfullscreen></iframe>
          </div>
          <?php $music = $works['music'] ?? null; ?>
          <?php if (!empty($music['buttonLink'])): ?>
            <div class="p-works__button-flex">
              <?php foreach ($music['buttonLink'] as $link): ?>
                <a href="<?php echo $link['url']; ?>" class="c-button" target="_blank"><?php echo $link['title']; ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

        </div>
      </section>

      <section class="p-works__game">
        <h3><img src="./static/img/game.svg" alt="GAME" /></h3>
        <div class="p-works__content">
          <?php $game = $works['game'] ?? null; ?>

          <?php if (!empty($game['bannerLink']['image'])): ?>
            <figure class="p-works__banner">

              <?php if (!empty($game['bannerLink']['url'])): ?>
                <a class="p-works__hover" href="<?php echo $game['bannerLink']['url']; ?>" target="_blank">
                  <img src="<?php echo $game['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
                </a>
              <?php else: ?>
                <img src="<?php echo $game['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
              <?php endif; ?>
            </figure>
          <?php endif; ?>

          <?php if (!empty($game['sliderLink'])): ?>
            <div class="splide" role="group" aria-label="Splideの基本的なHTML">
              <div class="splide__track">
                <ul class="splide__list">
                  <?php foreach ($game['sliderLink'] as $slide): ?>
                    <li class="splide__slide p-works__banner">
                      <?php if (!empty($slide['url'])): ?>
                        <a class="p-works__hover" href="<?php echo $slide['url'] ?>"><img
                            src="<?php echo $slide['image']['url']; ?>"
                            alt="<?php echo $slide['title'] ?>" /></a>
                      <?php else: ?>
                        <img
                          src="<?php echo $slide['image']['url']; ?>"
                          alt="<?php echo $slide['title'] ?>" />
                      <?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endif; ?>
          <?php if (!empty($game['buttonLink'])): ?>
            <div class="p-works__button-flex">
              <?php foreach ($game['buttonLink'] as $link): ?>
                <a href="<?php echo $link['url']; ?>" class="c-button" target="_blank"><?php echo $link['title']; ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </section>

      <section class="p-works__utau">
        <h3><img src="./static/img/utau.svg" alt="UTAU" /></h3>
        <div class="p-works__content">

          <?php $utau = $works['utau'] ?? null; ?>
          <?php if (!empty($utau['bannerLink']['image'])): ?>
            <figure class="p-works__banner">

              <?php if (!empty($utau['bannerLink']['url'])): ?>
                <a class="p-works__hover" href="<?php echo $utau['bannerLink']['url']; ?>" target="_blank">
                  <img src="<?php echo $utau['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
                </a>
              <?php else: ?>
                <img src="<?php echo $utau['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
              <?php endif; ?>
            </figure>
          <?php endif; ?>

          <?php if (!empty($utau['sliderLink'])): ?>
            <div class="splide" role="group" aria-label="Splideの基本的なHTML">
              <div class="splide__track">
                <ul class="splide__list">
                  <?php foreach ($utau['sliderLink'] as $slide): ?>
                    <li class="splide__slide p-works__banner">
                      <?php if (!empty($slide['url'])): ?>
                        <a class="p-works__hover" href="<?php echo $slide['url'] ?>"><img
                            src="<?php echo $slide['image']['url']; ?>"
                            alt="<?php echo $slide['title'] ?>" /></a>
                      <?php else: ?>
                        <img
                          src="<?php echo $slide['image']['url']; ?>"
                          alt="<?php echo $slide['title'] ?>" />
                      <?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endif; ?>
          <?php if (!empty($utau['buttonLink'])): ?>
            <div class="p-works__button-flex">
              <?php foreach ($utau['buttonLink'] as $link): ?>
                <a href="<?php echo $link['url']; ?>" class="c-button" target="_blank"><?php echo $link['title']; ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div><!-- /.p-works__content -->
      </section>

      <section class="p-works__art">
        <h3><img src="./static/img/art.svg" alt="ART" /></h3>
        <div class="p-works__content">
          <?php $art = $works['art'] ?? null; ?>
          <?php if (!empty($art['bannerLink']['image'])): ?>
            <figure class="p-works__banner">

              <?php if (!empty($art['bannerLink']['url'])): ?>
                <a class="p-works__hover" href="<?php echo $art['bannerLink']['url']; ?>" target="_blank">
                  <img src="<?php echo $art['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
                </a>
              <?php else: ?>
                <img src="<?php echo $art['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
              <?php endif; ?>
            </figure>
          <?php endif; ?>

          <?php if (!empty($art['sliderLink'])): ?>
            <div class="splide" role="group" aria-label="Splideの基本的なHTML">
              <div class="splide__track">
                <ul class="splide__list">
                  <?php foreach ($art['sliderLink'] as $slide): ?>
                    <li class="splide__slide p-works__banner">
                      <?php if (!empty($slide['url'])): ?>
                        <a class="p-works__hover" href="<?php echo $slide['url'] ?>"><img
                            src="<?php echo $slide['image']['url']; ?>"
                            alt="<?php echo $slide['title'] ?>" /></a>
                      <?php else: ?>
                        <img
                          src="<?php echo $slide['image']['url']; ?>"
                          alt="<?php echo $slide['title'] ?>" />
                      <?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endif; ?>
          <?php if (!empty($art['buttonLink'])): ?>
            <div class="p-works__button-flex">
              <?php foreach ($art['buttonLink'] as $link): ?>
                <a href="<?php echo $link['url']; ?>" class="c-button" target="_blank"><?php echo $link['title']; ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div><!-- /.p-works__content -->
      </section>

      <section class="p-works__shop">
        <h3><img src="./static/img/shop.svg" alt="SHOP" /></h3>
        <div class="p-works__content">
          <?php $shop = $works['shop'] ?? null; ?>
          <?php if (!empty($shop['bannerLink']['image'])): ?>
            <figure class="p-works__banner">

              <?php if (!empty($shop['bannerLink']['url'])): ?>
                <a class="p-works__hover" href="<?php echo $shop['bannerLink']['url']; ?>" target="_blank">
                  <img src="<?php echo $shop['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
                </a>
              <?php else: ?>
                <img src="<?php echo $shop['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
              <?php endif; ?>
            </figure>
          <?php endif; ?>

          <?php if (!empty($shop['sliderLink'])): ?>
            <div class="splide" role="group" aria-label="Splideの基本的なHTML">
              <div class="splide__track">
                <ul class="splide__list">
                  <?php foreach ($shop['sliderLink'] as $slide): ?>
                    <li class="splide__slide p-works__banner">
                      <?php if (!empty($slide['url'])): ?>
                        <a class="p-works__hover" href="<?php echo $slide['url'] ?>"><img
                            src="<?php echo $slide['image']['url']; ?>"
                            alt="<?php echo $slide['title'] ?>" /></a>
                      <?php else: ?>
                        <img
                          src="<?php echo $slide['image']['url']; ?>"
                          alt="<?php echo $slide['title'] ?>" />
                      <?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endif; ?>
          <?php if (!empty($shop['buttonLink'])): ?>
            <div class="p-works__button-flex">
              <?php foreach ($shop['buttonLink'] as $link): ?>
                <a href="<?php echo $link['url']; ?>" class="c-button" target="_blank"><?php echo $link['title']; ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div><!-- /.p-works__content -->
      </section>

      <section class="p-works__live2d">
        <h3><img src="./static/img/live2d.svg" alt="Live2D" /></h3>
        <div class="p-works__content">
          <?php $live2d = $works['live2d'] ?? null; ?>
          <?php if (!empty($live2d['bannerLink']['image'])): ?>
            <figure class="p-works__banner">

              <?php if (!empty($live2d['bannerLink']['url'])): ?>
                <a class="p-works__hover" href="<?php echo $live2d['bannerLink']['url']; ?>" target="_blank">
                  <img src="<?php echo $live2d['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
                </a>
              <?php else: ?>
                <img src="<?php echo $live2d['bannerLink']['image']['url']; ?>" alt="ゲームバナー" />
              <?php endif; ?>
            </figure>
          <?php endif; ?>

          <?php if (!empty($live2d['sliderLink'])): ?>
            <div class="splide" role="group" aria-label="Splideの基本的なHTML">
              <div class="splide__track">
                <ul class="splide__list">
                  <?php foreach ($live2d['sliderLink'] as $slide): ?>
                    <li class="splide__slide p-works__banner">
                      <?php if (!empty($slide['url'])): ?>
                        <a class="p-works__hover" href="<?php echo $slide['url'] ?>"><img
                            src="<?php echo $slide['image']['url']; ?>"
                            alt="<?php echo $slide['title'] ?>" /></a>
                      <?php else: ?>
                        <img
                          src="<?php echo $slide['image']['url']; ?>"
                          alt="<?php echo $slide['title'] ?>" />
                      <?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endif; ?>
          <?php if (!empty($live2d['buttonLink'])): ?>
            <div class="p-works__button-flex">
              <?php foreach ($live2d['buttonLink'] as $link): ?>
                <a href="<?php echo $link['url']; ?>" class="c-button" target="_blank"><?php echo $link['title']; ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div><!-- /.p-works__content -->
      </section>
    </div>
    <!-- /.p-works -->
  </main>
  <!-- /.c-layout__container -->

  <!-- <a href="#" id="return" class="c-mq__fixed-return"><img src="./static/img/return.png" alt="トップに戻る"><img src="./static/img/blank.svg" alt="トップに戻る"></a> -->
</div>
<!-- /.c-layout -->

<?php include('components/footer.php'); ?>
