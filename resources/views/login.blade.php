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
            <div class="column is-4 is-offset-4">
                <h3 class="title is-3">Enter super secret password</h3>

                <form method="post" action="{{ route('admin.doLogin') }}" class="mb-3">
                    @csrf
                    <div class="field">
                        <label class="label">Password (<i>Hint: it's definitely not 1234</i>)</label>
                        <div class="control">
                            <input class="input" name="password" type="password" placeholder="1234">
                        </div>
                    </div>
                    <div class="control field">
                        <button class="button is-link is-fullwidth">Sign me the fuck in dude</button>
                    </div>
                    @error('password')
                    <span>{{ $message }}</span>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</section>

</body>
</html>
</body>
</html>
