<!-- Mustache template -->

<script type="text/x-tmpl-mustache" id="template-monitor-temperature">
<div class="row">
    <div class="col-md-3 col-md-offset-4">
        <input type="text" value="75" data-angleArc="250" data-angleOffset="-125"
        class="input-knob"/>
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-default btn-block">{{data.min}}</button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-default btn-block">{{data.max}}</button>
            </div>
        </div>
    </div>
</div>
</script>
