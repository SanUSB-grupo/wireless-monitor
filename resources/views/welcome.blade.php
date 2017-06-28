@extends('layouts.skeleton')

@push('scripts')
    <script src="{{ elixir('js/welcome.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ elixir('css/welcome.css') }}" rel="stylesheet">
@endpush

@section('container')

    <div class="jumbotron jumbotron-gradient">
        <div class="container">
            <h2 class="">
                Welcome to Wireless Monitor
            </h2>
            <h3>Connect and monitor your IoT Devices in the cloud.</h3>
        </div>
    </div>

    <div class="container container__content">
        <div class="row">
            <div class="col-md-6">
                <h2>What is a Monitor?</h2>
                <p>
                    Monitor is an internal component of the system created by the
                    developer according to its need, it's the instrument that features
                    the collected data and presents them on the web interface.
                </p>
                <h2>How to create a Monitor?</h2>
                <p>
                    You can create a Monitor using existing ones or you can
                    develop one yourself.
                </p>
                <div class="btn-group">
                    <a href="https://sanusb-grupo.github.io/wireless-monitor/pt-br/plugin-development.html"
                        class="btn btn-info"
                        target="_blank">
                        Plugin Development
                    </a>
                    <a href="{{ url('/monitor') }}" class="btn btn-primary">Existing ones</a>
                </div>
            </div>
            <div class="col-md-6">
                <a href="https://youtu.be/iTczyDZeSWk" data-lity title="Watch Video">
                    <img alt="monitor"
                        src="{{ asset('img/welcome/create-temperature-monitor.png') }}"
                        class="img-rounded img-responsive" />
                </a>
            </div>
        </div>

        <div class="row margin-top">
            <div class="col-md-6">
                <a href="https://youtu.be/Fo9e7soNsLE" data-lity title="Watch Video">
                    <img alt="monitor"
                        src="{{ asset('img/welcome/test-send-data.png') }}"
                        class="img-rounded img-responsive" />
                </a>
            </div>
            <div class="col-md-6">
                <h2>How to send data to your Monitor?</h2>
                <p>
                    You can use <a href="https://curl.haxx.se/" target="_blank">cURL</a> to send
                    data and test your monitor.
                </p>
                <p>
                    This can be useful for you to learn the step by step process
                    or for debugging purposes.
                </p>
                <h2>What do I need to send data?</h2>
                <p>
                    First step is to gather your <code>api_key</code> and your
                    <code>monitor_key</code>. Those are used to authorize your
                    IoT device.
                </p>
                <p>
                    After consume the endpoint <code>/api/authenticate</code>
                    you will receive a <code>token</code>. Use this <code>token</code>
                    every time you access the endpoint <code>/api/send</code>.
                </p>
                <p>
                    All communication is done using
                    <a href="http://json.org/" target="_blank">JSON</a>,
                    a lightweight data-interchange format. JSON is a text format that
                    is completely language independent.
                </p>
                <div class="btn-group">
                    <a href="https://sanusb-grupo.github.io/wireless-monitor/pt-br/api-endpoints/post_api-authenticate.html"
                        class="btn btn-primary"
                        target="_blank">
                        Authenticate API
                    </a>
                    <a href="https://sanusb-grupo.github.io/wireless-monitor/pt-br/api-endpoints/post_api-send.html"
                        class="btn btn-primary"
                        target="_blank">
                        Send API
                    </a>
                    <a href="https://sanusb-grupo.github.io/wireless-monitor/pt-br/api-endpoints/get_api-refresh-token.html"
                        class="btn btn-primary"
                        target="_blank">
                        Refresh Token API
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="project">
        <div class="container">
            <div class="row margin-top margin-bottom text-center">
                <div class="col-md-4">
                    <i class="fa fa-4x fa-github"></i>
                    <h2>Source Code</h2>
                    <p>
                        This is a free and open source project, using the
                        GPLv3 license.
                    </p>
                    <a href="https://github.com/sanusb-grupo/wireless-monitor"
                        class="btn btn-primary btn-lg"
                        target="_blank">
                        Open on Github
                    </a>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-4x fa-book"></i>
                    <h2>Documentation</h2>
                    <p>
                        Learn about the features, local installation process
                        of the server, the API and plugin development.
                    </p>
                    <a href="https://sanusb-grupo.github.io/wireless-monitor/"
                        class="btn btn-primary btn-lg"
                        target="_blank">
                        View
                    </a>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-4x fa-file-o"></i>
                    <h2>Paper</h2>
                    <p>
                        Read the paper that explains how the project was conceived
                        and developed.
                    </p>
                    <a href="https://github.com/atilacamurca/wireless-monitor-paper/blob/master/main.pdf"
                        class="btn btn-primary btn-lg"
                        target="_blank">
                        Read
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
