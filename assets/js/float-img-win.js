function floatImgDinamicUI() {
  // Закрытие нажатием на крестик
  let multiply = document.querySelectorAll(".float-window_close-btn");
  for (let i = 0; i < multiply.length; i++) {
    multiply[i].addEventListener("click", function () {
      floatImg.close(this.closest(".float-window"));
    });
  }

  // Закрытие нажатием на фон
  let bg = document.querySelectorAll(".float-window-bg");
  for (let i = 0; i < bg.length; i++) {
    bg[i].addEventListener("click", function () {
      floatImg.close(this.closest(".float-window"));
    });
    window.addEventListener("scroll", function () {
      floatImg.close(bg[i].closest(".float-window"));
    });
  }
}

var floatImg = {
  imgOjs: document.querySelectorAll(".cms-content img"), // Селектор указывает, какие изображения открывать
  create: function (src) {
    let structure = document.createElement("div");
    structure.classList.add("float-window");

    let bg = document.createElement("div");
    bg.classList.add("float-window-bg");

    let floatImg = document.createElement("img");
    floatImg.setAttribute("src", src);

    let closeBtn = document.createElement("div");
    closeBtn.classList.add("float-window_close-btn");
    closeBtn.innerHTML =
      '<span class="icon is-color-white" data-type="close"></span>';

    // Добавление в DOM
    structure.append(bg);
    structure.append(closeBtn);
    structure.append(floatImg);
    document.body.append(structure);

    // Анимация
    let lastWindow = document.querySelector(".float-window");
    setTimeout(function () {
      lastWindow.style.opacity = "1";
    }, 10);

    // Привязка событий
    floatImgDinamicUI();
  },
  close: function (windowObj) {
    let transition =
      parseFloat(window.getComputedStyle(windowObj).transitionDuration) * 1000;
    windowObj.style.opacity = "0";
    setTimeout(function () {
      windowObj.remove();
    }, transition);
  },
};

// Открытие всплывающего изображения
for (let i = 0; i < floatImg.imgOjs.length; i++) {
  floatImg.imgOjs[i].addEventListener("click", function () {
    floatImg.create(this.getAttribute("src"));
  });
}
