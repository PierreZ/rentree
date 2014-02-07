function submit(e){
    e.preventDefault();
    var b = e.target.querySelector("button");
    b.disabled = true;
    b.classList.add("loading");

    document.activeElement.blur();

    window.setTimeout(function(){b.classList.add("success"); b.classList.remove("loading");}, 1000, false);
    window.setTimeout(function(){
        document.body.classList.add("step-2");
        document.body.classList.remove("step-1");
        var button = document.querySelector(".contact button");
        button.disabled = false;
        button.classList.remove("success");
        button.querySelector(".label").innerHTML="Mettre à jour";
    }, 1500, false);
}

function initPanes(){
    var b = document.querySelector("button");
    b.disabled = false;
    document.querySelector("form").addEventListener("submit", submit, false);
    function toStep1(e){
        e.preventDefault();
        e.stopPropagation();
        var selected = document.querySelector(".documents li.selected");
        if(selected) selected.classList.remove("selected");
        selected = document.querySelector(".promos li.selected");
        if(selected) selected.classList.remove("selected");
        document.body.className = "panes step-1";
    }
    function toStep2(e){
        e.preventDefault();
        e.stopPropagation();
        var selected = document.querySelector(".documents li.selected");
        if(selected) selected.classList.remove("selected");
        selected = document.querySelector(".promos li.selected");
        if(selected) selected.classList.remove("selected");
        document.body.className = "panes step-2";
    }
    function toStep3(e){
        e.preventDefault();
        e.stopPropagation();
        var selected = document.querySelector(".documents li.selected");
        if(selected) selected.classList.remove("selected");
        document.body.className = "panes step-3";
    }
    document.querySelector(".bienvenue .next").addEventListener("click", toStep1, false);
    document.querySelector(".promos").addEventListener("click", toStep2, false);
    document.querySelector(".promos .back").addEventListener("click", toStep1, false);
    document.querySelector(".documents").addEventListener("click", toStep3, false);
    document.querySelector(".documents .back").addEventListener("click", toStep2, false);
    var promos = document.querySelectorAll(".promos li");
    for(var i = 0; i < promos.length; i++){
        promos[i].addEventListener("click",
                function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    var selected = document.querySelector(".promos li.selected");
                    if(selected) selected.classList.remove("selected");
                    this.classList.add("selected");
                    document.body.className = "panes step-3";
                });
    }
    var documents = document.querySelectorAll(".documents li");
    for(var i = 0; i < documents.length; i++){
        documents[i].addEventListener("click",
                function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    var selected = document.querySelector(".documents li.selected");
                    if(selected) selected.classList.remove("selected");
                    this.classList.add("selected");
                    document.body.className = "panes step-4";
                });
    }
}
