<p class="c-animation__sclolldown">SCROLL DOWN</p>

<footer class="c-footer">
    <h1><a href="#"><img src="./static/img/logo.svg" alt="蟹木しとお オフィシャルサイト"></a>
    </h1>
    <nav class="c-footer__nav">
        <ul>
            <li><a class="c-textlink" href="index#profile">PROFILE</a></li>
            <li><a class="c-textlink" href="information">INFORMATION</a></li>
            <li><a class="c-textlink" href="index#works">WORKS</a></li>
            <li><a class="c-textlink" href="guideline">GUIDELINE</a></li>
            <li><a class="c-textlink" href="mailto:shiro46jack&#64;gmail.com?subject=お問い合せ">CONTACT</a></li>
        </ul>
        <ul>
            <?php if (isset($profileData['link'])) {
                foreach ($profileData['link'] as $link): ?>
                    <li><a href="<?php echo htmlspecialchars($link['url']); ?>" class="c-textlink" target="_blank"><?php echo $link['title']; ?></a></li>
            <?php endforeach;
            } ?>
        </ul>
    </nav>
    <small>&copy; xitoo</small>
</footer>

<script src="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
"></script>
<script src="./static/js/progressbar.min.js"></script>
<script src="./static/js/script.js"></script>

</body>

</html>
