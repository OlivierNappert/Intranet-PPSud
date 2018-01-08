<!DOCTYPE html>
<html style="height: 100%;">
<head>
  <title>Nouveau message - Intranet Polytech Paris-Sud</title>
  <meta charset="utf-8"/>
  <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script type="text/javascript" src="jquery-3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="newmessage.js"></script>
</head>

<body style="height: 100%; background-color: #888888;">
  <div class="container" style="min-height: 100%; background-color: white;
    padding: 0; height: auto;">

  <?php include_once('topnav.php'); ?>
  <?php include_once('navigation.php'); ?>

    <!-- Formulaire d'envoi de message -->
    <div class="col-sm-9" style="bottom: 0; top: 0; padding: 15px;">
      <div class="row" style="margin: 0">
        <div class="form-horizontal col-lg-9 col-md-8 col-sm-12">
          <div class="form-group">
            <label class="col-xs-3 control-label" for="new_msg_subject">
              Sujet
            </label>
            <div class="col-xs-9">
              <input type="text" name="new_msg_subject" id="new_msg_subject"
                placeholder="Sujet du message (max 255 caractères)."
                class="form-control" maxlength="255"/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-xs-3 control-label" for="new_msg_recipient">
              Destinataire(s)
            </label>
            <div class="col-xs-9">
              <div name="new_msg_recipient" id="new_msg_recipient" rows="1"
                class="form-control" style="overflow: auto; height: auto;"
                contenteditable></div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-12" style="text-align: center;">
          <button class="btn btn-default" onclick="sendMessage(); return false;">
            <span class="glyphicon glyphicon-send"></span>
            <br/>Envoyer
          </button>

          <button class="btn btn-default" onclick="window.history.back(); return false;">
            <span class="glyphicon glyphicon-remove"></span>
            <br/>Annuler
          </button>
        </div>
      </div>


      <!-- Contenu du message -->
      <div name="new_msg_content" id="new_msg_content" rows="4"
        class="form-control row" contenteditable
        style="min-height: 300px; height: auto; margin: 0 0 15px 0;">
      </div>


      <!-- Formulaire de création de question -->
      <div id="new_quest" class="row panel panel-default"
        style="padding: 0; margin: 0">
        <div class="panel-heading">
          <!-- Liste des types de questions disponibles -->
          <button class="btn btn-default new_quest_show" quest="text"
            type="button">
            Question ouverte
          </button>
          <button class="btn btn-default new_quest_show" quest="select"
            type="button">
            Choix multiples
          </button>

          <!-- Boutons communs à tous les types de fonction -->
          <div id="new_quest_form" style="display: none;">
            <button type="button" id="new_quest_add"
              class="btn btn-success">
              <span class="glyphicon glyphicon-plus"></span>
            </button>
            <button type="button" id="new_quest_modify"
              class="btn btn-info">
              <span class="glyphicon glyphicon-pencil"></span>
            </button>
            <button type="button" id="new_quest_cancel"
              class="btn btn-danger">
              <span class="glyphicon glyphicon-remove"></span>
            </button>
          </div>
          <div style="float: right;">
            <button type="button" id="new_quest_cancel" class="btn btn-info"
              style="border-radius: 15px;" data-toggle="modal"
              data-target="#quest_help"><b>?</b></button>
          </div>
        </div>

        <div class="panel-body row" style="padding: 15px 30px 0px 15px">
          <div class="col-md-4">
            <!-- Formulaire de nouvelle question textuelle -->
            <div class="new_quest_form" style="display: none;" quest="text">
              <div class="form-group col-sm-12">
                <label for="new_quest_text_name">Nom du champ</label>
                  <input type="text" id="new_quest_text_name"
                    class="form-control" placeholder="Obligatoire"/>
              </div>
              <div class="form-group col-sm-12">
                <label for="new_quest_text_text">Indication (optionnel)</label>
                  <input type="text"  id="new_quest_text_text"
                    class="form-control" placeholder="S'affichera en grisé"/>
              </div>
            </div>

            <!-- Formulaire de nouvelle question à choix multiples -->
            <div class="new_quest_form" style="display: none;" quest="select">
              <div class="form-group col-xs-12">
                <label for="new_quest_select_name">Nom du champ</label>
                  <input type="text" id="new_quest_select_name"
                    class="form-control" placeholder="Obligatoire">
              </div>
              <div class="form-group col-xs-12">
                <label for="new_quest_select_text">Choix possibles</label>
                  <textarea type="text"  id="new_quest_select_text" rows="3"
                    class="form-control" style="resize: none;"
                    placeholder="Séparés par des virgules"></textarea>
              </div>
            </div>
          </div>

          <!-- Liste des questions posées -->
          <div class="col-md-8 panel panel-default" style="height: 173px;
            overflow: auto;">
            <div class="panel-body" id="quest_list">
            </div>
          </div>
        </div>

      </div>
    </form>


  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="quest_help">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="close" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
          <h4 class="modal-title">Aide sur les questions</h4>
        </div>
        <div class="modal-body">
          <p>Vous pouvez ajouter des questions à votre message auxquelles les
          destinataires seront en mesure de répondre. Vous pourrez ensuite voir
          les résultats de façon globale en cliquant sur ce message dans l'onglet
          "Messages envoyés".</p>
          <p>Deux types de questions existent:<br/>
          - Les questions ouvertes: l'utilisateur peut écrire ce qu'il veut et
          vous verrez chaque réponse individuellement.</br>
          - Les questions à choix multiple: l'utilisateur est limité niveau choix
          et vous aurrez accès aux résultats sous forme de statistiques.</p>
          <p>Dans tous les cas, une question a obligatoirement un nom que vous
          seul serez en mesure de voir (le "Nom du champ" n'est PAS visible par
          les destinataires, pensez donc à bien décrire ce que vous attendez dans
          le message envoyé).</p>
          <p>Une fois une question créée, elle apparait dans la liste de droite.
          Vous pouvez l'ajouter au message en positionnant votre curseur dans le
          message puis en cliquant sur le + vert au dessus de la question voulue.
          Une même question peut être ajoutée plusieurs fois dans le message ;
          cela aura pour effet de la cloner.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
