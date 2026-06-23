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

  document.querySelector("#cookie_overlay").remove();
}

setTimeout(showCookieOverlay, 1000);
//--------------- Cookie-confirm Overlay (end) ---------------//
