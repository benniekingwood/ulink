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
            <div class="snap-filter-list-container">
                <ul class="nav-filter-list">
                    <li><a id="filter-pictureframe" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/frame.png" alt="">Frame</div></a></li>
                    <li><a id="filter-vignette" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/vignette.png" alt="">Vignette</div></a></li>
                    <li><a id="filter-sepia" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/sepia.png" alt="">Sepia</div></a></li>
                    <li><a id="filter-warp" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/warp.png" alt="">Warp</div></a></li>
                    <li><a id="filter-lighten" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/lighten.png" alt="">Lighten</div></a></li>
                    <li><a id="filter-nightlights" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/nightlights.png" alt="">Night Lights</div></a></li>
                    <li><a id="filter-darken" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/darken.png" alt="">Darken</div></a></li>
                    <li><a id="filter-solarize" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/solarize.png" alt="">Solarize</div></a></li>
                    <li><a id="filter-heavypaint" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/heavypaint.png" alt="">Heavy Paint</div></a></li>
                    <li><a id="filter-contrastic" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/contrastic.png" alt="">Contrastic</div></a></li>
                  <!--  <li><a id="filter-slicer" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/slicer.png" alt="">Slicer</div></a></li>-->
                    <li><a id="filter-gleam" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/gleam.png" alt="">Gleam</div></a></li>
                    <li><a id="filter-dither" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/dither.png" alt="">Dither</div></a></li>
                    <li><a id="filter-wind" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/wind.png" alt="">Wind</div></a></li>
                    <li><a id="filter-noise" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/noise.png" alt="">Noise</div></a></li>
                    <li><a id="filter-1950" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/1950.png" alt="">1950</div></a></li>
                    <li><a id="filter-paintbrush" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/paintbrush.png" alt="">PaintBrush</div></a></li>
                    <li><a id="filter-8bit" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/8bit.png" alt="">8bit</div></a></li>
                    <li><a id="filter-posterize" href="#"><div class="thumbnail"><img src="/img/defaults/snapfilters/posterize.png" alt="">Posterize</div></a></li>
                </ul> <!-- nav-filter-list -->
            </div> <!-- /tabbable -->
            <div class="snap-img-filter-container">
                <div class="snap-img-loading progress progress-striped active">
                    <div class="bar" style="width: 100%;"></div>
                </div>
                <canvas id="snap-filter-canvas" />
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
                <a id="continue-snap-btn" class="btn btn-primary btn-large">Continue</a>
                <a id="submit-snap-btn" class="btn btn-primary btn-large" style="display: none;">Submit</a>
                <div class="loading-circle-blue" style="display: none;"></div>
                <a id="reset-btn" class="btn btn-large" style="display: none;">Reset Filters</button>
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
    var origImageData, imageURL;
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

    /**
     * Helper method that will apply the
     * filter to the snap image based on the
     * passed in filter name.
     * @param filter
     */
    function applyFilter(filter) {
        var canvas = document.getElementById('snap-filter-canvas')
        var context = canvas.getContext("2d");
        context.strokeStyle = '#fff';
        context.lineWidth  = 30;
        if(typeof origImageData === 'undefined') {
            origImageData = context.getImageData(0,0,canvas.width, canvas.height);
        }
       // context.putImageData(origImageData,0,0);
        var data = context.getImageData(0,0,canvas.width, canvas.height);
        var putData = true;
        switch (filter) {
            case "sepia": JSManipulate.sepia.filter(data, {amount: 18.0});
                break;
            case "warp": JSManipulate.twirl.filter(data, {radius: 200,angle: 57,centerX:0.5,centeryY: 0.5});
                break;
            case "lighten": JSManipulate.brightness.filter(data, {amount: 0.25});
                break;
            case "darken": JSManipulate.brightness.filter(data, {amount: -0.10});
                break;
            case "solarize": JSManipulate.solarize.filter(data, {});
                break;
            case "heavypaint":JSManipulate.circlesmear.filter(data, {size:4.7,density:0.43,mix:0.36});
                break;
            case "contrastic":JSManipulate.contrast.filter(data, {amount:1.42});
                break;
            case "slicer":JSManipulate.crosssmear.filter(data, {distance:8,density:0.5,mix:0.5});
                break;
            case "gleam":JSManipulate.sparkle.filter(data, {rays:78,size:28,amount:66,randomness:35,centerX:0.11,centerY:0.14});
                break;
            case "dither":JSManipulate.dither.filter(data, {levels:4});
                break;
            case "nightlights":JSManipulate.edge.filter(data, {});
                break;
            case "1950":JSManipulate.grayscale.filter(data, {});
                break;
            case "wind":JSManipulate.linesmear.filter(data, {distance:8,density:0.5,angle:0,mix:0.5});
                break;
            case "noise":JSManipulate.noise.filter(data, {amount:59,density:1});
                break;
            case "paintbrush":JSManipulate.oil.filter(data, {range:3});
                break;
            case "8bit":JSManipulate.pixelate.filter(data, {size:4});
                break;
            case "posterize":JSManipulate.posterize.filter(data, {levels:5});
                break;
            case "vignette":JSManipulate.vignette.filter(data, {amount:1});
                break;
            case "pictureframe": {
                context.strokeRect(0,0,canvas.width,canvas.height);
                putData = false;
            }
            break;
        }
        if(putData) {
            context.putImageData(data,0,0);
        }
    }

    $(document).ready(function() {

        // if HTML5 canvas is not supported, show the submit button instead of the Continue button
        if(!isCanvasSupported()) {
            $('#continue-snap-btn').hide();
            $('#submit-snap-btn').show();
        }
        // apply a filter when a filter is clicked
        $("[id^=filter-]").on("click", function() {
            // grab the filter name from the element's id
            var filter = $(this).attr('id').split("-")[1];
            applyFilter(filter);
        });

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

        $('#submitSnapForm').ajaxForm({
            success:function (response) {
                var json = $.parseJSON(response);
                if (json["response"] == "true") {
                    // if canvas is supported, continue to applying filters
                    if(isCanvasSupported()) {
                        $('#continue-snap-btn').hide();
                        $('#submit-snap-btn').show();
                        $('#reset-btn').show();
                        $("#submit-snap-title").html("Filters");
                        $('#counter').hide();
                        $('.submit-snap-img-note').hide();
                        $('.snap-picture-add-action').hide();
                        $('#submit-snap-form-response-container').hide();
                        $('#submit-snap-form-container').hide();
                        $('#snap-filter-container').show('slow');
                        var canvas=document.getElementById("snap-filter-canvas");
                        var context=canvas.getContext("2d");
                        var imageObj = new Image();
                        imageObj.onload = function() {
                            if(imageObj.width > 1000 && imageObj.height > 1000) {
                                new thumbnailer(canvas, imageObj, 700, 3);
                            } else {
                                canvas.width = imageObj.width;
                                canvas.height = imageObj.height;
                                context.drawImage(imageObj, 0, 0);
                            }
                        };
                        imageObj.src = hostname + 'img/files/snaps/' + json["Snapshot"]["imageURL"];
                        imageURL = imageObj.src;
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
            /*
             * if HTML5 canvas is not supported, then perform basic submit.
             * If the canvas is supported, we can assume the user provided
             * filters so we can perform saving of the filtered image.
             */
            if(!isCanvasSupported()) {
                $('#submitSnapForm').submit();
            } else {
                // grab the canvas data, and the original image url
                var canvas=document.getElementById("snap-filter-canvas");
                var strData = canvas.toDataURL("image/jpg");
                $("#applyFilterForm").html('<input type="hidden" name="data[Snapshot][image]" value="'+strData+'"/><input type="hidden" name="data[Snapshot][imageURL]" value="'+imageURL+'"/>');
                $("#applyFilterForm").submit();
                // show loading gif, hide the submit button
                $('.loading-circle-blue').show();
                $('#submit-snap-btn').hide();
                $('#reset-btn').hide();
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
        $("#reset-btn").on("click", function() {
            var canvas=document.getElementById("snap-filter-canvas");
            var context=canvas.getContext("2d");
            canvas.width--;
            canvas.width++;
            context.putImageData(origImageData,0,0);
        });
    });
</script>