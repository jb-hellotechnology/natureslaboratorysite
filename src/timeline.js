import Timeline from "./classes/Timeline";

window.addEventListener("load", () => {
    let timelines = document.getElementsByClassName("c-timeline");
    
    for (let i = 0; i < timelines.length; i++) {
        const timeline = timelines[i];
        new Timeline(timeline);
        
    }
})

