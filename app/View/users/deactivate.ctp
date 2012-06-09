<div class="container">
    <div class="well span7 offset2">
        <div id="deactivate-container">
            <h4>We're sad to see you leave...</h4>
            <p>
            <blockquote>
                <ul class="unstyled">
                    <li>Once your account is deactivated, you can reactivate it by simply logging back into uLink.</li>
                </ul>
            </blockquote>
            </p>
            <div id="deactivate-message"></div>
            <a id="btn-deactivate" class="btn btn-warning btn-xlarge">Deactivate My Account</a>
        </div>
        <div id="deactive-container" style="display: none;">
            <h4>Deactivation Complete.</h4>
            <p>
            <blockquote>
                <ul class="unstyled">
                    <li>Your account will automatically be reactivated upon your next login to uLink.</li>
                </ul>
            </blockquote>
            </p>
        </div>
    </div>
</div>
<?php echo $this->Html->script(array('ulink-deactivate.js')); ?>
