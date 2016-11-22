<?php 
	use GestionAbsences\Controleur\Connexion;
?>
<!doctype html>
<html class="no-js" lang="fr" dir="ltr">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SatellysReborn</title>
<link rel="stylesheet" href="public/css/foundation.css">
<link rel="stylesheet" href="public/css/app.css">
<link rel="stylesheet"
	href="public/icon/foundation-icons/foundation-icons.css">
<link rel="icon" href="../GestionAbsences/public/media/picture/SatellysReborn.ico">
</head>

<body>

	<div class="row">
		<div class="large-6 large-centered columns titreentete">
			<h1>
				<center class="titre">Satellys Reborn</center>
			</h1>
		</div>
	</div>

	<!-- Top Bar de navigation -->
	<div class="row">
		<div class="large-12 columns">
			<div class="top-bar menu-navigation">
				<div class="top-bar-left">
					<ul class="dropdown menu" data-dropdown-menu>
						<li><a href="Accueil" class="accueil-style">Accueil</a></li>
						<?php 
							# Si l'on est connecte
							if (Connexion::estConnecte()) {
								echo '<li><a href="#">Administration</a></li>';
							}
						?>
						
					</ul>
				</div>

				<!-- Condition � r�aliser si l'utilisateur est connecté (prof, admin) 
				Si connect� => Mon profil et déconnexion
				Si non connect� => connexion -->
				<div class="top-bar-right ">
					<ul class="dropdown menu" data-dropdown-menu>
						<li><a href="#"><i class="fi-torso-business"></i></a>
							<ul class="menu vertical">
								<?php 
									# Si l'on est connecte
									if (Connexion::estConnecte()) {
										echo '<li><a href="#">Mon profil</a></li>';
										echo '<li><a href="Connexion/deconnexion">Deconnexion</a></li>';
									} else {
										echo '<li><a href="Connexion">Connexion</a></li>';
									}
								?>
								
								
							</ul></li>
					</ul>
				</div>
			</div>
		</div>
	</div>