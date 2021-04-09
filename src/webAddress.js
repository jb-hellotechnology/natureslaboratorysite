let addresses = document.getElementsByClassName("c-threes-table__website");

for (let i = 0; i < addresses.length; i++) {
    const address = addresses[i];
    let httpsString = "https://";
    let httpString = "http://";
    
    let innerHTML = address.innerHTML.trim();

    let newInnerHTML;

    if (innerHTML.includes(httpsString)) {
        newInnerHTML = innerHTML.split(httpsString)[1];
    } else if (innerHTML.includes(httpString)) {
        newInnerHTML = innerHTML.split(httpString)[1];
    }

    if (newInnerHTML[newInnerHTML.length-1] == "/") {
        newInnerHTML = newInnerHTML.slice(0, -1);
    }

    address.innerHTML = newInnerHTML;
}