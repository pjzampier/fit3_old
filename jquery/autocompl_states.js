
            $(document).ready(function() {
                // Captura o retorno do retornaCliente.php
                $.getJSON('view/profile/return_state.php', function(data) {
                    var states = [];

                    // Armazena na array capturando somente o nome do cliente
                    $(data).each(function(key, value) {
                        states.push(value.state_name);
                    });

                    // Chamo o Auto complete do JQuery ui setando o id do input, array com os dados e o mínimo de caracteres para disparar o AutoComplete
                    $('#txtState').autocomplete({source: states, minLength: 2});
                });
            });

