function submit(e){
    e.preventDefault();

    // Si le formulaire n'est pas complet
    if (nom.length < 1 || email.length < 1 || ddn.length < 1
    || email-parents.length < 1  || tel-parents.length < 1) {
        var button = document.querySelector(".contact button");
        button.querySelector(".label").innerHTML="Formulaire incomplet";
        window.setTimeout(function() {button.querySelector(".label").innerHTML="Envoyer";}, 1000, false);
       return;
       };

    // On stocke les éléments du formulaire
    var URL = window.location.protocol + "//" + window.location.host+"?/eleves/"+eleve_id;

    var nom_eleve=$('#nom').val(),
        email_eleve=$('#email').val(),
        ddn=$('#ddn').val(),
        email_parents=$('#email-parents').val(),
        tel_parents=$('#tel-parents').val();
        nom_parents=$('#nom-parents').val(),

    var b = document.querySelector("button");
    b.disabled = true;
    b.classList.add("loading");

    document.activeElement.blur();
    jQuery.ajax({
        type: 'POST', 
        url: URL,
        data: {
            id:eleve_id,
            nom:nom_eleve,
            email:email_eleve,
            datenaissance:ddn,
            emailparent:email_parents,
            telparent:tel_parents,
            nomparent:nom_parents,
        },
        statusCode: {
            403: function() {
                //TODO
            }
        },
        success: function(data) {
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
    });
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
