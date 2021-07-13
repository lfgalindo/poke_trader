
@extends('template')    

@section('button-header')
    <a href={{route('create')}} style="text-decoration: none;">
        <button class="btn btn-success">Nova troca</button>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Data</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>

                @if(count($trades) == 0)
                    <tr>
                        <td colspan="4" style="text-align: center">Nenhuma troca foi salva!</td>
                    </tr>
                @else
                    @foreach($trades as $trade)
                        <tr>
                            <td>{{$trade->id}}</td>
                            <td>{{$trade->created_at->format('d/m/Y \à\s H:i:s')}}</td>
                            <td>{{$trade->fair}} ({{$trade->diff}} XP de diferença)</td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#pokemons-{{$trade->id}}">
                                    Ver pokémons
                                </button>

                                <div class="modal fade" id="pokemons-{{$trade->id}}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Pokémons</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body row">
                                                <div class="col-6">
                                                <table class="table table-sm">
                                                    <tr>
                                                        <th colspan="2" style="text-align: center">Jogador 1</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Pokemon</th>
                                                        <th>XP</th>
                                                    </tr>

                                                    @foreach ($trade->pokes->where('player_id', '1') as $pokemon)
                                                        <tr>
                                                            <td>{{$pokemon->name}}</td>
                                                            <td>{{$pokemon->xp}} XP</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                                </div>
                                                <div class="col-6">
                                                <table class="table table-sm">
                                                    <tr>
                                                        <th colspan="2" style="text-align: center">Jogador 2</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Pokemon</th>
                                                        <th>XP</th>
                                                    </tr>

                                                    @foreach ($trade->pokes->where('player_id', '2') as $pokemon)
                                                        <tr>
                                                            <td>{{$pokemon->name}}</td>
                                                            <td>{{$pokemon->xp}} XP</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
@endsection