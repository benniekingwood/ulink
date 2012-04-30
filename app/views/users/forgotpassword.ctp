<script type="text/javascript">
    $(document).ready(function () {
        $("#btnForgotPassword").click(function() {
            var valid = true;
            // first validate the form fields
            if ($('#email').val() == "") {
                $('#email').focus();
                valid = false;
            } else {
                $('#email').blur();
            }

            // if valid submit the form
            if(valid) {
                return valid;
            } else {
                $('#forgot-form-container').addClass('error');
                $('#login-message').html('Please enter your email address');
                return valid;
            }
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
            <?php echo $form->create('User', array('id' => 'forgotPassswordForm', 'action' => 'forgotpassword'));?>
            <div class="controls">
                <?php echo $form->text('email', array('div' => false, 'label' => false, 'class'=>'input-xxlarge ulink-input-bigfont', 'placeholder' => 'email'));?>
                <span htmlfor="UserEmail" generated="true" class="help-inline error" style="display:block;"></span>
                <span class="help-inline"><?php $session->flash(); ?></span>
            </div>
        </div>
        <?php echo $form->button('Send Me Instructions', array('id'=>'btnForgotPassword', 'type' => 'submit', 'div' => false, 'class'=>'btn btn-primary btn-large'));?>
        <?php echo $form->end(); ?>
    </div>
</div>
<?php if($forgotError=='true') { ?>
        <script>$('#forgot-form-container').addClass('error');</script>
<?php } else {  ?>
        <script>$('#forgot-form-container').removeClass('error');</script>
<?php } ?>