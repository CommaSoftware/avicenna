function showPopup(text, duration) {
  const popupDiv = document.createElement("div");
  popupDiv.className = "popup";

  const span = document.createElement("span");
  span.className = "span";
  span.textContent = text;

  popupDiv.appendChild(span);
  document.body.appendChild(popupDiv);

  setTimeout(() => {
    if (popupDiv && popupDiv.parentNode) {
      popupDiv.remove();
    }
  }, duration);
}
