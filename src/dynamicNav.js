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
        var t0 = performance.now();
        window.onload = () => {
            formatTitle();
            navigationArray.forEach(nav => {
                nav.handleResize()
                nav.show();
            });
            navigationArray.forEach(nav => {
                nav.fullNav.parentNode.classList.remove("hide")
            })
            // setTimeout(() => {
            // }, 5)
        };

        window.addEventListener("resize", () => {
            navigationArray.forEach(nav => {
                nav.handleResize();
            })
            formatTitle();
        });
        var t1 = performance.now();
        console.log("JS took " + (t1 - t0) + " milliseconds");
    }
}

export default implementNav;