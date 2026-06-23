const Header = document.querySelector(".header");
const MenuButton = document.querySelector(".header__menu-button");
if (!!Header && !!MenuButton) {
  MenuButton.addEventListener("click", () => {
    Header.classList.toggle("is-opened");
  });
}
