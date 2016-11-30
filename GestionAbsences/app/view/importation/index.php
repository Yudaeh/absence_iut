<?php
	require(HEADER);
	
	# Gestion d'accés à la page pour les administrateurs et administratifs
	use GestionAbsences\Controleur\Connexion;
	if (!Connexion::estConnecteAdministrateur() && !Connexion::estConnecteAdministratif()) {
		header('Location: /projects/absence_iut/GestionAbsences/Connexion');
	}
?>
<br/>
<form method="post" action="">
	<div class="row">
		<div class="large-6 large-centered columns alert_mdp">
			<div class="callout large import_etudiant_tab">
				<center>
					<p class="text_tab">Importation d'étudiants</p>
					<button class="file-upload hollow button"><input type="file" class="file-input">Importer (.csv)</button>			
				</center>	
			</div>
			<center><input type="submit" class="button round" value="Valider"/></center>
		</div>
	</div>
</form>

<form method="post" action="">
	<div class="row">
		<div class="large-6 large-centered columns alert_mdp">
			<div class="callout large import_agenda_tab">
				<center>
					<p class="text_tab">Importation d'un agenda</p>
					<button class="file-upload hollow button"><input type="file" class="file-input">Importer (.ics)</button>			
				</center>	
			</div>
			<center><input type="submit" class="button round" value="Valider"/></center>
		</div>
	</div>
</form>
<br/>
<?php 
	require(FOOTER);
?>