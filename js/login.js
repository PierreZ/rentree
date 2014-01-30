$(document).ready(
	function() {
		initLogin();
		function login(e){
		e.preventDefault();
		var b = document.querySelector("button");
		b.disabled = true;
		b.classList.add("loading");

		document.activeElement.blur();
		var URL = window.location.protocol + "//" + window.location.host+"/session";
        alert(URL);
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
			success: function(data, textStatus, jqXHR) {
				alert(data);
                if (data) {};
				document.body.classList.add("fade");
				window.setTimeout(function(){
					document.body.classList.remove("login");
					document.body.innerHTML = document.querySelector("template.panes").innerHTML;
					document.body.classList.add("step-1");
					document.body.classList.add("panes");
					window.setTimeout(function(){
						document.body.classList.remove("fade");
						}, 100, false);
					initPanes();
					},  3000, false);
				},
			error: function(jqXHR, textStatus, errorThrown) {
            var b = document.querySelector("button");
            b.disabled = false;
            b.classList.remove("loading");
            return false;
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
