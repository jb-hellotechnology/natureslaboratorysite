// const parseArrayToWords = (arr) => {
//     let prevChar;
//     let word = [];
//     let wordArray = [];
//     arr.forEach(char => {
//         if (char > "A" && char < "z") {
//             word = [...word, char];
//         } else {
//             if (prevChar > "A" && prevChar < "z") {
//                 wordArray = [...wordArray, word.join("")];
//                 word = [];
//             }
//         }
//         prevChar = char;
//     });

//     return wordArray;
// }

// let tagDivs = document.getElementsByClassName("post-tags");
// console.log(tagDivs[0].innerHTML);
// for (let i = 0; i < tagDivs.length; i++) {
//     const tags = tagDivs[i];
//     let tagStrArray = tags.innerHTML.split("");
//     tags.innerHTML = null;
//     let newTags = parseArrayToWords(tagStrArray);
//     newTags.forEach(tag => {
//         let element = document.createElement("DIV");
//         element.innerHTML = tag;
//         tags.appendChild(element);
//     });
// }
