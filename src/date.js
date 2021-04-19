let dates = document.getElementsByClassName("c-post-card__date");

window.addEventListener("DOMContentLoaded", () => {
    for (let i = 0; i < dates.length; i++) {
        const date = dates[i];
        let innerHTML = date.innerHTML;
        console.log(innerHTML);
        let innerHTMLArray = innerHTML.split(" ");
        let day = innerHTMLArray[0];
        let month = innerHTMLArray[1].slice(0, 3);
        let year = innerHTMLArray[2];
        let currentDate = new Date();
        if (currentDate.getFullYear.toString() != year) {
            date.innerHTML = `${day} ${month}, ${year}`;
        }
        date.innerHTML = `${day} ${month}`;

        
        
    }
})