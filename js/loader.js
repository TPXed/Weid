window.addEventListener('load', function() {
   setTimeout(function() {
    var loader = document.querySelector('.loader');
    loader.style.transititon = 'opacity 0.1s ease-in-out';
    loader.style.opacity = '0';
    setTimeout(function(){ 
        loader.style.display = 'none';
        loader.style.zIndex = 'auto';
    }, 500);
   }, 3000);
});