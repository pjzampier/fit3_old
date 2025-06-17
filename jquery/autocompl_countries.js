            $(document).ready(function() {

                // Captura o retorno do retornaCliente.php
                $.getJSON('view/profile/return_country.php', function(data1) {
                    var country = [];

                    // Armazena na array capturando somente o nome do cliente
                    $(data1).each(function(key, value) {
                        country.push(value.country_name_pt);
                    });

                    // Chamo o Auto complete do JQuery ui setando o id do input, array com os dados e o mínimo de caracteres para disparar o AutoComplete
                    $('#txtCountry').autocomplete({source: country, minLength: 2});
                });
            });
