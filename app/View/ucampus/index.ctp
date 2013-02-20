<div class="container">
    <div id="events-container" class="span7">
        <div id="featured-events-container" class="columns well">
            <div class="pull-right"><i class="school-logo-icon-<?php echo $userSchoolId?>"></i></div>
            <h2>
                What's Happening
            </h2>
            <div id="featuredEventsCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <?php
                        if(isset($featureEvents) && count($featureEvents) == 0) { ?>
                            <div class="item active">
                                <img alt="featured event images" src="<?php echo URL_DEFAULT_FEATURED_EVENT_IMAGE?>"/>
                               
                                <a href="#" alt="">
                                    <div class="carousel-caption">
                                        <h4>Featured Events</h4>
                                        <p>Select events for your school will be featured in this section.  Will your event be one of the lucky ones featured here?</p>
                                    </div>
                                </a>
                            </div>
                    <?php
                        } else {
                            $x=0; foreach( $featureEvents as $fevent ) {
                            if($x==0) {
                    ?>
                            <div class="item active">
                      <?php   } else {   ?>
                            <div class="item">
                      <?php  }  ?>
                                 <img src="<?php
                                    if(isset($fevent['Event']['imageURL'])) {
                                        echo($this->Html->url(URL_EVENT_IMAGE.$fevent['Event']['imageURL']));
                                    } else { echo(URL_DEFAULT_FEATURED_EVENT_IMAGE); } ?>" alt="featured event image"/>
                                <a href="<?php echo($this->Html->url('/events/view/'.$fevent['Event']['_id'])); ?>" alt="">
                                    <div class="carousel-caption">
                                        <h4><?php echo $fevent['Event']['eventTitle'] ?></h4>
                                        <p><?php echo substr($fevent['Event']['eventInfo'], 0, 200) . '...'; ?></p>
                                    </div>
                                </a>
                            </div>
                    <?php $x++; } }?>
                </div> <!-- /carousel-inner -->
                <a class="left carousel-control" href="#featuredEventsCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#featuredEventsCarousel" data-slide="next">›</a>
            </div> <!-- /featuredEventsCarousel -->
        </div><!-- /feature-events-container -->

        <div id="campus-events-container" class="well">
            <h3>Campus Events<a class="btn btn-warning pull-right" data-toggle="modal" href="#submitEventComponent"><i class="icon-calendar icon-white"></i>Submit Your Event</a></h3>
            <ul class="unstyled scroll">
                <?php
                    if(isset($events) && count($events) == 0) {
                       echo '<br /><div class="alert alert-warn">There are no events for your school right now, wow really?</div>';
                    }
                    else {
                        foreach( $events as $event ) {   ?>
                        <li><a class="pull-right view-event-link" href="<?php echo($this->Html->url('/events/view/'.$event['Event']['_id'])); ?>" alt=""><i class="icon-share-alt"></i>View</a>
                        <span class="campus-event-title"><?php echo $event['Event']['eventTitle'] ?></span>&nbsp;-&nbsp;<span class="campus-event-date"><?php echo DateTime::createFromFormat('Y-m-d H:i:s',$event['Event']['eventDate'])->format('F d, Y'); ?></span>
                        <p><?php echo substr($event['Event']['eventInfo'], 0, 150) . '...'; ?></p>
                        </li>
                <?php } }?>
            </ul>
        </div> <!-- /campus-events-container -->
    </div> <!-- /events-container -->

    <div id="trends-container" class="trends-well span4">
        <div class="trends-trending">
            <?php if(isset($trends))  { echo '<h3>'. $schoolName .' Trends'.'</h3>'; ?>
                <ul class="unstyled">
                    <?php $x=0;foreach($trends as $trend) { ?>
                        <li><a href="#"><?php echo $trend;?></a></li>
                    <?php $x++; if($x==5) break;  } ?>
                </ul>
           <?php } else {  echo '<h3>'. $schoolName .' Tweets'.'</h3>'; }?>
        </div>
        <div class="trends-feed-container scroll">

            <?php foreach ($tweets as $tweet) { ?>
                <div class="row trends-feed">
                    <div class="span1">
                        <?php
                            if (isset($tweet['ulinkImageURL']) && $tweet['ulinkImageURL'] != '' && getimagesize(URL_USER_IMAGE_THUMB . $tweet['ulinkImageURL'])) { ?>
                                <img alt="profile image" src="<?php echo URL_USER_IMAGE_THUMB.$tweet['ulinkImageURL']?>"></img>
                           <?php } else {
                                echo $this->Html->image($tweet['profile_image_url'] , array('alt' => 'tweet profile image'));
                            } ?>

                    </div>
                    <div class="pull-left tweet-username-default">
                        <?php if(isset($tweet['ulinkname'])) { ?>
                        <a id="view-profile-<?php echo $tweet['ulinkUserId'] ?>" data-toggle="modal" href="#viewProfileComponent">
                            <?php echo $tweet['ulinkname']; ?>
                        </a>
                        <?php } else { echo $tweet['from_user'];} ?>
                    </div>
                    <div class="tweet-time-marker">
                        <?php echo $tweet['age'];?>
                    </div>
                    <div class="span3 pull-right">
                        <?php echo $tweet['text'] ?>
                    </div>
                </div>
            <?php } ;?>
        </div> <!-- /trends-feed-container -->
    </div> <!-- /trends-container -->
</div> <!-- /container -->
<!-- components -->
<?php echo $this->element('submit_event'); ?>
<!--  /components -->
<?php echo $this->Html->script(array('bootstrap-carousel.js'));?>
