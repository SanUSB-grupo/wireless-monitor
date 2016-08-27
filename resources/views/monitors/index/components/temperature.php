<!-- Mustache template -->

<script type="text/x-tmpl-mustache" id="template-temperature">
    <div class="col-md-4">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">{{data.description}}</h3>
            </div>
            <div class="box-body">
                <div>
                    Type: {{data.type}}, Unit: {{data.unit}}
                </div>
                <div>
                    Min.: {{data.min}}, Max.: {{data.max}}
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <a href="/monitor/{{id}}" class="btn btn-default btn-sm">
                        <i class="fa fa-chevron-right"></i>
                        View
                    </a>
                </div>
            </div>
        </div>
    </div>
</script>