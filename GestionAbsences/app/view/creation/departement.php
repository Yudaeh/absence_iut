<?php
	require(HEADER);
	
	# Gestion d'accés à la page pour les administrateurs et administratifs
	use GestionAbsences\Controleur\Connexion;
	if (!Connexion::estConnecteAdministrateur() && !Connexion::estConnecteAdministratif()) {
		header('Location: /projects/absence_iut/GestionAbsences/Connexion');
	}
?>

<!-- Formulaire création d'un département -->
<form class="formulaire_creation">
	<div class="row">
		<div class="large-6 large-centered columns">
		<center><h3>Créer un département :</h3></center>
      		<label>Nom :
        		<input type="text" placeholder="Nom du département" />
      		</label>
      	</div>
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
      		<label>Description :
        		<textarea placeholder="Description du département..."></textarea>
      		</label>
      	</div>
	</div>
	
	<div class="row">
      	<div class="large-6 large-centered columns">
      		<center><input type="submit" class="button round" value="Valider"/></center>
      	</div>
	</div>        	
</form>

<?php 
	require(FOOTER);
?>
