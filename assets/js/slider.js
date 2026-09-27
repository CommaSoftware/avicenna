(function () {
  "use strict";

  /**
   * Инициализация слайдера.
   * @param {string|HTMLElement} root - селектор или сам элемент слайдера.
   * @param {Object} [options]
   * @param {number} [options.interval] - авто-переключение в мс (перебивает data-autoalide).
   * @param {boolean} [options.loop] - зацикливать слайды (по умолчанию true).
   * @param {string} [options.buttonLeftSelector] - селектор кнопки "назад".
   * @param {string} [options.buttonRightSelector] - селектор кнопки "вперёд".
   */
  function initSlider(root, options) {
    var slider = typeof root === "string" ? document.querySelector(root) : root;
    if (!slider) return;

    var opts = Object.assign(
      {
        interval: null,
        loop: true,
        buttonLeftSelector: ".slider__nav-button--left, #sliderButtonLeft",
        buttonRightSelector: ".slider__nav-button--right, #sliderButtonRight",
      },
      options || {},
    );

    // Приоритет: options.interval → data-autoalide → 0 (выключено)
    var autoInterval = 0;
    if (typeof opts.interval === "number" && opts.interval > 0) {
      autoInterval = opts.interval;
    } else {
      var dataAttr = slider.getAttribute("data-autoalide");
      if (dataAttr !== null) {
        var parsed = parseInt(dataAttr, 10);
        if (!isNaN(parsed) && parsed > 0) {
          autoInterval = parsed;
        }
      }
    }

    var items = Array.prototype.slice.call(
      slider.querySelectorAll(".slider__item"),
    );
    if (items.length === 0) return;

    var currentIndex = 0;
    var timerId = null;

    // ---------- Создание ellipsis ----------
    function buildEllipsis() {
      slider.querySelectorAll(".slider__ellipsis").forEach(function (el) {
        el.parentNode.removeChild(el);
      });

      items.forEach(function (item) {
        var content = item.querySelector(".slider-item__content");
        if (!content) return;

        var ellipsis = document.createElement("div");
        ellipsis.className = "slider__ellipsis";

        items.forEach(function (_, dotIndex) {
          var dot = document.createElement("span");
          dot.dataset.number = String(dotIndex + 1);
          dot.addEventListener("click", function () {
            goTo(dotIndex);
            resetAuto();
          });
          ellipsis.appendChild(dot);
        });

        content.appendChild(ellipsis);
      });
    }

    // ---------- Переключение слайда ----------
    function goTo(index) {
      if (items.length < 2) return;

      if (index < 0) {
        if (!opts.loop) return;
        index = items.length - 1;
      }
      if (index >= items.length) {
        if (!opts.loop) return;
        index = 0;
      }
      if (index === currentIndex) return;

      items[currentIndex].classList.remove("is-active-item");
      currentIndex = index;
      items[currentIndex].classList.add("is-active-item");
      updateEllipsis();
    }

    function next() {
      goTo(currentIndex + 1);
    }

    function prev() {
      goTo(currentIndex - 1);
    }

    function updateEllipsis() {
      items.forEach(function (item, itemIndex) {
        var dots = item.querySelectorAll(".slider__ellipsis span");
        dots.forEach(function (dot) {
          var num = parseInt(dot.dataset.number, 10);
          dot.classList.toggle("is-active", num === currentIndex + 1);
        });
        var ellipsis = item.querySelector(".slider__ellipsis");
        if (ellipsis) {
          ellipsis.classList.toggle("is-active", itemIndex === currentIndex);
        }
      });
    }

    // ---------- Кнопки навигации ----------
    function bindNavButtons() {
      var btnLeft = slider.querySelector(opts.buttonLeftSelector);
      var btnRight = slider.querySelector(opts.buttonRightSelector);

      function handlePrev(e) {
        e.preventDefault();
        prev();
        resetAuto();
      }

      function handleNext(e) {
        e.preventDefault();
        next();
        resetAuto();
      }

      if (btnLeft) {
        btnLeft.addEventListener("click", handlePrev);
        btnLeft.setAttribute("role", "button");
        btnLeft.setAttribute("aria-label", "Предыдущий слайд");
        btnLeft.setAttribute("tabindex", "0");
        btnLeft.addEventListener("keydown", function (e) {
          if (e.key === "Enter" || e.key === " ") handlePrev(e);
        });
      }

      if (btnRight) {
        btnRight.addEventListener("click", handleNext);
        btnRight.setAttribute("role", "button");
        btnRight.setAttribute("aria-label", "Следующий слайд");
        btnRight.setAttribute("tabindex", "0");
        btnRight.addEventListener("keydown", function (e) {
          if (e.key === "Enter" || e.key === " ") handleNext(e);
        });
      }

      return { btnLeft: btnLeft, btnRight: btnRight };
    }

    // ---------- Авто-прокрутка ----------
    function startAuto() {
      if (!autoInterval || items.length < 2) return;
      stopAuto();
      timerId = setInterval(function () {
        next();
      }, autoInterval);
    }

    function stopAuto() {
      if (timerId) {
        clearInterval(timerId);
        timerId = null;
      }
    }

    /**
     * Сброс таймера: останавливаем текущий и запускаем заново.
     * Вызывается при любом ручном переключении (кнопки, точки).
     */
    function resetAuto() {
      if (!autoInterval) return;
      stopAuto();
      startAuto();
    }

    // ---------- Инициализация ----------
    buildEllipsis();

    items.forEach(function (item, index) {
      item.classList.toggle("is-active-item", index === 0);
    });
    currentIndex = 0;
    updateEllipsis();

    bindNavButtons();

    // Пауза авто-прокрутки при наведении мыши
    slider.addEventListener("mouseenter", stopAuto);
    slider.addEventListener("mouseleave", startAuto);

    // Пауза при потере фокуса вкладки (опционально, но полезно)
    document.addEventListener("visibilitychange", function () {
      if (document.hidden) {
        stopAuto();
      } else {
        startAuto();
      }
    });

    startAuto();

    // ---------- API ----------
    return {
      goTo: function (i) {
        goTo(i);
        resetAuto();
      },
      next: function () {
        next();
        resetAuto();
      },
      prev: function () {
        prev();
        resetAuto();
      },
      startAuto: startAuto,
      stopAuto: stopAuto,
      resetAuto: resetAuto,
      getCurrentIndex: function () {
        return currentIndex;
      },
      destroy: function () {
        stopAuto();
        slider.querySelectorAll(".slider__ellipsis").forEach(function (el) {
          el.parentNode.removeChild(el);
        });
      },
    };
  }

  // Автозапуск при загрузке DOM
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", function () {
      initSlider("#slider");
    });
  } else {
    initSlider("#slider");
  }

  window.initSlider = initSlider;
})();
