<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Poke Trader</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                @for ($player = 1; $player <= $qttPlayers; $player++)
                    <div class="col-6">
                        <table class="table">
                            <thead>
                                <tr><th colspan="2" style="text-align: center">Jogador {{$player}}</th></tr>
                                <tr>
                                    <th>Pokemon</th>
                                    <th>XP</th>
                                </tr>
                            </thead>

                            <tbody class="pokemons" id="player-{{$player}}"></tbody>

                            <tfoot>
                                <tr>
                                    <th><span id="qtt-pokemons-player-{{$player}}">0</span> Pokémon(s)</th>
                                    <th><span id="total-xp-player-{{$player}}">0</span> XP</th>
                                </tr>

                                <tr>
                                    <td colspan="2" style="text-align: center">
                                        <button class="btn btn-primary" onclick="searchPokeToAdd({{$player}})">Adicionar pokémon</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endfor
            </div>
        </div>
    </body>

    <script>
        let qttPlayers = @json($qttPlayers);
        let players = [];

        function searchPokeToAdd (player)
        {

            console.log(players);

            if (typeof players[player] === 'undefined') {
                console.log(players);

                players[player] = {
                    "xp": 0,
                    "pokemons": []
                };

                console.log(players);
            } else {
                if (players[player].pokemons.length == 6) {
                    Swal.fire('Oops...', 'Você pode selecionar no máximo 6 pokemons por jogador!', 'error');
                    return;
                }
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
                            players[player].pokemons = [...players[player].pokemons, selectedPoke.id];

                            $(`#qtt-pokemons-player-${player}`).text(players[player].pokemons.length);
                            $(`#total-xp-player-${player}`).text(players[player].xp);

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
    </script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .select2-container {
            width: 100%!important;
        }
    </style>
</html>
