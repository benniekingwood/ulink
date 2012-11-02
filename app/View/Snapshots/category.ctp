<style>
.featured-snap-container {
 color: #fff;
}

.snap-comments-container {
    height: 313px;
    margin-top: 33px;
    font-size: 0.9em;
}

.snap-comments-list {
    height: 230px;
    overflow-y: auto;
    overflow-x: hidden;
}

.snap-comment-form-container {
    text-align: center;
    margin: 0 auto;
    height: 50px;
}

.ri-grid ul li a > img {
    height: inherit;
}
.ri-grid {
	margin: 30px auto 30px;
	position: relative;
	height: auto;
}

.ri-grid-loading{
	width: 400px;
	height: 100px;
	background: transparent url("/img/loading.gif") no-repeat center center;
}

.ri-grid ul {
	list-style: none;
	display: block;
	width: 100%;
	margin: 0 auto;
	padding: 0;
}

/* Clear floats by Nicolas Gallagher: http://nicolasgallagher.com/micro-clearfix-hack/ */

.ri-grid ul:before,
.ri-grid ul:after{
	content: '';
    display: table;
}

.ri-grid ul:after {
    clear: both;
}

.ri-grid ul {
    zoom: 1; /* For IE 6/7 (trigger hasLayout) */
}

.ri-grid ul li {
	-webkit-perspective: 80px;
	-moz-perspective: 80px;
	-o-perspective: 80px;
	-ms-perspective: 80px;
	perspective: 80px;
	margin: 0;
	padding: 0;
	float: left;
	position: relative;
	display: block;
	overflow: hidden;
	background: #000;
        width: 80px;
        height: 80px;
}

.ri-grid ul li a{
	display: block;
	outline: none;
	position: absolute;
	left: 0;
	top: 0;
	width: 80px;
	height: 80px;
	-webkit-background-size: 80px 80px;
	-moz-background-size: 80px 80px;
	background-size: 80px 80px;
	background-position: center center;
	background-repeat: no-repeat;
	background-color: #333;
	-webkit-box-sizing: content-box;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
}

/* Grid wrapper sizes */
.ri-grid-size-1{
	width: 60%;
}
.ri-grid-size-2{
	width: 100%;
}
.ri-grid-size-3{
	width: 100%;
	margin-top: 0px;
}
.breadcrumbs-white { color: #fff; }
.center-text { text-align: center; }
.left-text { text-align: left; }
.comment-profile-img-container { margin-top: 5px; float: left; }
.snap-comment { border-bottom: #dddddd 1px solid; margin: 3px 8px 0 0; }
.span2 { width: 190px; }
.snap-comment p { font-size: 0.8em; color: #bbbbbb; }
.carousel-inner .item > img { height: 350px;margin: auto;}
.snap-comments-container h4 { margin-top: -10px;}
.snap-comment-form-container textarea { width: 90%; }
a:hover {text-decoration:none; }
.profile-size-small {
    -moz-border-radius: 5px;
    border-radius: 5px;
    width: 40px;
    height: 40px;
}
#snapshotComment{ margin-top: 3px;}
.snap-comments-list div.snap-comment:hover > a {
	opacity: 1;
	filter: alpha(opacity=1);
}
.snap-comments-list div.snap-comment:hover+a {
    opacity: 1;
    filter: alpha(opacity=1);
}
#submit-comment-btn { margin-top: -10px;}
#comment-link p i { margin-top: 1px;}
</style>
<div class="container">
        <h3>
            <a href="<?php echo($this->Html->url('/snapshots/')); ?>">Snapshots</a>
            <span class="divider">&nbsp;/&nbsp;</span><?php echo $category; ?>
        </h3>
    </ul>
    <div class="row span11">
        <div class="featured-snap-container offset2">
            <div class="span6 carousel">
                <h2>Featured Snap</h2>
                <div class="carousel-inner">
                  <div class="item active">
                    <?php if(isset($featuredSnap)) { ?><!-- TODO: change to image server URL -->
                        <img src="<?php echo($this->Html->url('/img/files/snaps/'.$featuredSnap->imageURL)); ?>" alt=""/>
                        <div class="carousel-caption">
                            <div class="span1">
                                <a id="view-profile-<?php echo $featuredSnap->user->User->id; ?>" data-toggle="modal" href="#viewProfileComponent">
                                <?php echo $this->Html->image('files/users/' . $featuredSnap->user->User->image_url . '', array('alt' => 'profile image', 'class'=>'profile-size-small'));?>
                                </a>
                            </div>
                            <p><?php echo $featuredSnap->caption;?></p>
                            <a id="comment-link" href="#" class="pull-right">
                                 <p><i class="icon-comment icon-white"></i>
                                 <span style="margin-top: -19px;"><?php if(count($featuredSnap->comments) > 0) { echo count($featuredSnap->comments); } ?></span></p>
                            </a>
                        </div>
                    <?php } else { ?>
                        <img src="/img/defaults/default_snap.png" alt=""/>
                        <div class="carousel-caption">
                            <div class="span1">&nbsp;</div>
                        </div>
                    <?php } ?>
                  </div> <!-- /item active -->
                </div>
            </div>
        </div> <!-- /featured-snap-container -->
        <div class="snap-comments-container span4 rounded well well-white" style="display:none">
            <h4>Comments</h4>
            <div class="snap-comments-list">
                <?php
                     if(isset($featuredSnap) && isset($featuredSnap->comments) && count($featuredSnap->comments) == 0) {
                       echo '<div id="snap-comments-alert" class="alert alert-warn">There are no comments for this snap.</div>';
                    } else {
                        echo '<div id="snap-comments-alert" class="alert alert-warn" style="display:none;"></div>';
                        if(isset($featuredSnap) && isset($featuredSnap->comments)) { foreach($featuredSnap->comments as $comment) { ?>
                        <div class="row snap-comment">
                            <?php if(isset($loggedInId) && isset($comment->SnapshotComment->userId) && $loggedInId == $comment->SnapshotComment->userId) { ?>
                            <a id="delete-snap-comment-<?php echo $comment->SnapshotComment->_id; ?>" class="pull-right delete-snap-comment-link" href="#" alt=""><i class="icon-remove-sign"></i></a>
                            <?php } ?>
                            <div class="comment-profile-img-container">
                                <a id="view-profile-<?php echo $comment->SnapshotComment->userId; ?>" data-toggle="modal" href="#viewProfileComponent">
                                    <?php echo $this->Html->image('files/users/' . $comment->SnapshotComment->userImageURL . '', array('alt' => 'profile image', 'class'=>'profile-size-small'));?>
                                </a>
                                <br />
                                <p class="campus-event-date"><?php echo date('M j, Y', strtotime($comment->SnapshotComment->created)); //echo DateTime::createFromFormat('Y-m-d H:i:s',$comment->SnapshotComment->created)->format('F d, Y'); ?></p>
                            </div>
                            <div class="span2" style="float: right;">
                                <?php echo $comment->SnapshotComment->comment; ?>
                            </div>
                        </div>
                <?php }}} ?>
            </div>
            <div class="snap-comment-form-container">
                <span id="submit-snap-comment-error"></span>
                <?php echo $this->Form->create(null, array('controller' => 'snapshots', 'action' => 'insert_snap_comment','id' => 'submitSnapCommentForm')); ?>
                <?php echo $this->Form->input('SnapshotComment.comment', array('id' => 'snapshotComment', 'type'=>'textarea','rows' =>'1', 'maxlength' => '140', 'label'=>false, 'div'=>false, 'placeHolder' => 'comment'));?>
                <?php echo $this->Form->input('SnapshotComment._id', array('type' => 'hidden')); ?>
                <?php echo $this->Form->input('SnapshotComment.snapId', array('type' => 'hidden', 'value' => ''.$featuredSnap->_id.'')); ?>
                <?php echo $this->Form->end(); ?>
                <a id="submit-comment-btn" class="btn btn-primary pull-right" disabled="disabled">Post Comment</a>
            </div>
        </div>
    </div> <!-- /row -->
</div> <!-- /container -->
<?php if(isset($snaps) && count($snaps) > 0) { ?>
<div id="ri-grid" class="ri-grid" >
    <ul> <!-- NOTE: we need at Least 32 pictures for rotations to animate -->
          <?php
            foreach($snaps as $snap) {  ?>
                <li>
                  <a href="<?php echo($this->Html->url('/snapshots/category/'.$snap->Snapshot->category.'/'.$snap->Snapshot->_id)); ?>">
                    <img src="<?php echo($this->Html->url('/img/files/snaps/'.$snap->Snapshot->imageURL)); ?>"/>
                  </a>
                </li>
          <?php } ?>
     </ul>
</div> <!-- / ri-grid -->
<?php } ?>
<script type="text/javascript" src="/js/modernizr.custom.26887.js"></script>
<script type="text/javascript" src="/js/jquery.transit.min.js"></script>
<script src="/js/jquery.gridrotator.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#comment-link").on("click", function() {
            showCommentContainer();
        });
        function showCommentContainer() {
            $(".snap-comments-container").show();
            $(".featured-snap-container").removeClass("offset2");
        }
        function hideCommentContainer() {
            $(".snap-comments-container").hide();
            $(".featured-snap-container").addClass("offset2");
        }

      $(function() {
        $( '#ri-grid' ).gridrotator( {
                rows		: 2,
                columns		: 16,
                animType	: 'slideLeft',
                animSpeed	: 2000,
                interval	: 2000,
                step		: 1,
                maxStep: 1,
                preventClick    : false,
                w1024	        : {
                        rows	: 2,
                        columns	: 12
                },
                w768			: {
                        rows	: 2,
                        columns	: 9
                },
                dynamicResizing: true
        });
        var counter=0;
         $('#submitSnapCommentForm').ajaxForm({
            success:function (response) {
                counter+=1;
                var json = $.parseJSON(response);
                if (json["response"] == "true") {
                    $('#snapshotComment').val('');
                    var html = '<div id="snap-comment-' + counter + '" style="display:none;"><div class="row snap-comment"><div class="pull-right" style="width:30px">&nbsp;</div><div class="comment-profile-img-container">';
                    //html += '<a id="view-profile-' + json.SnapshotComment.userId + '" data-toggle="modal" href="#viewProfileComponent">';
                    html += '<img alt="profile image" class="profile-size-small" src="'+hostname+"/img/files/users/"+json.SnapshotComment.userImageURL+'"/><br />';
                    html += '<p class="campus-event-date">' +json.SnapshotComment.created_short + '</p></div><div class="span2" style="float:right;">';
                    html += json.SnapshotComment.comment+'</div></div>';
                    $('#snap-comments-alert').hide('slow');
                    $('.snap-comments-list').append(html);
                    var height = $('.snap-comments-list')[0].scrollHeight;
                    $('.snap-comments-list').animate({ scrollTop: height }, 2700);
                    setTimeout(function(){$('#snap-comment-' + counter +'').fadeIn('slow');}, 2000);
                     $('#submit-comment-btn').removeClass("disabled");
                } else if (json["response"]  == "false") {
                    $('#submit-snap-comment-error').html('Sorry! Your comment was not submitted. Please try again later.');
                }
            }
        });

        $('#submit-comment-btn').on("click", function() {
            if($('#snapshotComment').val().length > 0) {
                $('#submitSnapCommentForm').submit();$('#submit-comment-btn').attr("disabled", "disabled");
            }
        });
        $('#snapshotComment').on("keyup blur", function(event) {
            if(this.value.length == 0) {
                $('#submit-comment-btn').attr("disabled", "disabled");
            } else {
                $('#submit-comment-btn').removeAttr("disabled");
            }
        });
    });
  });
  </script>
<?php echo $this->Html->script(array('ulink-delete-snap-comment.js'));?>