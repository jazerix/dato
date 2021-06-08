<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
</head>
<body>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super cool admin stuffs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
</head>
<body>
<section class="section">
    <div class="container">
        <div class="columns">
            @isset($player)
                <div class="column is-6">
                    <h3 class="title is-3">{{ $player->name }}</h3>
                    @if($player->currentlyDrinking != null)
                        @if(session()->has('success'))
                            <article class="message is-success">
                                <div class="message-body">
                                    {{ session('success')  }}
                                </div>
                            </article>
                        @endif
                        <article class="message is-info">
                            <div class="message-body">
                                This player is currently drinking
                                <b>({{ $player->currentlyDrinking->cost == 3 ? '500 ml.' : '330 ml.'}})</b>. End drink?
                            </div>
                        </article>
                        <div class="buttons">
                            @foreach($endIntervals as $key => $value)
                                <a href="{{ route('admin.completeBeverage', ['player' => $player->id, 'completed_at' => $key]) }}"
                                   class="button">{{$value}}</a>
                            @endforeach

                            <button onclick="undo()" class="button is-danger">Undo</button>
                        </div>
                    @else
                        @if(session()->has('success'))
                            <article class="message is-success">
                                <div class="message-body">
                                    {{ session('success')  }}
                                </div>
                            </article>
                        @endif
                        <article class="message is-info">
                            <div class="message-body">
                                This player is currently not drinking. Start a drink?
                            </div>
                        </article>
                        <div class="buttons">
                            <a href="{{ route('admin.addBeverage', ['player' => $player->id, 'beverageCost' => 2]) }}"
                               class="button is-primary">Commit to 330 ml.</a>
                            <a href="{{ route('admin.addBeverage', ['player' => $player->id, 'beverageCost' => 3]) }}"
                               class="button is-primary">Commit to 500 ml.</a>
                        </div>
                    @endif
                </div>
            @endisset
            <div class="column is-6">
                <h3 class="title is-3">Players</h3>
                <ul>
                    @foreach($players as $currentPlayer)
                        <li><a href="{{ route('admin.playerInfo', [$currentPlayer->id]) }}"
                               class="button is-fullwidth mb-3 @if($currentPlayer->currentlyDrinking != null) is-primary @endif">{{ $currentPlayer->name }}</a>
                        </li>
                    @endforeach
                </ul>

                <form method="post" action="{{ route('admin.addPlayer') }}" class="mb-3">
                    @csrf
                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="input" name="name" type="text" placeholder="Tommy the Commie">
                        </div>
                    </div>
                    <div class="control field">
                        <button class="button is-link">Add Player</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@isset($player)
    @if($player->currentlyDrinking != null)
        <script type="text/javascript">
            function undo() {
                let doUndo = confirm('Are you sure?');
                if (!doUndo)
                    return;

                window.location = "{{ route('admin.undoBeverage', [$player->id]) }}";
            }
        </script>
    @endif
@endisset
</body>
</html>
</body>
</html>
