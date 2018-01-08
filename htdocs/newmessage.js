var $quest_list;
var $new_msg_content;
var $modifiedQuest = null;
var questLastId = 0;
var selectedQuest = 'none';
var modifiedQuest = null;
var questList = [];
var sameNameErrorStr = 'Erreur : il existe déjà une question portant ce nom.';
var emptyNameErrorStr = 'Erreur : veuillez entrer un nom pour le champ.';


$(document).ready(function(){
  $quest_list = $('#quest_list');
  $new_msg_content = $('#new_msg_content');

  // Modification du comportement du div du destinataire
  $('#new_msg_recipient').on('keydown', function(e) {
    // Recherche le login entré en cas d'appui sur Entrée ou Espace
    // pour le remplacer par Prénom Nom
    if(e.which == 13 || e.which == 32) {
      // Met des espaces à la place des <div> lors d'un appui sur Entrée
      replaceRecipient();
      return false;
    }
    return true;
  });

  // Modification du comportement du div du contenu de message
  $('#new_msg_content').on('keydown', function(e) {
    // Met des <br> à la place des <div> lors d'un appui sur Entrée
    if(e.which == 13) {
      document.execCommand('insertHTML', false, '<br><br>');
      return false;
    }
    return true;
  });

  /* Affichage du formulaire de création de question */
  $('.new_quest_show').on('click', function() {
    var type = $(this).attr('quest');
    var form = $('.new_quest_form[quest="' + type + '"]');

    if(form.css('display') == 'none') {
      selectedQuest = type;
      $('.new_quest_form').css('display', 'none');
      form.css('display', 'block');
      $('#new_quest_form').css('display', 'inline-block');
      if(modifiedQuest != null && modifiedQuest.type == type) {
        $('#new_quest_add').css('display', 'none');
        $('#new_quest_modify').css('display', 'inline');
      }
      else {
        $('#new_quest_add').css('display', 'inline');
        $('#new_quest_modify').css('display', 'none');
      }
    }
    else {
      selectedQuest = 'none';
      form.css('display', 'none');
      $('#new_quest_form').css('display', 'none');
    }
  });


  /* Ajout d'une nouvelle question */
  $('#new_quest_add').on('click', function() {
    var added = null;
    var $buttonsLocation = null;

    if(selectedQuest == 'text') { // Question textuelle
      if(!/\S/.test($('#new_quest_text_name').val())) {
        alert(emptyNameErrorStr);
        return;
      }
      if(getQuestByName($('#new_quest_text_name').val()) != null) {
        alert(sameNameErrorStr);
        return;
      }
      added = {
          id: questLastId,
          type: 'text',
          name: $('#new_quest_text_name').val(),
          text: $('#new_quest_text_text').val(),
          count: 0 };
      $quest_list.append('<div id="new_quest:' + added.id + '" quest="text"' + 
          'class="col-lg-6" style="margin-bottom: 10px;"><a>'
          + added.name + '</a>' + '<input type="text" placeholder="'
          + added.text
          + '" class="form-control" readonly/></div>');
    }

    else if(selectedQuest == 'select') { // Question à choix multiple
      if(!/\S/.test($('#new_quest_select_name').val())) {
        alert(emptyNameErrorStr);
        return;
      }
      if(getQuestByName($('#new_quest_select_name').val()) != null) {
        alert(sameNameErrorStr);
        return;
      }
      added = {
          id: questLastId,
          type: 'select',
          name: $('#new_quest_select_name').val(),
          options: [],
          count: 0 };
      var str = '<div id="new_quest:' + added.id + '" quest="selected"'
        + 'class="col-lg-6" style="margin-bottom: 10px;"><a>'
        + added.name + '</a><select class="form-control">';
      var lines = $('#new_quest_select_text').val()
          .replace(/[\n\r]+/g, ' ').replace(/^\s+|\s+$/g, '')
          .split(/\s*,\s*/);
      for(var i = 0; i < lines.length; i++) {
        if(/\S/.test(lines[i])) {
          added.options.push(lines[i]);
          str += '<option>' + lines[i] + '</option>';
        }
      }
      str += '</select></div>';
      $quest_list.append(str);
    }

    $buttonsLocation = $('#new_quest\\:' + added.id);
    questList.push(added);
    newQuestBasicInputs($buttonsLocation);
    newQuestClearForm();
    questLastId++;
  });


  /* Modification d'une question existante */
  $('#new_quest_modify').on('click', function() {
    if(modifiedQuest != null) {
      if(modifiedQuest.type == 'text') {
        var duplicateName = getQuestByName($('#new_quest_text_name').val());
        if(duplicateName != null && duplicateName != modifiedQuest.id) {
          alert(sameNameErrorStr);
          return;
        }

        modifiedQuest.name = $('#new_quest_text_name').val();
        modifiedQuest.text = $('#new_quest_text_text').val();
        $modifiedQuest.find('a').html(modifiedQuest.name);
        $modifiedQuest.find('input').attr('placeholder', modifiedQuest.text);
      }

      else if(modifiedQuest.type == 'select') {
        var duplicateName = getQuestByName($('#new_quest_select_name').val());
        if(duplicateName != null && duplicateName != modifiedQuest.id) {
          alert(sameNameErrorStr);
          return;
        }

        modifiedQuest.name = $('#new_quest_select_name').val();
        modifiedQuest.options = [];
        $modifiedQuest.find('a').html(modifiedQuest.name);
        $modifiedQuest.find('select').empty();
        var lines = $('#new_quest_select_text').val()
            .replace(/[\n\r]+/g, ' ').replace(/^\s+|\s+$/g, '')
            .split(/\s*,\s*/);
        console.log(lines);
        var str;
        for(var i = 0; i < lines.length; i++) {
          if(/\S/.test(lines[i])) {
            modifiedQuest.options.push(lines[i]);
            str += '<option>' + lines[i] + '</option>';
          }
        }
        $modifiedQuest.find('select').append(str);
      }

      // Modification des questions dans le contenu du message
      $('.content_quest\\:' + modifiedQuest.id).val(modifiedQuest.name);

      // Masquage et réinitialisation du formulaire de nouvelle question
      newQuestClearForm();
      modifiedQuest = null;
      $modifiedQuest = null;
      $('#new_quest_modify').css('display', 'none');
      $('#new_quest_add').css('display', 'inline');
    }
  });

  /* Réinitialisation du formulaire de génération de question */
  $('#new_quest_cancel').on('click', function() {
    newQuestClearForm();
    modifiedQuest = null;
    $modifiedQuest = null;
    $('.new_quest_form').css('display', 'none');
    $('#new_quest_form').css('display', 'none');
  });
});


/* Envoi le message si tout est OK */
sendMessage = function() {
  var subject = $('#new_msg_subject').val();
  var $recipients = $('#new_msg_recipient input');
  var questions = '';

  // Vérification des données entrées
  if(!/\S/.test(subject)) {
    alert('Erreur : Veuillez entrer un sujet pour votre message.');
    return;
  }

  // Récupération des destinataires
  var type;
  var id;
  var recipients = '';
  for(i = 0; i < $recipients.length; i++) {
    id = $recipients[i].id;
    if(id.substring(0, 12) == 'quest_person')
      recipients += 'person_' + id.replace(/^\D+/g, '') + '|';
    else if(id.substring(0, 11) == 'quest_alias')
      recipients += 'alias_' + id.replace(/^\D+/g, '') + '|';
  }

  if(recipients == '') {
    alert('Erreur : Veuillez entrer au moins un destinataire valide.');
    return;
  }
  
  var i = 0;

  // Récupération des questions dans le formulaire
  $new_msg_content.find('[class*="content_quest:"]').replaceWith(function(){
    id = getQuestById($(this).attr('class').replace(/^\D+/g, ''));
    if(id == null)
      return '';

    questList[id].count++;
    var name = questList[id].name;
    if(questList[id].count > 1)
      name += ' #'
        + questList[id].count;

    if(questList[id].type == 'text')
      questions += '0_' + name + '{' + questList[id].text + '}|';
    else if(questList[id].type == 'select')
      questions += '1_' + name
        + '{' + questList[id].options.join(',') + '}|';
    else
      return '';

    return '<' + i++ + '>';
  });

  // Envoi du message
  $.post({
      url: 'send_message.php',
      dataType: 'html',
      data: 'subject=' + subject
        + '&recipients=' + recipients
        + '&content=' + $new_msg_content[0].innerText
        + '&questions=' + questions,
      success: function() {
        $(location).attr('href', 'messages.php');
      },
      error: function() {
        alert('Erreur critique: le serveur n\'a pas pu envoyer ce message.');
      }
    });

}


/* Remplace le login d'un destinataire par son Prénom Nom */
replaceRecipient = function() {
  var range = window.getSelection().getRangeAt(0);
  if(range.collapsed) {
    var text = range.startContainer.textContent.substring(0,
        range.startOffset+1);
    text = text.split(' ').pop().replace(/^\s+|\s+$/g, '');
    $.get({
      url: 'search_user.php?name=' + text,
      dataType: 'html',
      success: function(result, status) {
        array = JSON.parse(result);
        if(array != null) {
          if(array.type == 'person')
            var str = '<input type="button" id="quest_person:' + array.id
              + '" value = "' + array.first_name + ' ' + array.name + '"/>';
          else
            var str = '<input type="button" id="quest_alias:' + array.id
              + '" value = "@' + array.name + '"/>';
          document.execCommand('insertHtml', false, str + '\u00A0');
        } else {
          document.execCommand('insertHtml', false, '\u00A0');
        }
      }
    });
  }
}


/* Renvoi l'indice dans questList correspondant à l'id donné */
getQuestById = function(id) {
  for(var i = 0; i < questList.length; i++) {
    if(questList[i].id == id)
      return i;
  }
  return null;
}


/* Renvoi l'indice dans questList correspondant au nom donné */
getQuestByName = function(name) {
  for(var i = 0; i < questList.length; i++) {
    if(questList[i].name == name)
      return i;
  }
  return null;
}


/* Efface le formulaire en cours */
newQuestClearForm = function() {
    $('#new_quest_text_name').val('');
    $('#new_quest_text_text').val('');
    $('#new_quest_select_name').val('');
    $('#new_quest_select_text').val('');
}


/* Remplit le formulaire avec les valeurs d'une question déjà posée */
newQuestFillForm = function(id) {
  var current = questList[getQuestById(id)];
  if(current == null)
    return;

  newQuestClearForm();
  if(current.type == 'text') {
    $('#new_quest_text_name').val(current.name);
    $('#new_quest_text_text').val(current.text);
  }
  else if(current.type == 'select') {
    $('#new_quest_select_name').val(current.name);
    var str = '';
    for(var i = 0; i < current.options.length; i++)
      str += current.options[i] + ",\n";
    $('#new_quest_select_text').val(str);
  }
}


/* Boutons communs à tous les types de questions (modifier et supprimer) */
newQuestBasicInputs = function($root) {
  // Code HTML de ces boutons
  $('<div style="float: right;">\
      <button type="button" class="btn btn-xs btn-success\
      new_quest_use" id="new_quest_edit: ' + questLastId + '">\
      <span class="glyphicon glyphicon-plus"></span></button>\
      <button type="button" class="btn btn-xs btn-info new_quest_edit"\
      id="new_quest_edit:'+ questLastId + '" quest="' + selectedQuest + '">\
      <span class="glyphicon glyphicon-pencil"></span>\
    </button>\
    <button type="button" class="btn btn-xs btn-danger new_quest_remove"\
      id="new_quest_remove:' + questLastId + '" quest="' + selectedQuest + '">\
      <span class="glyphicon glyphicon-remove"></span>\
    </button></div>').insertAfter($root.find('a'));


  /* Evenement d'ajout de la question au message */
  $root.find('div :eq(-6)').on('click', function() {
    if(window.getSelection)
    {
      var id = $(this).attr('id').replace(/^\D+/g, '');
      var button = questList[getQuestById(id)];
      var input = window.getSelection().anchorNode;
      if(input && (input.id == 'new_msg_content'
            || (input.parentNode
              && input.parentNode.id == 'new_msg_content'))) {
        if(button.type == 'text')
          str = '<input type="button" class="btn content_quest:' + id
            + '" value="' + button.name + '"/>';
        else if(button.type = 'select')
          str = '<input type="button" class="btn content_quest:' + id
            + '" value="' + button.name + '"/>';
        document.execCommand('insertHtml', false, str);
      }
    }
  });


  /* Evenement de modification de la question */
  $root.find('div :eq(-4)').on('click', function() {
    var id = $(this).attr('id').replace(/^\D+/g, '');
    modifiedQuest = questList[getQuestById(id)];
    $modifiedQuest = $(this).parent().parent();

    // Affichage du formulaire de modification de question
    $('.new_quest_form').css('display', 'none');
    $('#new_quest_add').css('display', 'none');
    $('#new_quest_modify').css('display', 'inline');
    $('#new_quest_cancel').css('display', 'inline');
    $('.new_quest_form[quest='
        + modifiedQuest.type + ']').css('display', 'inline-block');

    // Pré-remplissage des champs avec les infos de cette question
    newQuestFillForm(id);
  });


  /* Evenement de suppression de la question */
  $root.find('div :eq(-2)').on('click', function() {
    var id = $(this).attr('id').replace(/^\D+/g, '');

    // Suppression dans la liste visible de questions
    $('#new_quest\\:' + id).remove();
    
    // Suppression dans le contenu du message
    $('.content_quest\\:' + id).remove();

    // Suppression dans la liste interne de questions
    questList.splice(getQuestById(id), 1);
  });
}

