<?php echo $this->Form->create(('Review', array('action' => 'searchresults'));
echo $this->Form->text('search', array('type' => 'text', 'id' => 'inputString', 'value' => 'Quick search', 'autocomplete' => 'off', 'onMouseover' => 'showOptionReviews()', 'onfocus' => 'blank(this)', 'onKeyUp' => 'lookup(this.value)', 'onblur' => 'unblank(this)')); ?>
<div class="suggestionsBox" id="suggestions" style="display: none; ">
    <div class="suggestionList" id="autoSuggestionsList">
        &nbsp;
    </div>
</div>
<?php echo $this->Form->button('Search', array('type' => 'Submit', 'class' => 'btn', 'onmouseover' => 'blankDefault()', 'onmouseout' => 'fillDefault()'));
echo $this->Form->end(); ?>