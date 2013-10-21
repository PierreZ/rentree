function login(e){
    e.preventDefault();

    // send login and password, recieve session key, blah blah blah

    var b = document.querySelector("button");
    b.disabled = true;
    b.classList.add("loading");
    window.setTimeout(function(){document.body.classList.add("logged-in");}, 1000, false);
    window.setTimeout(function(){document.body.classList.remove("login");},  2000, false);
}
window.onload = function(){
    var b = document.querySelector("button");
    b.disabled = false;
    document.querySelector("form").addEventListener("submit", login, false);
}
