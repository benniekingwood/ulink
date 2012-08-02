<script src="/js/jquery.min.js"></script>
<!-- components section -->
<div class="modal hide fade" id="submitEventComponent">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>Submit Your Event</h3>
    </div>
    <div class="modal-body">
        <div id="submit-event-form-response-container" class="row" style="display: none;">
            <div class="success-img span1">&nbsp;</div>
            <div id="submit-event-response"></div>
        </div>
        <div id="submit-event-form-container" class="control-group">
            <div id="submit-event-errors" class="flash-error"></div>
            <div class="controls">
                <?php echo $this->Form->create('Event', array('controller' => 'events', 'action' => 'insertEvent','id' => 'submitEventForm', 'type' => 'file')); ?>
                <?php echo $this->Form->input('Event.eventTitle', array('id' => 'eventTitle', 'class' => 'input-large ulink-input-bigfont','maxlength' => '50', 'label'=>false, 'div'=>false, 'placeHolder' => 'Title')); ?>
                <?php echo $this->Form->input('Event.eventDate', array('id' => 'eventDate', 'data-date-format'=>'mm/dd/yy', 'class' => 'input-large ulink-input-bigfont','maxlength' => '10', 'label'=>false, 'div'=>false, 'placeHolder' => 'MM/DD/YYYY')); ?>
                <?php echo $this->Form->input('Event.eventInfo', array('id' => 'eventInfo', 'type'=>'textarea', 'maxlength' => '750','class' => 'event-textarea ulink-input-bigfont', 'label'=>false, 'div'=>false, 'placeHolder' => 'Event information'));?>
                <?php echo $this->Form->input('_id', array('type' => 'hidden')); ?>
                <div>
                    <?php echo $this->Form->input('Event.eventLocation', array('id' => 'eventLocation', 'class' => 'geo-text', 'style'=>'display: none; visibility: visible;','maxlength' => '50', 'label'=>false, 'div'=>false, 'placeHolder' => 'Location')); ?>
                </div>
                <div>
                    <?php echo $this->Form->input('Event.eventTime', array('id' => 'eventTime', 'class' => 'time-text input-small', 'style'=>'display: none; visibility: visible;','maxlength' => '8', 'label'=>false, 'div'=>false, 'placeHolder' => '03:00 PM')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="submit-event-img-note">Optimal image size: 500px*500px</div>
        <div class="submit-event-button-container">
            <div class="event-picture-control">
                <div class="event-picture-add-action" original-title="" rel="tooltip" data-original-title="Add event picture">
                    <div class="event-picture-icon"></div>
                    <?php echo $this->Form->input('image', array('class' => 'event-file-input','type' => 'file', 'label' => false, 'div' => false)); ?>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
				<span class="event-location-control">
				  <a class="event-location" href="#" onclick="javascript:showEventLocOn();">
                      <span class="location-icon" original-title="" rel="tooltip" data-original-title="Add event location" style="display: block; visibility: visible;">&nbsp;</span>
                  </a>
				  <a class="event-location-on" href="#" onclick="javascript:showEventLocOff();" style="display: none; visibility: visible;">
                      <span class="location-icon-on" original-title="" >&nbsp;</span>
                  </a>
				</span>
				<span class="event-time-control">
				  <a class="event-time" href="#" onclick="javascript:showEventTimeOn();">
                      <span class="time-icon" original-title="" rel="tooltip" data-original-title="Add event time" style="display: block; visibility: visible;">&nbsp;</span>
                  </a>
				  <a class="event-time-on" href="#" onclick="javascript:showEventTimeOff();" style="display: none; visibility: visible;">
                      <span class="time-icon-on" original-title="">&nbsp;</span>
                  </a>
				</span>
            <div class="submit-event-button-sub-container">
                <img style="display: none;" class="spinner" src="">
                <span id="counter"></span>
                <a id="btnSubmitEvent" class="btn btn-primary btn-large">Submit</a>
            </div>
        </div>
    </div>
</div> <!-- /submitEventComponent-->
<script src="/js/validate.js"></script>
<script src="/js/jquery.timePicker.min.js"></script>
<script src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" language="javascript">
    /*
     * value = value of the element (file name)
     * element = element to validate (<input>)
     * param = size (en bytes)
     */
    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    });

    $(document).ready(function(){
        $(function(){
            $('#eventTime').timePicker({
                startTime: "24:00",
                endTime: new Date(0, 0, 0, 23, 45, 0),
                show24Hours: false,
                separator:':',
                step: 15});
        });
        $(function(){
            $('#eventDate').datepicker({
                format: 'mm/dd/yyyy',
                weekStart: 0
            });
        });

        var d = new Date();
        var curr_date = d.getDate();
        var curr_month = d.getMonth() + 1; //Months are zero based
        var curr_year = d.getFullYear();
        var today = curr_month + "/" + curr_date + "/" + curr_year;
        $('#eventDate').val(today);

        $("#submitEventForm").validate({
            invalidHandler: function () {
                $('.file-error').each(function(a,b){
                    $(this).remove();
                });
            },
            errorClass: "file-error",
            ignore: ':hidden',
            rules: {
                'data[Event][image]' : { accept:"png|jpeg|jpg|gif", filesize: 700000 }
            },
            messages: {
                'data[Event][image]' : {
                    accept: "Please use images of type jpg, png or gif",
                    filesize: "File size must be less than 700k"
                }
            }
        });

        $('#submitEventForm').ajaxForm({
            success:function (response) {
                if (response == "true") {
                    $('#btnSubmitEvent').addClass("disabled");
                    $('#submit-event-form-response-container').show();
                    $('#submit-event-form-container').hide();
                    $('.submit-event-button-container').hide();
                    $('.submit-event-img-note').hide();
                    $('#submit-event-response').html('Thank you!  Your event has been submitted.  Please check back later to see if your event has been approved.');
                } else if (response == "false") {
                    $('#submit-event-errors').html('Sorry! Your event was not submitted. Please try again later.');
                }
            },
            beforeSubmit:function (formData, jqForm, options) { // pre-submit callback
                var errors = '';
                if ($('#eventTitle').val() == "") {
                    errors += "Please enter your event's title.<br />";
                    $('#eventTitle').focus();
                }
                if ($('#eventDate').val() == "") {
                    errors += "Please enter your event's date.<br />";
                    $('#eventDate').focus();
                }
                if ($('#eventInfo').val() == "") {
                    errors += "Please enter your event's information.<br />";
                    $('#eventInfo').focus();
                }
                if(errors.length > 0) {
                    $('#submit-event-form-container').addClass('error');
                    $('#submit-event-errors').html(errors);
                    return false;
                }
            }
        });

        $('#btnSubmitEvent').click(function () {
            $('#submitEventForm').submit();
        });

        var characters = 750;
        $("#counter").append(characters);
        $("#eventInfo").keyup(function(){
            if($(this).val().length > characters){
                $(this).val($(this).val().substr(0, characters));
            }
            var remaining = characters -  $(this).val().length;
            $("#counter").html(remaining);
            if(remaining <= 30) {
                $("#counter").css("color","red");
            } else {
                $("#counter").css("color","black");
            }
        });
    });

    // submit event component
    function showEventTimeOn() {
        $('#eventTime').toggle();
        $('.event-time').hide();
        $('.event-time-on').show();
    }
    function showEventTimeOff() {
        $('#eventTime').val('');
        $('#eventTime').toggle();
        $('.event-time').show();
        $('.event-time-on').hide();
    }
    function showEventLocOn() {
        $('#eventLocation').toggle();
        $('.event-location').hide();
        $('.event-location-on').show();
    }
    function showEventLocOff() {
        $('#eventLocation').val('');
        $('#eventLocation').toggle();
        $('.event-location').show();
        $('.event-location-on').hide();
    }
</script>