function readmore(){
    var dots = document.getElementById("dots");
    var moretext = document.getElementById("more");
    var btn = document.getElementById("btn");

    if(dots.style.display === "none"){
        dots.style.display = "inline";
        btn.innerHTML = "Read more";
        moretext.style.display = "none";
    }
    else{
        dots.style.display = 'none';
        btn.innerHTML = "Read less";
        moretext.style.display = 'inline';
    }
}