<?php
	require(HEADER);
	
	# Gestion d'accés à la page pour les administrateurs et administratifs
	use GestionAbsences\Controleur\Connexion;
	if (!Connexion::estConnecteAdministrateur() && !Connexion::estConnecteAdministratif()) {
		header('Location: /projects/absence_iut/GestionAbsences/Connexion');
	}
?>

<!-- Formulaire création d'un professeur -->
<form class="formulaire_creation">
	<div class="row">
		<div class="large-6 large-centered columns">
		<center><h3>Créer un professeur :</h3></center>
      		<label>Nom :
        		<input type="text" placeholder="Nom" />
      		</label>
      	</div>
	</div>
	
	<div class="row">
      	<div class="large-6 large-centered columns">
      		<label>Prénom :
        		<input type="text" placeholder="Prénom" />
      		</label>
      	</div>
	</div>
	
	<div class="row">
      	<div class="large-6 large-centered columns">
      		<label>Tel :
        		<input type="text" placeholder="06 XX XX XX XX" />
      		</label>
      	</div>
	</div>
	
	<div class="row">
      	<div class="large-6 large-centered columns">
      		<div class="row collapse">
      			<label>E-mail : </label>
      			<div class="small-9 columns">
        			<input type="text" placeholder="email"/>
        		</div>
        		<div class="small-1 columns">
         			<center><span class="postfix">@</span></center>
       			</div>
       			<div class="small-2 columns">
        			<input type="text" placeholder="email.com"/>
        		</div>  			
      		</div>
      	</div>
	</div>
	
	<div class="row">
      	<div class="large-6 large-centered columns">
      		<label>Login :
        		<input type="text" placeholder="login" />
      		</label>
      	</div>
	</div>
	
	<div class="row">
      	<div class="large-6 large-centered columns">
      		<label>Mot de passe :
        		<input type="password" placeholder="Mot de passe" />
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
