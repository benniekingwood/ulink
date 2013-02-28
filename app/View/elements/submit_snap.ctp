<!-- components section -->
<div class="modal hide fade" id="submitSnapComponent">
    <div class="modal-header">
        <!--<a class="close" data-dismiss="modal">x</a>-->
        <h3><span id="submit-snap-title">Submit Your Snapshot</span></h3>
    </div>
    <div class="modal-body">

        <div id="snap-filter-container" style="display:none;">
            <div id="submit-snap-alert" class="alert">
                <a href="#" class="close" data-dismiss="alert">x</a>
                You can apply a filter if you like, otherwise just click submit!
            </div>
            <div class="snap-img-filter-container">
                <div class="snap-img-loading progress progress-striped active">
                    <div class="bar" style="width: 100%;"></div>
                </div>
                <img id="snap-picture-canvas" width="100%"><img>
            </div>
        </div>
        <div id="submit-snap-form-response-container" class="row" style="display: none;">
            <div class="success-img span1">&nbsp;</div>
            <div id="submit-snap-response"></div>
        </div>
        <div id="submit-snap-form-container" class="control-group">
            <div id="submit-snap-errors" class="flash-error"></div>
            <div class="controls">
                <?php echo $this->Form->create('Snapshot', array('controller' => 'snapshots', 'action' => 'insert_snap','id' => 'submitSnapForm', 'type' => 'file')); ?>
                <?php echo $this->Form->input('Snapshot.caption', array('id' => 'snapCaption', 'type'=>'textarea', 'maxlength' => '140','class' => 'snap-textarea ulink-input-bigfont', 'label'=>false, 'div'=>false, 'placeHolder' => 'Snapshot caption'));?>
                <div></div>
                <?php echo $this->Form->input('_id', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('Snapshot.category', array( 'type' => 'select', 'empty' =>
                        'Select category', 'label' => false, 'div' => false, 'options' => $categories, 'class' => 'input-xlarger')); ?>
                <div></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="submit-snap-img-note">Optimal image size: 500px*500px</div>
        <div class="submit-snap-button-container">
            <div class="snap-picture-add-action" original-title="" rel="tooltip" data-original-title="Add picture">
                <?php echo $this->Form->input('image', array('class' => 'snap-file-input','type' => 'file', 'label' => false, 'div' => false)); ?>
                <div style="text-align: left"></div>
                <?php echo $this->Form->end(); ?>
            </div>

            <div class="submit-snap-button-sub-container">
                <img style="display: none;" class="spinner" src="">
                <span id="counter"></span>
                <button id="continue-snap-btn" class="btn btn-primary btn-large">Continue</button>
                <button id="apply-filter-btn" class="btn btn-large" style="display: none;">Apply Filters</button>
                <button id="submit-snap-btn" class="btn btn-primary btn-large" style="display: none;">Submit</button>
                <div class="loading-circle-blue" style="display: none;"></div>
            </div>
        </div>
    </div>
    <div style="display:none">
         <form id="applyFilterForm" action="/snapshots/apply_snap_filter/" enctype="multipart/form-data" method="POST" target="_self"></form>
         <?php echo $this->Form->create('Snapshot', array('controller' => 'snapshots', 'action' => 'apply_snap_filter','id' => 'applyFilterForm', 'type' => 'file')); ?>
         <?php echo $this->Form->end(); ?>
    </div>
</div> <!-- /submitEventComponent-->
<script type="text/javascript" src="/js/jsmanipulate.min.js"></script>
<script type="text/javascript" src="/js/ulink-thumbnailer.js"></script>
<script type="text/javascript" language="javascript">
    var origImageData, imageURL, _id;
    /*
     * value = value of the element (file name)
     * element = element to validate (<input>)
     * param = size (en bytes)
     */
    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    });

    $.validator.addMethod('filerequired', function (value, element, param) {
        return (typeof value !== 'undefined' || value !== '') && (typeof element.files[0] !== 'undefined' && element.files[0].size > param);
    });

    /**
     * Helper function to determine if an
     * HTML5 canvas is supported.
     */
    function isCanvasSupported(){
        var elem = document.createElement('canvas');
        return !!(elem.getContext && elem.getContext('2d'));
    }

    $(document).ready(function() {

        // if HTML5 canvas is not supported, show the submit button instead of the Continue button
        if(!isCanvasSupported()) {
            $('#continue-snap-btn').hide();
            $('#submit-snap-btn').show();
        }

        $("#submitSnapForm").validate({
            invalidHandler: function () {
                $('.file-error').each(function(a,b){
                    $(this).remove();
                });
            },
            errorClass: "file-error",
            ignore: ':hidden',
            errorPlacement:function (error, element) {

                var attr = $(element).attr('id');
                // For some browsers, `attr` is undefined; for others,
                // `attr` is false.  Check for both.
                if (typeof attr !== 'undefined' && attr == 'SnapshotImage') {
                    error.appendTo(element.next("div"));
                } else {
                    error.appendTo(element.next("div"));
                    $('#submit-snap-form-container').addClass('error');
                }
                $('#continue-snap-btn').removeAttr("disabled");
            },
            rules: {
                'data[Snapshot][image]' : { accept:"jpg|gif", filesize: 700000, filerequired: 0},
                'data[Snapshot][category]':"required",
                'data[Snapshot][caption]':{
                    required:true,
                    maxlength:140
                },
            },
            messages: {
                'data[Snapshot][image]' : {
                    accept: "Please use images of type jpg or gif",
                    filesize: "File size must be less than 700k",
                    filerequired: "Please choose a picture to upload"
                }, 'data[Snapshot][caption]':{
                    required:"Please enter your snap caption",
                    maxlength:"Please enter no more than 140 characters"
                },
                'data[Snapshot][category]':{
                    required:"Please select a category"
                }
            }
        });

        /*
         * Snap picture form submission
         */
        $('#submitSnapForm').ajaxForm({
            success:function (response) {
                var json = $.parseJSON(response);
                if (json["response"] == "true") {
                    // if canvas is supported, continue to applying filters
                  if(isCanvasSupported()) {
                        $('#continue-snap-btn').hide();
                        $('#submit-snap-btn').show();
                        $('#apply-filter-btn').show();
                        $("#submit-snap-title").html("Filters");
                        $('#counter').hide();
                        $('.submit-snap-img-note').hide();
                        $('.snap-picture-add-action').hide();
                        $('#submit-snap-form-response-container').hide();
                        $('#submit-snap-form-container').hide();
                        $('#snap-filter-container').show('slow');

                        imageURL = URL_IMAGES_S3 + 'files/snaps/' + json["Snapshot"]["imageURL"];
                        $('#snap-picture-canvas').attr("src", imageURL);
                        _id = json["Snapshot"]["_id"];

                        setTimeout(function(){$("#submit-snap-alert").hide("slow");},5000); 
                    } else { 
                        $('#submit-snap-btn').addClass("disabled");
                        $('#submit-snap-form-response-container').show();
                        $('#submit-snap-form-container').hide();
                        $('.submit-snap-button-container').hide();
                        $('.submit-snap-img-note').hide();
                        $('#submit-snap-response').html('Thank you!  Your snap has been submitted and shared with your college.');
                    }
                } else if (json["response"]  == "false") {
                    $('#submit-snap-errors').html('Sorry! Your snap was not submitted. Please try again later.');
                }
            }
        });

        $('#continue-snap-btn').on("click", function () {
            $('#continue-snap-btn').attr("disabled", "disabled");
            $('#submitSnapForm').submit();
        });

       $('#submit-snap-btn').on("click", function () {
            $('#submit-snap-btn').attr("disabled", "disabled");
            /*
             * if HTML5 canvas is not supported, then perform basic submit.
             * If the canvas is supported, we can assume the user provided
             * filters so we can perform saving of the filtered image.
             */
            if(!isCanvasSupported()) {
                $('#submitSnapForm').submit();
            } else {
                $("#applyFilterForm").html('<input type="hidden" name="data[Snapshot][imageURL]" value="'+imageURL+'"/><input type="hidden" name="data[Snapshot][imageURLFiltered]" value="'+$('#snap-picture-canvas').attr('src')+'"/><input type="hidden" name="data[Snapshot][_id]" value="'+_id+'"/>');
                $("#applyFilterForm").submit();
                // show loading gif, hide the submit button
                $('.loading-circle-blue').show();
                $('#submit-snap-btn').hide();
                $('#apply-filter-btn').hide();
            } 
        });

         $('#applyFilterForm').ajaxForm({
            success:function (response) {
                 $('.loading-circle-blue').hide();
                var json = $.parseJSON(response);
                if (json["response"] == "true") {
                    $('#snap-filter-container').hide();
                    $("#submit-snap-title").html("Snapped!");
                    $('#submit-snap-btn').addClass("disabled");
                    $('#submit-snap-form-response-container').show();
                    $('#submit-snap-form-container').hide();
                    $('.submit-snap-button-container').hide();
                    $('.submit-snap-img-note').hide();
                    $('#submit-snap-response').html('Your snap has been submitted and shared with your college.')
                } else if (json["response"]  == "false") {
                    $('#submit-snap-errors').html('Sorry! Your snap was not submitted. Please try again later.');
                }
            }
        });

        var characters = 140;
        $("#counter").append(characters);
        $("#snapCaption").on("keyup", function(){
            if($(this).val().length > characters){
                $(this).val($(this).val().substr(0, characters));
            }
            var remaining = characters -  $(this).val().length;
            $("#counter").html(remaining);
            if(remaining <= 10) {
                $("#counter").css("color","red");
            } else {
                $("#counter").css("color","black");
            }
        });

        /* Filters section */
        $("#apply-filter-btn").on("click", function() {
           launchEditor('snap-picture-canvas',$('#snap-picture-canvas').attr('src'));
        });
    });
</script>
<script type="text/javascript" src="http://feather.aviary.com/js/feather.js"></script>
<!-- Instantiate the widget -->
<script type="text/javascript">

    var featherEditor = new Aviary.Feather({
        apiKey: AVIARY_KEY,
        apiVersion: 2,
        tools: ['effects', 'enhance', 'orientation', 'resize', 'crop', 'warmth', 'brightness', 'contrast', 'saturation', 'sharpness', 'draw', 'text', 'redeye', 'blemish'],
        onSave: function(imageID, newURL) {
           var img = document.getElementById(imageID);
           img.src = newURL;
        },
        postUrl: '', 
    });

    function launchEditor(id, src) {
        featherEditor.launch({
            image: id,
            url: src
        });
        return false;
    }

</script>                         
