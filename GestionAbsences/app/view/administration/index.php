<?php
	require(HEADER);
	
	# Gestion d'accés à la page pour les administrateurs et administratifs
	use GestionAbsences\Controleur\Connexion;
	if (!Connexion::estConnecteAdministrateur() && !Connexion::estConnecteAdministratif()) {
		header('Location: /projects/absence_iut/GestionAbsences/Connexion');
	}
?>
<div class="row">
	<div class="large-6 large-centered columns">
		<div class="thumbnail image_option">
      		<a href="Creation"><img src="http://formationsjira.com/wp-content/uploads/2015/04/Optimized-329c13a.jpg"></a>
      		<center><h3>Création</h3></center>
    	</div>		
	</div>
</div>

<div class="row">
	<div class="large-6 large-centered columns">
		<div class="thumbnail image_option">
      		<a href="Importation"><img src="http://cdn.makeuseof.com/wp-content/uploads/2013/09/spreadsheet-import-670x335.jpg?004f0d"></a>
      		<center><h3>Importation</h3></center>
    	</div>		
	</div>
</div>

<br/>

<?php 
	require(FOOTER);
?>