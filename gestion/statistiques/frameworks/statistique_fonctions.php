<?php

class Statistiques {

    public static function selectionAnnee($vide) {
	$page = "statistiquesData.php";
	?>
	<form method=post action="javascript:">
	    <table width="100%">
		<tr>
		    <td align="center" >
			S&eacute;lectionnez l'ann&eacute;e :
			<select id="annee" name="annee">
			    <?php
			    if ($vide)
				echo "<option value=''></option>";
			    $tabAU = Promotion_BDD::getAnneesUniversitaires();
			    for ($i = 0; $i < sizeof($tabAU); $i++) {
				if ((isset($_POST['annee'])) && ($_POST['annee'] == $tabAU[$i]))
				    echo "<option selected value='$tabAU[$i]'>" . $tabAU[$i] . "-" . ($tabAU[$i] + 1) . "</option>";
				else
				    echo "<option value='$tabAU[$i]'>" . $tabAU[$i] . "-" . ($tabAU[$i] + 1) . "</option>";
			    }
			    ?>
			</select>
		    </td>
		</tr>
	    </table>
	</form>

	<script type="text/javascript">
	    var table = new Array("annee");
	    new LoadData(table, "<?php echo $page; ?>", "onchange");
	</script>
	<?php
    }

}
?>