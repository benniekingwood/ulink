<script type="text/javascript">
    $(document).ready(function () {
        $("#btnForgotPassword").click(function() {
            var valid = true;
            var email = $('#email');
            // first validate the form fields
            if (email.val() == "" || email.val() == undefined) {
                email.focus();
                valid = false;
            } else {
                email.blur();
            }
            // if valid submit the form
            if(valid) {
                return valid;
            } else {
                // remove success if it's there
                $('#forgot-form-container').removeClass('success');
                $('#forgot-form-container').addClass('error');
                $('#login-message').html('Please enter your email address');
                return valid;
            }
        });

        // disable the submit button upon successful validation
        $('#forgotPassswordForm').submit(function() {
            $('#btnForgotPassword').attr("disabled", "disabled");
            return true;
        });
    });
</script>

<div class="container">
    <div class="well span7 offset2">
        <h4>Forgot your password? Don't worry, we're here to help.  Follow the steps below and you will receive a temporary password by email.
        </h4>
        <p>
            <blockquote>
                <ul class="unstyled">
                    <li>Enter the email address registered to your uLink account.</li>
                </ul>
            </blockquote>
        </p>
        <div id="forgot-form-container" class="control-group">
            <?php echo $this->Form->create('User', array('id' => 'forgotPassswordForm', 'action' => 'forgotpassword'));?>
            <div class="controls">
                <?php echo $this->Form->text('email', array('id'=>'email','div' => false, 'label' => false, 'class'=>'input-xxlarge ulink-input-bigfont', 'placeholder' => 'email'));?>
                <span htmlfor="UserEmail" generated="true" class="help-inline error" style="display:block;"></span>
                <span id="login-message" class="help-inline"><?php echo $this->Session->flash(); ?></span>
            </div>
        </div>
        <div id="submit-container">
        <?php echo $this->Form->button('Send Me Instructions', array('id'=>'btnForgotPassword', 'type' => 'submit', 'div' => false, 'class'=>'btn btn-primary btn-large'));?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?php if(isset($forgotError) && $forgotError=='true') { ?>
        <script>$('#forgot-form-container').addClass('error');
        $('#forgot-form-container').removeClass('success');$('#btnForgotPassword').attr("disabled", false);</script>
<?php } else if(isset($forgotError) &&$forgotError=='false'){  ?>
        <script>$('#forgot-form-container').removeClass('error');
            $('#forgot-form-container').addClass('success');$('#email').val('');$('#btnForgotPassword').attr("disabled", false);</script>
<?php } ?>