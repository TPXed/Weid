document.addEventListener("DOMContentLoaded", function(){
    var uploadButton = document.getElementById("uploadButton");
    var modal = document.getElementById("myModal");
    uploadButton.onclick = function() {
        modal.style.display = "block";
    }
    var closeButton  =document.getElementsByClassName("close")[0];
    closeButton.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var audioElements = document.querySelectorAll('audio');
    audioElements.forEach(function(audioElement, index) {
        audioElement.addEventListener('ended', function() {
            var netxAudioElement = audioElements[index + 1];
            if (netxAudioElement) {
                netxAudioElement.play();
            }
        });
    });
});