$(document).ready(
	function() {
		
		// Appel de initLogin 
		initLogin();

		// Fonction permettant le login et la création de la session
		function login(e){
		e.preventDefault();
		var b = document.querySelector("button");
		b.disabled = true;
		b.classList.add("loading");

		document.activeElement.blur();
		var URL = window.location.protocol + "//" + window.location.host+"?/session";
		var email=$('#email').val(),
			paswd=$('#password').val();

        //Verification que les champs ne sont pas vides
        if (email.length < 1 || paswd.length < 1) {
            var b = document.querySelector("button");
            b.disabled = false;
            b.classList.remove("loading");
            return false;
        };
        // Début de la requête AJAX
		jQuery.ajax({
			type: 'POST', 
			url: URL,
			data: {
				email: email, 
				password: paswd
			},
			statusCode: {
				403: function() {
					var b = document.querySelector("button");
					b.disabled = false;
					b.classList.remove("loading");
					return false;
				}
			},
			success: function(data) {
				// Ajout des info de login dans les cookies
				document.cookie = "session_key=" + data.key;
				if(!data.is_admin)
				document.cookie = "id_eleve=" + data.id;
				var eleve_id = data.id;

				// changement des classes pour le CSS
				document.body.classList.add("fade");
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
						// Initialisation de la partie Angular
					    angular.element($("body")).scope().init();
				        }
				
				
			
		});

		// this is where we load the next page
		}
		function initLogin(e){
			var b = document.querySelector("body.login button");
			b.disabled = false;
			document.querySelector("body.login form").addEventListener("submit", login, false);
		}
	}
);
