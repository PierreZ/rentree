function login(e){
    e.preventDefault();
    var b = document.querySelector("button");
    b.disabled = true;
    b.classList.add("loading");

    document.activeElement.blur();

    // send login and password, recieve session key, blah blah blah

    window.setTimeout(function(){document.body.classList.add("fade");}, 2000, false);
    window.setTimeout(function(){
        document.body.classList.remove("login");
        document.body.innerHTML = document.querySelector("template.panes").innerHTML;
        document.body.classList.add("step-0");
        document.body.classList.add("panes");
        window.setTimeout(function(){
            document.body.classList.remove("fade");
        }, 100, false);
        initPanes();
    },  3000, false);

    // this is where we load the next page
}
function initLogin(e){
    var b = document.querySelector("body.login button");
    b.disabled = false;
    document.querySelector("body.login form").addEventListener("submit", login, false);
}
