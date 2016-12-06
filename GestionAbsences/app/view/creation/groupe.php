<?php
	require(HEADER);
	
	# Gestion d'accés à la page pour les administrateurs et administratifs
	use GestionAbsences\Controleur\Connexion;
	use GestionAbsences\Modele\Filiere;
	if (!Connexion::estConnecteAdministrateur() && !Connexion::estConnecteAdministratif()) {
		header('Location: /projects/absence_iut/GestionAbsences/Connexion');
	}
?>

<!-- Formulaire création d'un département -->
<form method="post" action="Creation/newGroupe" class="formulaire_creation">
	<div class="row">
		<div class="large-6 large-centered columns">
		<center><h3>Créer un groupe :</h3></center>
      		<label>Nom :
        		<input type="text" placeholder="Nom du groupe" name="nomGroupe"/>
      		</label>
      	</div>
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
      		<label>Description :
        		<textarea placeholder="Description du groupe..."></textarea>
      		</label>
      	</div>
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
      		<label>Le département :
        		<select name="filiere">
        			<?php 
        				$filiere = new Filiere(0);
        				$infoFiliere = $filiere->getAll();   				
        				foreach($infoFiliere as $row) {
        					echo '<option value="'.$row->ID_F.'">'.$row->Nom_F.'</option>';
        				}    			
        			?>
       			</select>
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

