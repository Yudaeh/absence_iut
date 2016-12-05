<?php
	require(HEADER);
	
	use GestionAbsences\Controleur\Connexion;
	use GestionAbsences\Modele\Etudiant;
	use GestionAbsences\Modele\Matiere;
	use GestionAbsences\Modele\Planning;
	use GestionAbsences\Modele\Date;
	
	# Gestion d'accés à la page pour les administrateurs et administratif
	if (!Connexion::estConnecte()) {
		header('Location: /projects/absence_iut/GestionAbsences/Connexion');
	}
?>

<form class="formulaire_creation">
	<div class="row">
		<div class="large-6 large-centered columns">
		<center><h3>Déclarer une absence :</h3></center>
      		<label>L'étudiant :
        		<select>
        			<?php 
        				$etudiant = new Etudiant();
        				$infoEtudiant = $etudiant->getAll();   				
        				foreach($infoEtudiant as $row) {
        					echo '<option value="'.$row->INE.'">'.$row->Nom_E.' '.$row->Prenom_E.'</option>';
        				}    			
        			?>
       			</select>
      		</label>
      	</div>
	</div>	
	<div class="row">
      	<div class="large-6 large-centered columns">
      		<label>Le cours :
      		<select>
      			<option value="starbuck">Starbuck</option>
          		<option value="hotdog">Hot Dog</option>
          		<option value="apollo">Apollo</option>
      			
        		<?php 
//         			$planning = new Planning();
//         			$infoPlanning = $etudiant->getAll();   
        							
//         			foreach($infoPlanning as $row) {
//         				$matiere = new Matiere($row->id_matiere);
//         				$date = new Date($row->id_date);
//         				$date->charger();
//         				$matiere->charger();
        				
//         				echo '<option value="'.$row->id_cours.'">'.$matiere->Nom_M.' à '.$date->Heure_deb.'le '.$date->jour.'/'.$date->mois.'/'.$date->an.'</option>';
//         			}    			
        		?>
        	<select>
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