<?php
require (HEADER);
?>

<div class="row">

	<div class="medium-8 medium-centered large-6 large-centered columns log-in-form">
		<form method="post" action="Connexion/connection/<?php $_POST["nomUtilisateur"]?>/<?php $_POST["password"]?>">
			<div class="row column">
				<h4 class="text-center head-form">Connexion au compte</h4>
				<label>Nom d'utilisateur <input type="text"
					placeholder="Nom d'utilisateur" name="nomUtilisateur">
				</label> <label>Mot de passe <input type="password"
					placeholder="Mot de passe" name="password">
				</label> 
				</br>
				<p>
					<input type="submit" class="button expanded" value="Connexion"/>
				</p>
			</div>
		</form>
	</div>

</div>

<!-- FOOTER SCRIPT -->
<script src="public/js/vendor/jquery.js"></script>
<script src="public/js/vendor/what-input.js"></script>
<script src="public/js/vendor/foundation.js"></script>
<script src="public/js/app.js"></script>
</body>

<footer> </footer>
</html>