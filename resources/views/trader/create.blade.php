<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Poke Trader</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr><th colspan="2" style="text-align: center">Jogador 1</th></tr>
                            <tr>
                                <th>Pokemon</th>
                                <th>XP</th>
                            </tr>
                        </thead>

                        <tbody class="pokemons" id="player-1"></tbody>

                        <tfoot>
                            <tr>
                                <th><span id="qtt-pokemons-player-1">0</span> Pokémon(s)</th>
                                <th><span id="total-xp-player-1">0</span> XP</th>
                            </tr>

                            <tr>
                                <td colspan="2" style="text-align: center">
                                    <button class="btn btn-primary" onclick="searchPokeToAdd(1)">Adicionar pokémon</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr><th colspan="2" style="text-align: center">Jogador 2</th></tr>
                            <tr>
                                <th>Pokemon</th>
                                <th>XP</th>
                            </tr>
                        </thead>

                        <tbody class="pokemons" id="player-2"></tbody>

                        <tfoot>
                            <tr>
                                <th><span id="qtt-pokemons-player-2">0</span> Pokémon(s)</th>
                                <th><span id="total-xp-player-2">0</span> XP</th>
                            </tr>

                            <tr>
                                <td colspan="2" style="text-align: center">
                                    <button class="btn btn-primary" onclick="searchPokeToAdd(2)">Adicionar pokémon</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <tr>
                            <th style="text-align: center">Situação da troca:</th>
                        </tr>

                        <tr>
                            <td style="text-align: center">Essa troca é <span id="trade-status">JUSTA</span>, pois a diferença é de <span id="diff-xp">0</span> XP</td>
                        </tr>

                        <tr>
                            <td style="text-align: center">
                                <button class="btn btn-secondary" onclick="clearTrade()">Recomeçar</button>
                                <button class="btn btn-primary" onclick="saveTrade()">Salvar troca e recomeçar</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </body>

    <script>
        let fairTradeDiff = @json($fairTradeDiff);
        let players = {
            1: {
                "xp": 0,
                "pokemons": []
            },
            2: {
                "xp": 0,
                "pokemons": []
            }
        };

        function saveTrade ()
        {
            alert('123');

            clearTrade();
        }

        
        function clearTrade ()
        {
            players = {
                1: {
                    "xp": 0,
                    "pokemons": []
                },
                2: {
                    "xp": 0,
                    "pokemons": []
                }
            };

            $('#qtt-pokemons-player-1').text('0');
            $('#total-xp-player-1').text('0');
            
            $('#qtt-pokemons-player-2').text('0');
            $('#total-xp-player-2').text('0');
            
            $('tbody.pokemons').empty();

            checkTrade();
        }

        function searchPokeToAdd (player)
        {
            if (players[player].pokemons.length == 6) {
                Swal.fire('Oops...', 'Você pode selecionar no máximo 6 pokemons por jogador!', 'error');
                return;
            }

            let title = `Adicionar pokémon - Jogador ${player}`;

            Swal.fire({
                title,
                text: 'Digite o nome de um pokémon para pesquisar:',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Pesquisar',
                showLoaderOnConfirm: true,
                reverseButtons: true,
                backdrop: true,
                preConfirm: (pokemon) => {
                    return fetch(`https://pokeapi.co/api/v2/pokemon/${pokemon}/`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage('Pokémon não encontrado!')
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    let selectedPoke = result.value;

                    Swal.fire({
                        title,
                        text: `${result.value.name} (${result.value.base_experience} xp)`,
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Adicionar',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            players[player].xp += selectedPoke.base_experience;
                            players[player].pokemons = [
                                ...players[player].pokemons, 
                                {
                                    id: selectedPoke.id, 
                                    name: selectedPoke.name,
                                    xp: selectedPoke.base_experience,
                                }
                            ];

                            $(`#qtt-pokemons-player-${player}`).text(players[player].pokemons.length);
                            $(`#total-xp-player-${player}`).text(players[player].xp);

                            checkTrade();

                            $(`.pokemons#player-${player}`).append(`
                                <tr>
                                    <td>${selectedPoke.name}</td>
                                    <td>${selectedPoke.base_experience}</td>
                                </tr>
                            `);
                        }
                    });
                }
            });
        }

        function checkTrade () 
        {
            let diff = Math.abs(players[1].xp - players[2].xp);

            $('#trade-status').text(diff <= fairTradeDiff ? 'JUSTA' : 'INJUSTA');
            $('#diff-xp').text(diff);
        }
    </script>
</html>
