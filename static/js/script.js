//ローディング
window.onload = function () {
  const spinner = document.getElementById("loading");

  var bar = new ProgressBar.Line(container, {
    strokeWidth: 4,
    easing: "easeInOut",
    duration: 1400,
    color: "#96ff00",
    trailColor: "#6d6d6d",
    trailWidth: 1,
    svgStyle: { width: "100%", height: "100%" },
    text: {
      style: {
        color: "#96ff00",
        textAlign: "center",
      },
      autoStyleContainer: false,
    },
    from: { color: "#96ff00" },
    to: { color: "#96ff00" },
    step: (state, bar) => {
      bar.setText(Math.round(bar.value() * 100) + " %");
    },
  });

  bar.animate(1.0);
  setTimeout(function () {
    spinner.classList.add("loaded");
  }, 2000);
};

//メニューを閉じる
const navLink = document.querySelectorAll(".c-nav__link");
const navCheck = document.getElementById("nav-check");
navLink.forEach(function (navClick) {
  navClick.addEventListener("click", () => {
    navCheck.checked = false;
  });
});

var elms = document.getElementsByClassName("splide");

for (var i = 0; i < elms.length; i++) {
  new Splide(elms[i]).mount();
}
