<?php echo $form->create('Review', array('action' => 'searchresults'));
echo $form->text('search', array('type' => 'text', 'id' => 'inputString', 'value' => 'Quick search', 'autocomplete' => 'off', 'onMouseover' => 'showOptionReviews()', 'onfocus' => 'blank(this)', 'onKeyUp' => 'lookup(this.value)', 'onblur' => 'unblank(this)')); ?>
<div class="suggestionsBox" id="suggestions" style="display: none; ">
    <div class="suggestionList" id="autoSuggestionsList">
        &nbsp;
    </div>
</div>
<?php echo $form->button('Search', array('type' => 'Submit', 'class' => 'btn', 'onmouseover' => 'blankDefault()', 'onmouseout' => 'fillDefault()'));
echo $form->end(); ?>