import TimelineEvent from "./Event";

export default class Timeline {
    node; //HTMLElement
    events = []; // Array<Event>

    constructor(node) {
        this.node = node;

        let events = this.node.getElementsByClassName("c-timeline__block");
        for (let i = 0; i < events.length; i++) {
            const event = events[i];
            this.events = [...this.events, new TimelineEvent(event)];
        }

        this.calculatePositions();

        window.addEventListener("resize", () => {
            this.calculatePositions();
        })

    }

    getCoordinates(element) {
        let scrollPosition = document.documentElement.scrollTop;
        let elementRect = element.getBoundingClientRect();

        return {
            top: elementRect.top + scrollPosition,
            bottom: elementRect.bottom + scrollPosition,
            left: elementRect.left,
            right: elementRect.right
        }
    }

    calculatePositions() {
        // for (let index = 0; index < this.events.length; index++) {
        //     const event = this.events[index];
        //     if (index == 0) {
        //         event.node.style.top = "0px";
        //         continue;
        //     }

        //     if (index == 1) {
        //         let prevElementRect = this.events[0].node.getBoundingClientRect();
        //         let currentElementRect = event.node.getBoundingClientRect();
        //         event.node.style.top = `-${(currentElementRect.top - prevElementRect.top) - 100}px`;
        //         continue;
        //     }


        //     // let prevElementRect = event.node.previousSibling.getBoundingClientRect();
        //     let aboveElementRect = this.getCoordinates(this.events[index - 2].node);
        //     let adjacentElementRect = this.getCoordinates(this.events[index - 1].node);
        //     let currentElementRect = this.getCoordinates(event.node);

        //     // console.log(`Current Top: ${currentElementRect.top + documentScroll}, Above Bottom: ${aboveElementRect.bottom + documentScroll}, Move: ${currentElementRect.top - aboveElementRect.bottom}`);

        //     let newPosition = (currentElementRect.top - aboveElementRect.bottom) - 100;
        //     let distanceNewToAdjacent = newPosition - adjacentElementRect.top;
        //     let documentScroll = document.documentElement.scrollTop;

        //     // console.log(`Index: ${index}, Distance New Position To Adjacent: ${distanceNewToAdjacent}px`)

        //     if (index == 3) {
        //     }
        //     console.log(`New Pos = ${newPosition} Scroll = ${documentScroll} Abs New Pos = ${newPosition + documentScroll} Adjacent = ${adjacentElementRect.top}`);

        //     if (false) {
        //         console.log("True")
        //         event.node.style.top = `-${(currentElementRect.top - adjacentElementRect.top - 100)}px`;
        //     } else {
        //         // console.log("False")
        //         event.node.style.top = `-${newPosition}px`;
        //     }

        // }

        
    }


}