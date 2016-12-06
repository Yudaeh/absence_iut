<?php
	require(HEADER);
	
	# Gestion d'accés à la page pour les administrateurs et administratifs
	use GestionAbsences\Controleur\Connexion;

	if (!Connexion::estConnecteAdministrateur() && !Connexion::estConnecteAdministratif()) {
		header('Location: /projects/absence_iut/GestionAbsences/Connexion');
	}
?>

<!-- Formulaire création d'un département -->
<form method="post" action="Creation/newDepartement" class="formulaire_creation">
	<div class="row">
		<div class="large-6 large-centered columns">
		<center><h3>Créer un département :</h3></center>
      		<label>Nom :
        		<input type="text" placeholder="Nom du département" name="nomDepartement"/>
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

<!-- Si erreur lors de la saisie mdp et login -->
<?php if(isset($_SESSION['error']) && $_SESSION['error'] == "2") {?>
<div class="row">
	<div class="medium-8 medium-centered large-6 large-centered columns alert_mdp">
		<div class="callout alert">
			<center><h5>Erreur : Veuillez spécifier le nom</h5></center>
		</div>
	</div>
</div>
<?php }?>

<!-- Initialisation erreur -->
<?php $_SESSION['error'] = "0"?>

<?php 
	require(FOOTER);
?>
