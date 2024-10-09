/* project VEchar
/* Made by eliseu
/* date: 08/03/2023
/* Copyrights
/* CSS
*/

// header slider start//
let img = document.getElementsByTagName('img')[0];

const animation_img = ()=>{
    setTimeout(() => {
        img.src = "background/animacao1.gif";
    },0000);
    setTimeout(() => {
        img.src = "background/animacao2.gif";
    },5000);
    setTimeout(() => {
        img.src  = "background/animacao3.gif";
    },10000);
    setTimeout(() => {
        img.src = "background/animacao4.gif";
    },15000);
}
setInterval(animation_img, 30000);

animation_img();
// header slider end//

