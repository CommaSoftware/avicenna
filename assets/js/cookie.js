//--------------- Получение cookie по name (start) ---------------//
function getCookie(cookieName) {
  var results = document.cookie.match("(^|;) ?" + cookieName + "=([^;]*)(;|$)");
  if (results) return unescape(results[2]);
  else return null;
}
//--------------- Получение cookie по name (end) ---------------//

//--------------- Cookie-confirm Overlay (start) ---------------//
function showCookieOverlay() {
  if (!Number(getCookie("agreeToCookie"))) {
    document.querySelector("#cookie_overlay")?.classList.add("is-shown");
    document
      .querySelector("#cookie_overlay .button")
      ?.addEventListener("click", closeCookieOverlay);
  }
}

function closeCookieOverlay() {
  let cookie_date = new Date();
  cookie_date.setYear(cookie_date.getFullYear() + 1);
  document.cookie = "agreeToCookie=1;expires=" + cookie_date.toUTCString();
  initCounter();
  document.querySelector("#cookie_overlay").remove();
}

setTimeout(showCookieOverlay, 1000);
//--------------- Cookie-confirm Overlay (end) ---------------//

//-------------------- Инициализация счётчика (start) --------------------//
(function (m, e, t, r, i, k, a) {
  m[i] =
    m[i] ||
    function () {
      (m[i].a = m[i].a || []).push(arguments);
    };
  m[i].l = 1 * new Date();
  ((k = e.createElement(t)),
    (a = e.getElementsByTagName(t)[0]),
    (k.async = 1),
    (k.src = r),
    a.parentNode.insertBefore(k, a));
})(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

function initCounter() {
  // COUNTER_ID инициализирован в header.php
  if (!!Number(getCookie("agreeToCookie"))) ym(Number(COUNTER_ID), "init", {});
}

initCounter();
//-------------------- Инициализация счётчика (end) ----------------------//
