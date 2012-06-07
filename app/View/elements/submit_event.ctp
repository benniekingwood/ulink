<?php echo $javascript->link(array('jquery.min.js')); ?>
<!-- components section -->
<div class="modal hide fade" id="submitEventComponent">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>Submit Your Event</h3>
    </div>
    <div class="modal-body">
        <input name="eventtitle" class="input-large ulink-input-bigfont" type="text" placeHolder="Title">
        <input name="eventdate" class="input-large ulink-input-bigfont" type="text" placeholder="MM/DD/YYYY">
        <textarea name="eveninfo" class="event-textarea ulink-input-bigfont" placeHolder="Event information"></textarea>
        <div><input id="eventloc" type="text" class="geo-text" style="display: none; visibility: visible;" placeholder="Location"></div>
        <div><input id="eventtime" type="text" class="time-text input-small" style="display: none; visibility: visible;" placeholder="03:00 PM" maxlength="8"></div>
    </div>
    <div class="modal-footer">
        <div class="submit-event-button-container">
            <div class="event-picture-control">
                <div class="event-picture-add-action" original-title="" rel="tooltip" data-original-title="Add event picture">
                    <div class="event-picture-icon"></div>
                    <form id="submitEventForm" action="">
                        <input type="file" name="media[]" class="event-file-input">
                    </form>
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
No newline at end of file
