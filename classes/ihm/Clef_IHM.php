<?php

class Clef_IHM {

  /**
  * Afficher un formulaire permettant de définir une nouvelle valeur de clef
  * sachant que la clé actuelle est affichée pour information
  * @param string $HClef Le condensat de la clé actuelle
  */
  public static function afficherFormulaireDefinitionClef($HClef) {
    ?>

    <script type="text/javascript">
    //Change l'attribut readOnly de l'élément dont l'id est spécifiée
    function swapReadOnly(id) {
      (document.getElementById(id).readOnly === true) ?
      document.getElementById(id).readOnly = false :
      document.getElementById(id).readOnly = true;
    }

    // Coche le bouton radio passé en paramètre
    function checkType(rad) {
      rad.checked = true;
    }

    function afficherCondensat(){
      // Récupérer la valeur du bouton coché : Stagiaire ou Alternant
      var typeActuel = (document.getElementById('radioAlt').checked === true) ?
      document.getElementById('radioAlt').value :
      document.getElementById('radioStage').value;
      console.log('p5 : typeActuel = ' + typeActuel);

      document.getElementById('clefactuelle').value = '';
      document.getElementById('condensat').value = '';

      if (typeActuel === "alternant") {
        // Stockage sur le poste gestionnaire existant
        document.getElementById('clefactuelle').value = localStorage.getItem('clefAlt');
        document.getElementById('condensat').value = '<?php echo $HClef; ?>';
      }
      if (typeActuel === "stagiaire") {
        // Stockage sur le poste gestionnaire existant
        document.getElementById('clefactuelle').value = localStorage.getItem('clefStage');
        document.getElementById('condensat').value = '<?php echo $HClef; ?>';
      }





      // if(localStorage.getItem('clef') && localStorage.getItem('type') === typeActuel) {
      //   console.log('p6 existe');
      //   // Stockage sur le poste gestionnaire existant
      //   document.getElementById('clefactuelle').value = localStorage.getItem('clef');
      //   document.getElementById('condensat').value = '<?php echo $HClef; ?>';
      // } else {
      //   // Pas de stockage sur le poste gestionnaire
      //   console.log('p6 n\'existe pas');
      //   var cleActuelle = document.getElementById('clefactuelle');
      //   document.getElementById('clefactuelle').value = '';
      //   document.getElementById('condensat').value = '';
      // }
    }
    var auchargement = function() {

      // Rendre les champs d'affichage modifiables
      swapReadOnly("condensat");
      swapReadOnly("clefactuelle");
      console.log('p1');

      // Si la clef est définie alors la sauvegarder sur le poste gestionnaire
      // Récupération de la dernière clef entrée
      var clef = '<?php echo $_POST["clef"]; ?>';
      //Récupération du dernier type de clef entré
      var type = '<?php echo $_POST["type"]; ?>';
      var radioAlt = document.getElementById('radioAlt');
      var radioStage = document.getElementById('radioStage');

      console.log('p2');
      // Cocher le bouton alternant si c'est le dernier qu'on a utilisé
      type === "alternant" ? checkType(radioAlt) : checkType(radioStage);
      console.log('p3');
      if (clef !== '') {
        localStorage.setItem('type', type);
        localStorage.setItem('clef', clef);
        if (type === 'alternant') {
          localStorage.setItem('clefAlt', clef);
        } else {
          localStorage.setItem('clefStage', clef);
        }
      }
      console.log('p4');
      afficherCondensat();
      console.log('p7');
      // La clef est mise
      // if(localStorage.getItem('clef') && localStorage.getItem('type') === typeActuel) {
      //   // Stockage sur le poste gestionnaire existant
      //   document.getElementById('clefactuelle').value = localStorage.getItem('clef');
      //   document.getElementById('condensat').value = '<?php echo $HClef; ?>';
      // } else {
      //   // Pas de stockage sur le poste gestionnaire
      //   var cleActuelle = document.getElementById('clefactuelle');
      //   document.getElementById('clefactuelle').value = 'clef pas encore définie';
      //   document.getElementById('condensat').value = 'condensat pas encore calculé';
      // }
      // Rendre les champs d'affichage non-modifiables
      swapReadOnly("condensat");
      swapReadOnly("clefactuelle");
    };

    // var auchargement = function() {
    //   f1();
    //   f2();
    //   f3();
    // }
    </script>

    <form method="post" action="">
      <table>
        <tr id="entete2">
          <td colspan="2">Définir une nouvelle clef</td> <!--Titre -->
        </tr>
        <tr>
          <tr><td>&nbsp;</td></tr>
          <td colspan="2" class="align-center">
            <input type="radio" id="radioStage" name="type" value="stagiaire" onchange="afficherCondensat()" checked > Stage
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="radioAlt" name="type" value="alternant" onchange="afficherCondensat()"> Alternant
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <th width="100">Clef actuelle</th>
          <td>
            <input id="clefactuelle" placeholder="Clef pas encore définie" readOnly="true"  type="text"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="condensat" placeholder="Condensat pas encore généré" readOnly="true"  type="text"/>
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <th width="100">Nouvelle clef</th>
          <td>
            <input type="text" name="clef" value=""/>
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="genere" value="Générer le condensat"/>
          </td>
        </tr>
      </table>
    </form>
    <?php
  }

  /**
  * Afficher la valeur de la clée actuelle et la valeur de son condensat
  * @param string $HClef Le condensat de la clé actuelle
  */
  public static function afficherClef($HClef) {
    ?>
    <script type="text/javascript">
    var auchargement = function() {

      // Rendre les champs d'affichage modifiables
      document.getElementById('condensat').readOnly = false;
      document.getElementById('clefactuelle').readOnly = false;

      // Récupérer la valeur du bouton coché : Stagiaire ou Alternant
      var radios = document.getElementsByName('type');
      var value;

      for(var i = 0 ; i < radios.length; i++){
        if(radios[i].checked) { value = radios[i].value; }
      }

      if (!localStorage.getItem('clef') || localStorage.getItem('type') !== value) {
        // Pas de stockage sur le poste gestionnaire
        var cleActuelle = document.getElementById('clefactuelle');
        document.getElementById('clefactuelle').value = 'clef pas encore définie';
        document.getElementById('condensat').value = 'condensat pas encore calculé';
      } else {
        // Stockage sur le poste gestionnaire existant
        document.getElementById('clefactuelle').value = localStorage.getItem('clef');
        document.getElementById('condensat').value = '<?php echo $HClef; ?>';
      }

      // Rendre les champs d'affichage non-modifiables
      document.getElementById('condensat').readOnly = true;
      document.getElementById('clefactuelle').readOnly = true;
    };
    </script>
    <br/>
    <form method="post" action="">
      <table>
        <tr id="entete2">
          <td colspan="2">Rappel de la clef actuelle</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <th width="100">Clef actuelle</th>
          <td>
            <input id="clefactuelle" type="text"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="condensat" type="text"/>
          </td>
        </tr>
      </table>
    </form>
    <?php
  }
}

?>
