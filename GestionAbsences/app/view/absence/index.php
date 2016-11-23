<?php
	require(HEADER);
	
	# Gestion d'accés à la page pour les administrateurs et administratifs
	use GestionAbsences\Controleur\Connexion;
	if (!Connexion::estConnecte()) {
		header('Location: /projects/absence_iut/GestionAbsences/Connexion');
	}
?>


<?php 
	require(FOOTER);
?>