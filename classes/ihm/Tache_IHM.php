<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Tache_BDD.php");
include_once("../../classes/moteur/Tache.php");

class Tache_IHM {

    public static function afficherFormulaireSaisie($test) {
	?>
	<form method="POST" action="">
	    <table id="table_saisieTache">
		<tr>
		    <td colspan=2>
			<table id="presentation_saisieTache">
			    <tr id="entete2">
				<td colspan=2>Gestion des t�ches&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($test == 1) printf("[D�mon en marche]"); if ($test == 0) printf("[D�mon en d�faut]"); if ($test == -1) printf("[D�mon arr�t�]"); ?></td>
			    </tr>
			    <tr><td>&nbsp;</td></tr>
			    <tr>
				<table>
				    <tr>
					<th align=center>Intitul�</th>
					<th align=center>Priorit�</th>
					<th align=center>Date limite</th>
					<th align=center>Statut</th>
					<th align=center>Action</th>
				    </tr>
				    <?php
				    // R�cup�ration de la liste des t�ches
				    foreach (Tache::listerTaches() as $oTache) {
					printf("<tr>");
					printf("<td align=center><input type=text name=intitule[%s] value='%s'/></td>", $oTache->getIdentifiantBDD(), htmlentities($oTache->getIntitule(), ENT_QUOTES, 'iso-8859-1'));
					printf("<td align=center><input type=number min=0 step=1 name=priorite[%s] value='%s'/></td>", $oTache->getIdentifiantBDD(), $oTache->getPriorite());
					printf("<td align=center><input type=date name=datelimite[%s] value='%s'/></td>", $oTache->getIdentifiantBDD(), $oTache->getDateLimite());
					printf("<td>");
					printf("<div style='border:1px solid #ddd;'>");
					printf("<input type=radio name=statut[%s] value='Finie' %s/>&nbsp;&nbsp;Finie<br/>", $oTache->getIdentifiantBDD(), $oTache->getStatut() == 'Finie' ? 'checked' : "");
					printf("<input type=radio name=statut[%s] value='En cours' %s/>&nbsp;&nbsp;En cours<br/>", $oTache->getIdentifiantBDD(), $oTache->getStatut() == 'En cours' ? 'checked' : "");
					printf("<input type=radio name=statut[%s] value='Pas fait' %s/>&nbsp;&nbsp;Pas fait", $oTache->getIdentifiantBDD(), $oTache->getStatut() == 'Pas fait' ? 'checked' : "");
					printf("</div>");
					printf("</td>");
					printf("<td align=center>");
					printf("<input type=submit name=delete[%s] value='Supprimer'", $oTache->getIdentifiantbDD());
					printf("</td>");
					printf("</tr>");
				    }
				    ?>
				    <tr>
					<td align="center"><input type=text name=newintitule placeholder="&lt;Editer l'intitul�&gt;"/></td>
					<td align="center"><input type=number min=0 step=1 name=newpriorite value="0"/></td>
					<td align="center"><input type=date name=newdatelimite value="<?php echo date("Y-m-d"); ?>"/></td>
					<td>
					    <div style="border:1px solid #ddd;">
						<input type=radio name=newstatut value='Finie'/>&nbsp;&nbsp;Finie<br/>
						<input type=radio name=newstatut value='En cours'/>&nbsp;&nbsp;En cours<br/>
						<input type=radio name=newstatut value='Pas fait' checked/>&nbsp;&nbsp;Pas fait
					    </div>
					</td>
					<td align="center">
					    <input type=submit name=new value="Enregistrer"/>
					</td>
				    </tr>
				</table>
			    </tr>
			    <tr><td>&nbsp;</td></tr>
			    <tr>
				<td align=center>
				    <input type=submit name=submit value="Enregistrer les modifications"/>&nbsp;&nbsp;&nbsp;
				    <input type=submit name=reset value="R�initialiser"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <input type=submit name=go value="Lancer le d�mon"/>&nbsp;&nbsp;&nbsp;
				    <input type=submit name=stop value="Arr�ter le d�mon"/>
				</td>
			    </tr>
			    <tr><td>&nbsp;</td></tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>

	<br/>

	<table align="center">
	    <tr>
		<td width="100%" align="center">
		    <form method=post action="../">
			<input type="submit" value="Retour"/>
		    </form>
		</td>
	    </tr>
	</table>

	<?php
    }
}
?>