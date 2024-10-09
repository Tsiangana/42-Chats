

document.querySelector('#menu-btn').onclick = () =>{
  var div2 = document.getElementById("teste");
  var div3 = document.getElementById("teste1");
  if (div2.style.display === "none") {
    div2.style.display = "flex";
    div3.style.gridColumn = 'span 7'
  } else {
    div2.style.display = "none";
    div3.style.gridColumn = 'span 9'
  }
}

let icons = document.querySelectorAll('.container_father .main .sidebar .icons i');

for(let i = 0; i < icons.length; i++){
  icons[i].addEventListener('click', function(){
    // remove a classe "selected" de todos os ícones
    for(let j = 0; j < icons.length; j++){
      icons[j].classList.remove('selected');
      icons[j].classList.remove('active');
    }
    // adiciona a classe "selected" ao ícone clicado
    this.classList.add('selected');
  });
}

    