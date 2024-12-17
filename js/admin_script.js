let header = document.querySelector('.header');

document.querySelector('#open-header').onclick =() =>{
    header.classList.add('active');
}

document.querySelector('#close-header').onclick =() =>{
    header.classList.remove('active');
}

window.onscroll = () =>{
    header.classList.remove('active');
}
 