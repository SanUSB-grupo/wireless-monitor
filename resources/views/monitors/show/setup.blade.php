<div class="row">
    <div class="col-md-4">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Step 1</h3>
            </div>
            <div class="box-body">
                <img src="{{asset('img/chip.png')}}" class="img-responsive" />
                <h4 class="text-center">
                    Setup you IOT device
                </h4>
                <p>
                    You will need a device that has access to the internet.
                    Some examples:
                </p>
                <ul>
                    <li>ESP 8266</li>
                    <li>Arduino with Ethernet Shield</li>
                    <li>Arduino with Wi-Fi Shield</li>
                </ul>
                <p>
                    Then you need to collect data with some kind of sensor.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Step 2</h3>
            </div>
            <div class="box-body">
                <img src="{{asset('img/cloud.png')}}" class="img-responsive" />
                <h4 class="text-center">
                    Authenticate you Device
                </h4>
                <pre>{{ $auth_json }}</pre>
                <p>
                    The <code>api_key</code> identifies you, and
                    the <code>monitor_key</code> identifies your
                    device. This values must be secret.
                </p>
                <p>
                    To authenticate you have to make a POST request
                    to the endpoint <code>/api/authenticate</code>.
                    After success you will receive a <code>token</code>.
                </p>
            </div>
            <div class="box-footer">
                <h4>Useful links</h4>
                <div>
                    <a class="list-group-item" href="https://github.com/bblanchon/ArduinoJson">
                        JSON library for embedded systems
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Step 3</h3>
            </div>
            <div class="box-body">
                <img src="{{asset('img/computer.png')}}" class="img-responsive" />
                <h4 class="text-center">
                    View your data in the web
                </h4>
                <p>
                    Send some data from you IOT device. Make a POST request
                    to the endpoint <code>/api/send</code> using your <code>token</code>
                    in the header, <code>Authorization: Bearer &lt;token&gt;</code>.
                </p>
                <pre>{{ $send_json }}</pre>
                <p>
                    To view the data sent click on the button bellow.
                </p>
                <a href="#view" data-toggle="tab" class="btn btn-primary btn-block">
                    View Data
                </a>
            </div>
        </div>
    </div>
</div>
