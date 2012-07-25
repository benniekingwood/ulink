<div class="container-fluid">
    <?php echo $this->Form->create('Event', array('controller' => 'events', 'action' => 'edit','name' => 'EventEditForm','type' => 'file', 'class' => 'form-horizontal'));?>
    <?php echo $this->Form->input('_id', array('type' => 'hidden'));?>
    <div class="offset1 row-fluid">
        <div class="span3">
            <div>
                <ul id="sidebar-nav" class="nav nav-tabs nav-stacked">
                    <li><a href="<?php echo($this->Html->url('/users/'));?>"> <i class="icon-user"></i>Profile</a></li>
                    <li><a href="<?php echo($this->Html->url('/users/password'));?>"><i class="icon-lock"></i>Password</a></li>
                    <li  class="active"><a href="#"><i class="icon-calendar"></i>Events</a></li>
                </ul>
            </div>
        </div>
        <div class="span6 well well-white well-nopadding">
            <div id="profile-tab-content" class="profile-content tab-pane active">
                <div class="profile-header">
                    <h3><a href="<?php echo($this->Html->url('/events/myevents')); ?>">Events</a>&nbsp;>&nbsp;My Event</h3>
                </div>
                <div id="event-message">
                    <?php echo $this->Session->flash(); ?>
                </div>
                <div class="row">
                    <div class="span3">
                        <?php echo "<img src='/events/getEventImage/" . $event['Event']['_id'] . "'/>"; ?>
                    </div>
                    <div class="span3">
                        <?php echo $this->Form->input('Event.image', array('class' => 'profile-file-upload','type' => 'file', 'label' => false, 'div' => false)); ?>
                        <p>Maximum file size 700k.<br />Filetypes JPG,PNG,GIF.</p>
                        <a id="lnkDeleteEvent" href="<?php echo($this->Html->url('/events/delete/'.$event['Event']['_id'])); ?>">Delete this event</a>
                    </div>
                </div>
                <hr />
                <div class="control-group">
                    <label class="control-label" for="eventTitle">Title</label>
                    <div class="controls">
                        <?php echo $this->Form->input('Event.eventTitle', array('id' => 'eventTitle', 'class' => 'input-large ulink-input-bigfont','maxlength' => '50', 'label'=>false, 'div'=>false)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="eventDate">Date</label>
                    <div class="controls">
                        <?php echo $this->Form->input('Event.eventDate', array('id' => 'eventDate', 'data-date-format'=>'mm/dd/yy', 'class' => 'input-large ulink-input-bigfont','maxlength' => '10', 'label'=>false, 'div'=>false)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="eventInfo">Information</label>
                    <div class="controls">
                        <?php echo $this->Form->input('Event.eventInfo', array('id' => 'eventInfo', 'type'=>'textarea', 'maxlength' => '750','class' => 'input-xlarge', 'label'=>false, 'div'=>false));?>
                        <p class="input-info"><b><span id="counter"></span></b> characters remaining.</p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="eventLocation">Location</label>
                    <div class="controls">
                        <?php echo $this->Form->input('Event.eventLocation', array('id' => 'eventLocation', 'class' => 'input-large ulink-input-bigfont','maxlength' => '50', 'label'=>false, 'div'=>false, 'placeHolder' => 'Location')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="eventTime">Time</label>
                    <div class="controls">
                        <?php echo $this->Form->input('Event.eventTime', array('id' => 'eventTime', 'class' => 'input-large ulink-input-bigfont','maxlength' => '8', 'label'=>false, 'div'=>false, 'placeHolder' => '03:00 PM')); ?>
                    </div>
                </div>
                <div class="modal-footer">
                   <?php echo $this->Form->button('Save changes', array('id'=>'btnSaveChanges', 'type' => 'submit', 'div' => false, 'class'=>'btn btn-primary btn-large')); ?>
                </div>
            </div> <!-- /profile-tab-content -->
        </div> <!-- /tab-content -->
    </div><!-- /row-fluid -->
</div> <!-- /container-fluid -->
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
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
        $("#EventEditForm").validate({
            invalidHandler: function () {
                $('.profile-error').each(function(a,b){
                    $(this).remove();
                });
            },
            errorClass: "profile-error",
            ignore: ':hidden',
            rules: {
                'data[Event][eventTitle]' : "required",
                'data[Event][eventDate]' : "required",
                'data[Event][eventInfo]' : "required",
                'data[Event][image]' : { accept:"png|jpeg|jpg|gif", filesize: 700000 }
            },
            messages: {
                'data[Event][eventTitle]'	: {
                    required: "Please enter your event title"
                },
                'data[Event][eventDate]' : {
                    required: "Please enter the date of your event"
                },
                'data[Event][eventInfo]' : {
                    required: "Please enter some information about your event"
                },
                'data[Event][image]' : {
                    accept: "Please use images of type jpg, png or gif",
                    filesize: "File size must be less than 700k"
                }
            }
        });
    });
    var characters = 750 - $('#eventInfo').val().length;
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

    $("#lnkDeleteEvent").click(function() {
        return confirm("Are you sure you want to delete this event?");
    });
</script>
<script src="/js/jquery.timePicker.min.js"></script>
<script src="/js/bootstrap-datepicker.js"></script>