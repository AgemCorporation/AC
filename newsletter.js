$(function() {
    // récupérer le formulaire et ajouter un gestionnaire d'événements submit
    $("#newsletter-form").submit(function(event) {
      // empêcher le comportement par défaut du formulaire (rechargement de la page)
      event.preventDefault();
  
      // récupérer les données du formulaire
      var formData = $(this).serialize();
  
      // envoyer les données du formulaire en utilisant Ajax
      $.ajax({
        type: "POST",
        url: "inscription-newsletter.php",
        data: formData,
        dataType: "json",
        success: function(response) {
          // afficher le message de réponse
          var message = $('<div>').addClass('alert alert-success').text(response.message);
          $('#newsletter-form').prepend(message);
          $('#newsletter-form input[type="email"]').val('');
          setTimeout(function() {
            message.fadeOut('slow');
          }, 5000);
        },
        error: function(xhr, status, error) {
          // afficher le message d'erreur
          var message = $('<div>').addClass('alert alert-danger').text("Une erreur s'est produite lors de l'envoi du formulaire : " + error);
          $('#newsletter-form').prepend(message);
          setTimeout(function() {
            message.fadeOut('slow');
          }, 5000);
        }
      });
    });
  });