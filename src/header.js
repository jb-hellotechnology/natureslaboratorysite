export const formatTitle = () => {
    let title = document.getElementsByClassName("title-small")[0];
    let url = window.location.pathname;

    if (document.documentElement.clientWidth < 768) {
        if (url.includes("blog")) {
            title.innerHTML = "NL Blog"
        } else {
            title.innerHTML = "NL"
        }
    }
    else {
        if (url.includes("blog")) {
            title.innerHTML = "The Nature\'s Laboratory Blog"
        } else {
            title.innerHTML = "Nature\'s Laboratory"
        }
    }
}