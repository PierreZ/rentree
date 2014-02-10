$(document).ready(
	function() {
		
		// Appel de initLogin 
		initLogin();


		// this is where we load the next page
		
		function initLogin(e){
			var b = document.querySelector("body.login button");
			b.disabled = false;
		}
	}
);
