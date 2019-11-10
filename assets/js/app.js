/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');
require('bootstrap');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
global.$ = global.jQuery = $;

$(document).ready(function() {
    $("#toggleSignUpModal").click(function () {
        console.log($('form'))
        $.ajax('/inscription', {
            success: function(data) {
                $('#signUpModal').html(data);
                $('#signUpModal').modal('show');
            }
        });
    });
      
    $("#toggleSignInModal").click(function () {
        $.ajax('/login', {
            success: function(data) {
                $('#signInModal').html(data);
                $('#signInModal').modal('show');
            }
        });
        $('#signInModal').modal('show');
    });
    $(document).on('submit', '#signUpForm', function(e){
        console.log("form submitted")
        e.preventDefault(); 
        $form = $(e.target);
        $(this).ajaxSubmit({
            type: 'post',
            success: function(data) {
                $('#signUpModal').html(data);
                $('#signUpModal').modal('show');
               console.log(data);
            },
            error: function(jqXHR, status, error) {
                console.log(error);
            }
        });
    })
    $(document).on('submit', '#signInForm', function(e){
        console.log("form submitted")
        e.preventDefault(); 
        $(this).ajaxSubmit({
            type: 'post',
            success: function(data) {
                $('#signInModal').html(data);
                $('#signInModal').modal('show');
               console.log(data);
            },
            error: function(jqXHR, status, error) {
                console.log(error);
            }
        });
    })

   
});
    
