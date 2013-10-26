function login(e){
    e.preventDefault();
    var b = document.querySelector("button");
    b.disabled = true;
    b.classList.add("loading");

    document.activeElement.blur();

    // send login and password, recieve session key, blah blah blah

    window.setTimeout(function(){document.body.classList.add("fade");}, 2000, false);
    window.setTimeout(function(){document.body.classList.remove("login");},  3000, false);

    // this is where we load the next page
}
window.onload = function(){
    var b = document.querySelector("button");
    b.disabled = false;
    document.querySelector("form").addEventListener("submit", login, false);
}
