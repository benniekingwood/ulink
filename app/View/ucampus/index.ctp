<div class="container">
    <div id="events-container" class="span6 offset1">
        <div id="featured-events-container" class="columns well">
            <div class="pull-right"><i class="school-logo-icon-virginiatech"></i></div>
            <h2>
                What's Happening
            </h2>
            <div id="featuredEventsCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <?php $x=0; foreach( $featureEvents as $fevent ) {
                        if($x==0) {  ?>
                            <div class="item active">
                      <?php   } else {   ?>
                            <div class="item">
                      <?php  }  ?>
                        <img src="<?php echo $fevent['Event']['eventInfo'] ?>" alt="">
                        <a href="<?php echo($this->Html->url('/events/'.$fevent['Event']['_id'])); ?>" alt="">
                            <div class="carousel-caption">
                                <h4><?php  $fevent['Event']['eventTitle'] ?></h4>
                                <p><?php echo $fevent['Event']['eventInfo'] ?></p>
                            </div>
                        </a>
                    </div>
                    <?php $x++; } ;?>
                </div> <!-- /carousel-inner -->
                <a class="left carousel-control" href="#featuredEventsCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#featuredEventsCarousel" data-slide="next">›</a>
            </div> <!-- /featuredEventsCarousel -->
        </div><!-- /feature-events-container -->
        <div id="campus-events-container" class="well">
            <h3>Campus Events<a class="btn btn-warning pull-right" data-toggle="modal" href="#submitEventComponent"><i class="icon-calendar icon-white"></i>Submit Your Event</a></h3>
            <ul class="unstyled scroll">
                <?php foreach( $events as $event ) {   ?>
                    <li><a class="pull-right view-event-link" href="<?php echo($this->Html->url('/events/'.$event['Event']['_id'])); ?>" alt=""><i class="icon-share-alt"></i>View</a>
                    <span class="campus-event-title"><?php  $event['Event']['eventTitle'] ?></span>&nbsp;-&nbsp;<span class="campus-event-date"><?php echo $this->Time->format('l F jS, Y', $this->Time->fromString($event['Event']['eventDate']))?></span>
                    <p><?php echo $event['Event']['eventInfo'] ?></p>
                    </li>
                <?php } ;?>
            </ul>
        </div> <!-- /campus-events-container -->
    </div> <!-- /events-container -->

    <div id="trends-container" class="trends-well span3-5">
        <div class="trends-trending">
            <h3>Virginia Tech Trends</h3>
            <ul class="unstyled">
                <li><a href="#">#swimwear</a></li>
                <li><a href="#">#IloveFootball</a></li>
                <li><a href="#">#VawterHallBrawl</a></li>
                <li><a href="#">#Drillfield</a></li>
                <li><a href="#">#snowday</a></li>
            </ul>
        </div>
        <div class="trends-feed-container scroll">
            <div class="row trends-feed">
                <div class="span1">
                    <img src="./img/pic1.png" alt="">
                    <a data-toggle="modal" href="#viewProfileComponent">deanVT</a>
                </div>
                <div class="span2">Oh man, just got to Tech and it is cold as *&t*.  #blown #freezing</div>
            </div>
            <div class="row trends-feed">
                <div class="span1">
                    <img src="./img/pic2.png" alt="">
                    <a data-toggle="modal" href="#viewProfileComponent">jackHokie</a>
                </div>
                <div class="span2">The drillfield was literally covered in about a million feet of snow.  #why</div>
            </div>
            <div class="row trends-feed">
                <div class="span1">
                    <img src="./img/pic3.png" alt="">
                    <a data-toggle="modal" href="#viewProfileComponent">ladyBell</a>
                </div>
                <div class="span2">Hey @testch, when are we going to get togther for our study group? #needanswers</div>
            </div>
            <div class="row trends-feed">
                <div class="span1">
                    <img src="./img/me.png" alt="">
                    <a id="view-profile-107" data-toggle="modal" href="#viewProfileComponent">bigwillie</a>
                </div>
                <div class="span2">The brothers of Phi Beta Sigma Fraternity, Inc. are having a food drive in front of O'Shag.  #gomab #service</div>
            </div>
            <div class="row trends-feed">
                <div class="span1">
                    <img src="http://placehold.it/40x40" alt="">
                    <a data-toggle="modal" href="#viewProfileComponent">VabdoshT</a>
                </div>
                <div class="span2">I like to sleep, and have the covers over my head like I'm in a mini coma.  #sleepisthebest</div>
            </div>
            <div class="row trends-feed">
                <div class="span1">
                    <img src="./img/joe.png" alt="">
                    <a data-toggle="modal" href="#viewProfileComponent">blingblau</a>
                </div>
                <div class="span2">I run VT.  That is all.  #idoit #blauentertainment #astonmartinmusic</div>
            </div>
            <div class="row trends-feed">
                <div class="span1">
                    <img src="http://placehold.it/40x40" alt="">
                    <a data-toggle="modal" href="#viewProfileComponent">yellowTail</a>
                </div>
                <div class="span2">I like to sleep, and have the covers over my head like I'm in a mini coma.  #sleepisthebest</div>
            </div>
        </div> <!-- /trends-feed-container -->
    </div> <!-- /trends-container -->
</div> <!-- /container -->

<!-- components -->
<?php echo $this->element('submit_event'); ?>
<!--  components -->
