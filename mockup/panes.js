function submit(e){
    e.preventDefault();
    var b = document.querySelector("button");
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
    document.querySelector(".documents").addEventListener("click",
            function(e){
                e.preventDefault();
                document.body.className = "panes step-2";
                var selected = document.querySelector(".documents li.selected");
                if(selected) selected.classList.remove("selected");
            }, false);
    var documents = document.querySelectorAll(".documents li");
    for(var i = 0; i < documents.length; i++){
        documents[i].addEventListener("click",
                function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    var selected = document.querySelector(".documents li.selected");
                    if(selected) selected.classList.remove("selected");
                    this.classList.add("selected");
                    document.body.className = "panes step-3";
                });
    }
}
