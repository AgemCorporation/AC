$(document).ready(function() {
    $('#form-index').submit(function(event) {
        // Empêcher la soumission normale du formulaire
        event.preventDefault();

        // Récupérer les données du formulaire
        var formData = $(this).serialize();

        // Envoyer les données via AJAX
        $.ajax({
            type: 'POST',
            url: 'formindex.php',
            data: formData,
            dataType: 'json',
            success: function(response){
                if(response.status == 'success'){
                    // Effacer les champs du formulaire
                    $('#form-index')[0].reset();
                    
                    // Afficher le message de succès et le faire disparaître après quelques secondes
                    $('#success-message').html(response.message).slideDown().delay(5000).slideUp();
                } else {
                    // Afficher le message d'erreur et le faire disparaître après quelques secondes
                    $('#error-message').html(response.message).slideDown().delay(5000).slideUp();
                }
            },
            error: function() {
                // Afficher un message d'erreur générique et le faire disparaître après quelques secondes
                $('#error-message').html('Une erreur est survenue lors de l\'envoi du message.').slideDown().delay(5000).slideUp();
            }
        });
    });
});
