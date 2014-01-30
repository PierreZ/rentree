$(document).ready(
	function() {
		initLogin();
		function login(e){
		e.preventDefault();
		var b = document.querySelector("button");
		b.disabled = true;
		b.classList.add("loading");

		document.activeElement.blur();
		var URL = window.location.protocol + "//" + window.location.host+"/session"
		var $email=$('#email').val(),
			$paswd=$('#password').val();
		jQuery.ajax({
			type: 'POST', 
			url: URL,
			data: {
				email: $email, 
				password: $paswd
			}, 
			success: function(data, textStatus, jqXHR) {
				alert(data);
				window.setTimeout(function(){document.body.classList.add("fade");}, 2000, false);
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
