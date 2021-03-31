
let tagsArray = document.getElementsByClassName('post-tags');

for (let i = 0; i < tagsArray.length; i++) {
    const tags = tagsArray[i];
    if (tags.children.length > 5) {
        for (let j = 5; j < tags.children.length; j++) {
            const tag = tags.children[j];
            tag.classList.add("hide");
        }
        let tagRevealButton = document.createElement("BUTTON");
        tagRevealButton.innerHTML = `+ ${tags.children.length-5}`;
        tagRevealButton.addEventListener("click", (e) => {
            for (let j = 0; j < tags.children.length; j++) {
                const tag = tags.children[j];
                tag.classList.remove("hide");
                tagRevealButton.classList.add("hide");
            }
        })
        let tagRevealButtonWrapper = document.createElement("LI");
        tagRevealButtonWrapper.appendChild(tagRevealButton)
        tags.appendChild(tagRevealButtonWrapper);
    }
}