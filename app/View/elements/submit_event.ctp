<script src="/js/jquery.min.js"></script>
<!-- components section -->
<div class="modal hide fade" id="submitEventComponent">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>Submit Your Event</h3>
    </div>
    <div class="modal-body">
        <?php echo $this->Form->create('Event', array('controller' => 'events', 'action' => 'add', 'name' => 'submitEventForm', 'type' => 'file')); ?>
        <input name="eventtitle" class="input-large ulink-input-bigfont" type="text" placeHolder="Title">
        <input type="text" name="eventdate" class="input-large ulink-input-bigfont" data-date-format="mm/dd/yy" id="eventdate" placeholder="MM/DD/YYYY">
        <textarea id="eveninfo" name="eveninfo" class="event-textarea ulink-input-bigfont" placeHolder="Event information"></textarea>
        <div><input id="eventloc" name="eventloc" type="text" class="geo-text" style="display: none; visibility: visible;" placeholder="Location"></div>
        <div><input id="eventtime" name="eventtime" type="text" class="time-text input-small" style="display: none; visibility: visible;" placeholder="03:00 PM" maxlength="8"></div>
    </div>
    <div class="modal-footer">
        <div class="submit-event-button-container">
            <div class="event-picture-control">
                <div class="event-picture-add-action" original-title="" rel="tooltip" data-original-title="Add event picture">
                    <div class="event-picture-icon"></div>
                        <input type="file" name="media[]" class="event-file-input">
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
                <span>750</span>
                <a href="#" class="btn btn-primary btn-large">Submit</a>
            </div>
        </div>
    </div>
</div> <!-- /submitEventComponent-->
<script src="./js/jquery.timePicker.min.js"></script>
<script src="/js/bootstrap-datepicker.js"></script>
<script>
    $(function(){
        $('#eventdate').datepicker({
            format: 'mm/dd/yyyy'
        });
    });
</script>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
        $(function(){
            $('#eventtime').timePicker({
                startTime: "24:00",
                endTime: new Date(0, 0, 0, 23, 45, 0),
                show24Hours: false,
                separator:':',
                step: 15});
        });
    });

    // submit event component
    function showEventTimeOn() {
        $('#eventtime').toggle();
        $('.event-time').hide();
        $('.event-time-on').show();
    }
    function showEventTimeOff() {
        $('#eventtime').val('');
        $('#eventtime').toggle();
        $('.event-time').show();
        $('.event-time-on').hide();
    }
    function showEventLocOn() {
        $('#eventloc').toggle();
        $('.event-location').hide();
        $('.event-location-on').show();
    }
    function showEventLocOff() {
        $('#eventloc').val('');
        $('#eventloc').toggle();
        $('.event-location').show();
        $('.event-location-on').hide();
    }
</script>