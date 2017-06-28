<div class="row">
    <div class="col-md-12">
        <h4>Test send data from <code>curl</code></h4><hr>
        <p>
            Open your terminal. First you need to get your token.
        </p>
        <pre>{{ $login_cmd }} {{ url('/api/authenticate') }}</pre>
        <p>
            The output will be something like:
        </p>
        <pre>{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhcGlfa2V5IjoiOWY5NzRiZDMtODM3Ny00MzZmLWE2ZjItNjJiNmYwM2E2NWU0IiwibW9uaXRvcl9rZXkiOiI0MDRmYWZiOS02YzhiLTRkZTItOWEzNS04MWU4ZjJlMWMxZjciLCJzdWIiOjQsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTQ3MzQ1OTA3OSwiZXhwIjoxNDczNDYyNjc5LCJuYmYiOjE0NzM0NTkwNzksImp0aSI6IjkxMzkyZWM4ZjQ4NTM0YzlmZmI0YjNkMTk1Nzc5NmJlIn0.KkwLu-gWT9_cG9D0NgvID4c60MtlPSY-PtNAam5yfqI"}</pre>
        <p>
            With your token you can send some data to the server.
            You need to pass the token in the <code>Header</code> and a
            <code>data</code> parameter.
        </p>
        <pre>{{ $send_cmd }} {{ url('/api/send') }}</pre>
        <p>
            Remember to replace &lt;TOKEN&gt; with the token that you got from
            <code>/api/authenticate</code>.
        </p>
        <p>
            <a href="#view" data-toggle="tab" class="btn btn-primary">
                View Data
            </a>
            <a href="https://sanusb-grupo.github.io/wireless-monitor/pt-br/api-endpoints/index.html"
                class="btn btn-default"
                target="_blank">
                Documentation API
            </a>
        </p>
    </div>
</div>
