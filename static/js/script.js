//ローディング
window.onload = function () {
  const spinner = document.getElementById("loading");

  var bar = new ProgressBar.Line(container, {
    strokeWidth: 4,
    easing: "easeInOut",
    duration: 1400,
    color: "#d8fe51",
    trailColor: "#6d6d6d",
    trailWidth: 1,
    svgStyle: { width: "100%", height: "100%" },
    text: {
      style: {
        color: '#d8fe51',
        textAlign: 'center',
      },
      autoStyleContainer: false
    },
    from: { color: "#d8fe51" },
    to: { color: "#d8fe51" },
    step: (state, bar) => {
      bar.setText(Math.round(bar.value() * 100) + " %");
    }
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

