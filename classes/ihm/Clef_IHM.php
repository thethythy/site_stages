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
    var auchargement = function() {
      // Rendre les deux champs modifiables
      document.getElementById('condensat').readOnly = false;
      document.getElementById('clefactuelle').readOnly = false;

      //type == stagiaire ou alternant

      // Si la clef est définie alors la sauvegarder sur le poste gestionnaire
      var clef = '<?php echo $_POST["clef"]; ?>';
      var type = '<?php echo $_POST["type"]; ?>';

      if(type == 'alternant'){
        document.getElementById("radAlt").checked = true;
      }

      if (clef !== '') {
       localStorage.setItem('type', type);
       if(type == 'stagiaire'){
         localStorage.setItem('clef_stage', clef);
         localStorage.setItem('condensat_stage', "<?php echo $HClef; ?>");
       }
       else {
         localStorage.setItem('clef_alt', clef);
         localStorage.setItem('condensat_alt', "<?php echo $HClef; ?>");
       }
     }

      swap();

      // Rendre les deux champs non modifiables
      document.getElementById('condensat').readOnly = true;
      document.getElementById('clefactuelle').readOnly = true;
    };

    function swap(){

      // Rendre les deux champs modifiables
      document.getElementById('condensat').readOnly = false;
      document.getElementById('clefactuelle').readOnly = false;

      // Récupérer la valeur du bouton coché : Stagiaire ou Alternant
      var radios = document.getElementsByName('type');
      var type;

      for(var i = 0 ; i < radios.length; i++){
        if(radios[i].checked) { type = radios[i].value; }
      }

      if(type == 'stagiaire'){
          if(localStorage.getItem('clef_stage')){
            document.getElementById('clefactuelle').value = localStorage.getItem('clef_stage');
            document.getElementById('condensat').value = localStorage.getItem('condensat_stage');
          } else {
            document.getElementById('clefactuelle').value = '';
            document.getElementById('condensat').value = '';
          }
      } else {
        if(localStorage.getItem('clef_alt')){
          document.getElementById('clefactuelle').value = localStorage.getItem('clef_alt');
          document.getElementById('condensat').value = localStorage.getItem('condensat_alt');
        } else {
          document.getElementById('clefactuelle').value = '';
          document.getElementById('condensat').value = '';
        }
      }

      // Rendre les deux champs non modifiables
      document.getElementById('condensat').readOnly = true;
      document.getElementById('clefactuelle').readOnly = true;

    }
    </script>


    <form method="post" action="">
      <table>
        <tr id="entete2">
          <td colspan="2">Définir une nouvelle clef</td> <!--Titre -->
        </tr>
        <tr>
          <tr><td>&nbsp;</td></tr>
          <td colspan="2" class="align-center">
            <input type="radio" id="radStage" name="type" value="stagiaire" onclick="swap()" checked> Stage
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="radAlt" name="type" onclick="swap()" value="alternant"> Alternant
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <th width="100">Clef actuelle</th>
          <td>
            <input id="clefactuelle" placeholder="Clef pas encore définie" type="text" readonly="true"  />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="condensat" placeholder="Condensat pas encore calculé" readonly="true" type="text" />
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
      swap();
    }

    function swap(){

      // Rendre les deux champs modifiables
      document.getElementById('condensat').readOnly = false;
      document.getElementById('clefactuelle').readOnly = false;

      // Récupérer la valeur du bouton coché : Stagiaire ou Alternant
      var radios = document.getElementsByName('type');
      var type;

      for(var i = 0 ; i < radios.length; i++){
        if(radios[i].checked) { type = radios[i].value; }
      }

      if(type == 'stagiaire'){
          if(localStorage.getItem('clef_stage')){
            document.getElementById('clefactuelle').value = localStorage.getItem('clef_stage');
            document.getElementById('condensat').value = localStorage.getItem('condensat_stage');
          } else {
            document.getElementById('clefactuelle').value = '';
            document.getElementById('condensat').value = '';
          }
      } else {
        if(localStorage.getItem('clef_alt')){
          document.getElementById('clefactuelle').value = localStorage.getItem('clef_alt');
          document.getElementById('condensat').value = localStorage.getItem('condensat_alt');
        } else {
          document.getElementById('clefactuelle').value = '';
          document.getElementById('condensat').value = '';
        }
      }

      // Rendre les deux champs non modifiables
      document.getElementById('condensat').readOnly = true;
      document.getElementById('clefactuelle').readOnly = true;

    }

    </script>
    <br/>
    <form method="post" action="">
      <table>
        <tr id="entete2">
          <td colspan="2">Définir une nouvelle clef</td> <!--Titre -->
        </tr>
        <tr>
          <tr><td>&nbsp;</td></tr>
          <td colspan="2" class="align-center">
            <input type="radio" id="radStage" name="type" value="stagiaire" onclick="swap()" checked> Stage
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" id="radAlt" name="type" onclick="swap()" value="alternant"> Alternant
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <th width="100">Clef actuelle</th>
          <td>
            <input id="clefactuelle" placeholder="Clef pas encore définie" type="text" readonly="true"  />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="condensat" placeholder="Condensat pas encore calculé" readonly="true" type="text" />
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
      </table>
    </form>
    <?php
  }
}

?>
