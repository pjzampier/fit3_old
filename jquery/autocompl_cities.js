
            $(document).ready(function() {

                // Captura o retorno do retornaCliente.php
                $.getJSON('view/profile/return_city.php', function(data1) {
                    var cities = [];

                    // Armazena na array capturando somente o nome do cliente
                    $(data1).each(function(key, value) {
                        cities.push(value.city_name);
                    });

                    // Chamo o Auto complete do JQuery ui setando o id do input, array com os dados e o mínimo de caracteres para disparar o AutoComplete
                    $('#txtCities').autocomplete({source: cities, minLength: 2});
                });
            });
