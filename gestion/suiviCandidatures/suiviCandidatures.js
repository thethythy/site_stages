
function jsonParse(text) {
	console.log(text);
	try {
		var json = JSON.parse(text);
		//console.log(json);
	}
	catch(e) {
		return false;
	}
	return json;
}

function populateEtudiant(){
	var id_etu = document.getElementById('idEtudiant').value;
	var length = document.querySelectorAll('[id^="ligneCandidature-"]').length;

	var urlEncodeData = 'idEtudiant=' + id_etu + '&' +
	'length=' + length;

	xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var json = jsonParse(this.responseText);
			//console.log("!json (print erreur si false) = "+json)
			if (!json || json.requestStatus !== true) {
				document.getElementById('erreurAjax').innerHTML = (json.error || "Une erreur est survenue.") + "\nVous pouvez réactualiser la page et recommencer.";
				return;
			}
			/* Traitement de la réponse */
			if(json.idEtudiant == 0){
				for(var i = 1 ; i < json.length +1; i++){
					document.getElementById('ligneCandidature-'+i).style.display = '';
				}
			} else {
				for(var i = 1 ; i < json.length +1; i++){
					if((document.getElementsByName('nomEtu-'+i)[0].id.split('-')[1]) != json.idEtudiant){
						document.getElementById('ligneCandidature-'+i).style.display = 'none';
					} else {
						document.getElementById('ligneCandidature-'+i).style.display = '';
					}
				}
			}
		}
	}

	xhr.open('POST', 'etudiantData.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(urlEncodeData);
}