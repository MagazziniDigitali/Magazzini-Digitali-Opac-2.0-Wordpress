
//Load Web App JavaScript Dependencies/Plugins
define([
    "jquery",
    "modernizr",
    "underscore",
    "backbone",
    "bootstrap",
    "plugins"
], function($)
{
    $(function()
    {

        //do stuff
        console.log('required plugins loaded...');

        //jQuery Captcha Validation

        WEBAPP = {

            settings: {},
            cache: {},

            init: function() {

                //DOM cache
                this.cache.$form = $('#tecaLoginForm');
                this.cache.$refreshCaptcha = $('#refresh-captcha');
                this.cache.$captchaImg = $('img#captcha');
                this.cache.$captchaInput = $(':input[name="captcha"]');

                this.eventHandlers();
                this.setupValidation();

            },

            eventHandlers: function() {

                //generate new captcha
                WEBAPP.cache.$refreshCaptcha.on('click', function(e)
                {
                    WEBAPP.cache.$captchaImg.attr("src","/wp-content/plugins/md-login/captcha/php/newCaptcha.php?rnd=" + Math.random());
                });
            },

            setupValidation: function()
            {

                WEBAPP.cache.$form.validate({
                   onkeyup: false,
                   rules: {
                        "typeAuth": {
                            "required": true
                        },
                        "istituto": {
                            "required": function(){
                            	sss
                            }
                        },
                        "login": {
                            "required": true
                        },
                        "password": {
                            "required": true
                        },
                        "captcha": {
                            "required": true,
                            "remote" :
                            {
                              url: '/wp-content/plugins/md-login/captcha/php/checkCaptcha.php',
                              type: "post",
                              data:
                              {
                                  code: function()
                                  {
                                      return WEBAPP.cache.$captchaInput.val();
                                  }
                              }
                            }
                        }
                    },
                    messages: {
                        "typeAuth": "Indicare il tipo di autenticazione desiderato.",
                        "login": "Indicare il login.",
                        "password": "Indicare la password.",
                        "captcha": {
                            "required": "Si prega di inserire il codice di verifica.",
                            "remote": "Verication code incorrect, please try again."
                        }
                    },
                    submitHandler: function(form)
                    {
                        /* -------- AJAX SUBMIT ----------------------------------------------------- */

                        var submitRequest = $.ajax({
                             type: "POST",
                             url: MDUrl,
//                             url: "/php/dummyScript.php",
                             data: {
                                "data": WEBAPP.cache.$form.serialize()
                            }
                        });

                        submitRequest.done(function(msg)
                        {
                            //success
                            console.log('success');
//                            $('body').html('<h1>captcha correct, submit form success!</h1>');
                        });

                        submitRequest.fail(function(jqXHR, textStatus)
                        {
                            //fail
                            console.log( "fail - an error occurred: (" + textStatus + ")." );
                        });

                    }

                });

            }

        }

        WEBAPP.init();

    });
});