const titleStyle = () => {
    let title = document.getElementsByClassName("title")[0];
    let titleInnerHtmlArray = title.innerHTML.split("");
    if (titleInnerHtmlArray.length > 20) {
        title.classList.add("small");
    }
}

titleStyle();