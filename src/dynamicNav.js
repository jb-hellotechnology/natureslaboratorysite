import Navigation from './classes/Navigation.js';
import {formatTitle} from './header';

const implementNav = () => {
    let navigationItems = document.getElementsByClassName("navigation");
    let navigationArray = [];
    for (let i = 0; i < navigationItems.length; i++) {
        const nav = navigationItems[i];
        let navigation = new Navigation(nav);
        navigationArray = [...navigationArray, navigation];
    }
    if (navigationArray) {
        window.onload = () => {
            formatTitle();
            navigationArray.forEach(nav => {
                nav.handleResize()
                nav.show();
            });
            setTimeout(() => {
                navigationArray.forEach(nav => {
                    nav.fullNav.parentNode.classList.remove("hide")
                })
            }, 20)
        };

        window.addEventListener("resize", () => {
            navigationArray.forEach(nav => {
                nav.handleResize();
            })
            formatTitle();
        });
    }
}

export default implementNav;