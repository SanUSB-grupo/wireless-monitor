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
                    Then you need to collect data.
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
                    Send a JSON object with the some data
                </h4>
                <pre>{{ $code }}</pre>
                <div>
                    Change <code>your_value</code> to the collected
                    value, either a temperature or a distance.
                </div>
                <div>
                    The <code>api_key</code> identifies you, and
                    the <code>monitor_key</code> identifies your
                    device. This values must be secret.
                </div>
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
                    To view the data sent click on the button bellow.
                </p>
                <a href="#view" data-toggle="tab" class="btn btn-primary btn-block">
                    View
                </a>
            </div>
        </div>
    </div>
</div>
