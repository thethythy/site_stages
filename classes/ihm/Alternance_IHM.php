<?php

class Alternance_IHM {


  /**
  * Afficher une fiche d'alternance récapitulative
  * @param integer $idEtu Identifiant de l'étudiant
  * @param integer $idPromo Identifiant de la promotion
  * @param string $chemin Chemin d'accès au fichier résumé s'il existe
  */
  public static function afficherFicheAlternance($idEtu, $idPromo, $chemin) {
    $etudiant = Etudiant::getEtudiant($idEtu);
    $promotion = Promotion::getPromotion($idPromo);
    $filiere = $promotion->getFiliere();
    $parcours = $promotion->getParcours();
    $contrat = $etudiant->getContrat($promotion->getAnneeUniversitaire());
    $contact = $contrat->getContact();
    $entreprise = $contact->getEntreprise();
    $parrain = $contrat->getParrain();
    $annee = $promotion->getAnneeUniversitaire();
    ?>

    <table>
      <tr>
        <td style="border: 1px solid; padding: 15px;">
          <h3>L'étudiant(e)</h3>
          <?php echo $etudiant->getPrenom()." ".$etudiant->getNom(); ?><br/>
          <?php echo "Email : ".$etudiant->getEmailInstitutionel(); ?><br/>
          Promotion : <?php echo $filiere->getNom()." ".$parcours->getNom(); ?><br/>
          Année : <?php echo $annee."-".($annee + 1); ?>
        </td>
        <td style="border: 1px solid; padding: 15px;">
          <h3>Le référent universitaire</h3>
          <?php echo $parrain->getPreNom()." ".$parrain->getNom(); ?><br/>
          <?php echo "Email : ".$parrain->getEmail(); ?>
        </td>
      </tr>
      <tr>
        <td style="border: 1px solid; padding: 15px;">
          <h3>L'entreprise</h3>
          <?php echo $entreprise->getNom(); ?> <br/>
          <?php echo $entreprise->getAdresse(); ?> <br/>
          <?php echo $entreprise->getCodePostal(); ?>&nbsp;
          <?php echo $entreprise->getVille(); ?> <br/>
          <?php echo $entreprise->getPays(); ?>
        </td>
        <td style="border: 1px solid; padding: 15px;">
          <h3>Le contact dans l'entreprise</h3>
          <?php
          echo $contact->getPrenom()." ".$contact->getNom()."<br/>";

          if ($contact->getTelephone() != "" && strlen($contact->getTelephone()) > 1)
          echo "Tél. : ".$contact->getTelephone()."<br/>";

          if ($contact->getTelecopie() != "")
          echo "Fax : ".$contact->getTelecopie()."<br/>";

          if ($contact->getEmail() != "")
          echo "Email : ".$contact->getEmail();
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="column-span: all; border: 1px solid; padding: 15px;">
          <h3>L'alternance</h3>
          <?php
          if ($contrat->aSonResume == "1"){
            echo "<a href='".$chemin.$contrat->getSujetDeStage()."'>Résumé du stage</a>";
          } else {
            $chaine = $contrat->getSujetDeContrat();
            echo $chaine;
          }
          ?>
        </td>
      </tr>
    </table>
    <?php
  }
}

?>
