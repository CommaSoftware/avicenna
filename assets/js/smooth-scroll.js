function smoothScrollToElement(element, offset = null) {
  try {
    if (!element) return false;

    let headerHeight = offset;
    if (headerHeight === null) {
      headerHeight = parseFloat(
        getComputedStyle(document.documentElement).getPropertyValue(
          "--header-height",
        ),
      );

      if (isNaN(headerHeight)) headerHeight = 0;
    }

    const elementPosition = element.getBoundingClientRect().top;
    const offsetPosition = elementPosition + window.pageYOffset - headerHeight;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth",
    });
    return true;
  } catch (error) {
    console.error("Error during smooth scroll:", error);
    return false;
  }
}

// Плавный скролл для всех якорных ссылок
document.addEventListener("DOMContentLoaded", () => {
  // Обработка кликов
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href");
      if (targetId === "#" || targetId === "#top") return;

      const targetElement = document.querySelector(targetId);
      if (!targetElement) return;

      e.preventDefault();
      smoothScrollToElement(targetElement);

      // Обновляем URL
      history.pushState(null, null, targetId);
    });
  });

  // Если на странице есть хеш в URL - прокручиваем
  if (window.location.hash && window.location.hash !== "#!") {
    setTimeout(() => {
      const targetElement = document.querySelector(window.location.hash);
      if (!targetElement) return false;
      smoothScrollToElement(targetElement);
    }, 100);
  }
});
