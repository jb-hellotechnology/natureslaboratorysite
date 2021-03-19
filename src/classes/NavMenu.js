import {HamburgerNavLink, TopNavLink} from './Link';

class NavMenu {
    node; // HTMLElement
    links = []; // Array<Link>

    constructor(menu) {
        this.node = menu;
        this.hideAll = this.hideAll.bind(this)
        this.showAll = this.showAll.bind(this)
    }

    // Public Null
    hideAll() {
        this.links.forEach(link => link.hide());
    }

    // Public Null
    showAll() {
        this.links.forEach(link => link.show());
    }
}

export class Hamburger extends NavMenu {

    // Public Bool
    get isMobile() {
        if (this.node.classList.contains("mobile")) {
            return true;
        }
        return false;
    }

    // Public Bool
    get isHidden() {
        if (this.node.classList.contains("hide")) {
            return true;
        }
        return false;
    }

    constructor(menu) {
        super(menu);
        for (let i = 0; i < this.node.children.length; i++) {
            const link = this.node.children[i];
            let newLink = new HamburgerNavLink(link);
            this.links = [...this.links, newLink];
        }

        this.toMobile = this.toMobile.bind(this)
        this.toDesktop = this.toDesktop.bind(this)
        this.showOne = this.showOne.bind(this);
    }

    // Public Null
    toggle(type=null, close=false) {
        if (type) {
            switch (type) {
                case "slide":
                    this.toggleSlide(close);
                    break
                default:
                    throw new Error("Invalid Type");
            }
        }
        else {
            this.node.classList.remove("hide");
        }
    }

    toggleSlide(close=false) {
        console.log("slide!");
        let body = document.getElementsByTagName("BODY")[0];
        let html = document.getElementsByTagName("HTML")[0];
        let hamburgerRect = this.node.getBoundingClientRect();
        if (body.style.transform || close) {
            body.style.position = "";
            body.style.top = ``;
            body.style.transform = ``;
        } else {
            body.style.position = "fixed";
            body.style.top = `-${window.scrollY}px`;
            body.style.transform = `translateX(-${hamburgerRect.right - hamburgerRect.left}px)`;
        }
    }

    // Public Null
    toMobile() {
        this.node.classList.add("mobile");
        this.links.forEach(link => {
            if (link.desktopIcon) {
                link.desktopIcon.hide()
            }
            if (link.mobileIcon) {
                link.mobileIcon.show()
            }
        })
    }

    // Public Null
    toDesktop() {
        this.node.classList.remove("mobile");
        this.links.forEach(link => {
            if (link.desktopIcon) {
                link.desktopIcon.show()
            }
            if (link.mobileIcon) {
                link.mobileIcon.hide()
            }
        })
    }

    // Public Null
    showOne() {
        let linkRevealed = false;
        for (let i = this.links.length - 1; i >= 0; i--) {
            const link = this.links[i];
            if (link.node.classList.contains("priority")) {
                continue;
            }
            if (link.isHidden()) {
                link.show()
                linkRevealed = true;
                break;
            }
        }
        if (!linkRevealed) {
            for (let i = this.links.length - 1; i >= 0; i--) {
                const link = this.links[i];
                if (link.isHidden()) {
                    link.show()
                    break;
                }
            }
        }
    }
}

export class TopNav extends NavMenu {

    // Public Int
    get totalWidth() {
        let width = 0;
        this.links.forEach(link => {
            width += link.width;
        });
        return width;
    }

    constructor(menu) {
        super(menu)
        for (let i = 0; i < this.node.children.length; i++) {
            const link = this.node.children[i];
            let newLink = new TopNavLink(link);
            this.links = [...this.links, newLink];
        }

        this.hideOne = this.hideOne.bind(this);

    }

    // Public Null
    hideOne() {
        let linkHidden = false;
        for (let i = this.links.length - 1; i >= 0; i--) {
            const link = this.links[i];
            if (link.node.classList.contains("priority")) {
                continue;
            }
            if (!link.isHidden()) {
                link.hide()
                linkHidden = true;
                break;
            }
        }
        console.log(linkHidden);
        
        if (!linkHidden) {
            for (let i = this.links.length - 1; i >= 0; i--) {
                const link = this.links[i];
                if (!link.isHidden()) {
                    link.hide()
                    break;
                }
            }
        }
    }
}