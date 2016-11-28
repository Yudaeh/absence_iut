<?php
	require(HEADER);
	
	# Gestion d'accés à la page pour les administrateurs et administratifs
	use GestionAbsences\Controleur\Connexion;
	if (!Connexion::estConnecteAdministrateur() && !Connexion::estConnecteAdministratif()) {
		header('Location: /projects/absence_iut/GestionAbsences/Connexion');
	}
?>

<!-- Présentation pour accéder à la création d'administratifs (uniquement si administrateur) -->
<?php if (Connexion::estConnecteAdministrateur()) { ?>
<div class="row">
	<div class="large-6 large-centered columns alert_mdp">
		<div class="callout large administratif_creation_tab">
			<center>
				<p class="text_tab">Création d'un administratif</p>
				<a href="Creation/administratif"><button class="hollow button">Accéder</button></a>
			</center>	
		</div>
	</div>
</div>
<?php } ?>

<div class="row">
	<div class="large-6 large-centered columns alert_mdp">
		<div class="callout large professeur_creation_tab">
			<center>
				<p class="text_tab">Création d'un professeur</p>
				<a href="Creation/professeur"><button class="hollow button">Accéder</button></a>
			</center>	
		</div>
	</div>
</div>

<!-- Présentation pour accéder à la création d'un département -->
<div class="row">
	<div class="large-6 large-centered columns alert_mdp">
		<div class="callout large departement_creation_tab">
			<center>
				<p class="text_tab">Création d'un département</p>
				<a href="Creation/departement"><button class="hollow button">Accéder</button></a>
			</center>	
		</div>
	</div>
</div>

<!-- Présentation pour accéder à la création d'une filière -->
<div class="row">
	<div class="large-6 large-centered columns alert_mdp">
		<div class="callout large filiere_creation_tab">
			<center>
				<p class="text_tab">Création d'une filière</p>
				<a href="Creation/filiere"><button class="hollow button">Accéder</button></a>
			</center>	
		</div>
	</div>
</div>

<?php 
	require(FOOTER);
?>