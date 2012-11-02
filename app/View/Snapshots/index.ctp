<style type="text/css">
.categories {
  -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
  filter:alpha(opacity=70);
  -moz-opacity:0.70;
  -khtml-opacity: 0.70;
  opacity: 0.70;
  background-color: #000;
  width: 100%;
  height: 120px;
  padding: 30px 0;
  margin: 100px 0 20px 0;
  clear: both;
}
.categories > div > ul > li {
  padding: 20px 30px;
  font-size: 1.4em;
  color: #fff;
  display: inline;
  width: 150px;
}

.categories > div > ul {
  text-align: center;
  margin: 0 auto;
  margin-top: 45px;
}

a.gray {
  color: #666;
  -webkit-transition: color .2s linear;
  -moz-transition: color .2s linear;
  transition: color .2s linear;
}
a.gray:hover {
  color: #fff;
  text-decoration: none;
}
.snapshot-hero {
    background: url('../img/summer-bg.jpg') 0% 0% no-repeat black;
    height: 480px;
}
.snapshot-hero h1 {
  color: #fff;
}
.snapshot-hero p {
  color: #fff;
}
.splash-snap {
   /* position: absolute; */
    z-index: 0;
}
.clear {
    clear: both;
}
.ri-grid ul li a > img {
    height: inherit;
}
#splash-snaps-container {
    text-align: center;
    left: 2px;
    margin: 5px 0 5px 0;
    /*width: 790px;*/
}

.ri-grid{
	margin: 30px auto 30px;
	position: relative;
	height: auto;
}

.ri-grid-loading{
	width: 400px;
	height: 100px;
	background: transparent url("../img/loading.gif") no-repeat center center;
}

.ri-grid ul {
	list-style: none;
	display: block;
	width: 80%;
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
    width: 600px;
}

.ri-grid ul li {
	-webkit-perspective: 150px;
	-moz-perspective: 150px;
	-o-perspective: 150px;
	-ms-perspective: 150px;
	perspective: 150px;
	margin: 0;
	padding: 0;
	float: left;
	position: relative;
	display: block;
	overflow: hidden;
	background: #000;
        width: 150px;
        height: 150px;
}

.ri-grid ul li a{
	display: block;
	outline: none;
	position: absolute;
	left: 0;
	top: 0;
	width: 150px;
	height: 150px;
	-webkit-background-size: 150px 150px;
	-moz-background-size: 150px 150px;
	background-size: 150px 150px;
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
</style>
<div class="container">
    <div class="hero-unit snapshot-hero span10">
        <h1>Campus Snapshots.</h1>
        <p>Capture every moment of college, and share them with your school.</p>
        <a class="btn btn-warning btn-xlarge pull-right" data-toggle="modal" href="#submitSnapComponent">
            Submit Your Snapshot
        </a>
        <div class="categories rounded">
            <div class="row">
                <ul class="unstyled">
		    <?php foreach($categoryObjs as $category) {  ?>
		     <li><a class="gray" href="<?php echo($this->Html->url('/snapshots/category/'.$category['SnapshotCategory']['_id'])); ?>">
			<?php echo $category['SnapshotCategory']['name'] ?>
			</a>
		     </li>
		    <?php } ?>
                </ul>
            </div>
        </div>
        <div id="splash-snaps-container" class="row ri-grid">
	  <ul>
	    <?php
	      if(isset($splashsnaps) && count($splashsnaps) > 3) {
		  foreach($splashsnaps as $splashsnap) {  ?>
		      <li>
			<a href="<?php echo($this->Html->url('/snapshots/category/'.$splashsnap[0]['Snapshot']['category'].'/'.$splashsnap[0]['Snapshot']['_id'])); ?>">
			  <img src="<?php echo($this->Html->url('/img/files/snaps/'.$splashsnap[0]['Snapshot']['imageURL'])); ?>"/>
			</a>
		      </li>
	    <?php } }?>
          </ul>
      </div> <!-- /splash-snaps-container -->
</div> <!-- /snapshot-hero -->
</div> <!-- /container -->
<script type="text/javascript" src="/js/modernizr.custom.26887.js"></script>
<script type="text/javascript" src="/js/jquery.transit.min.js"></script>
<script src="/js/jquery.gridrotator.js"></script>
  <script>
  $(function() {

  $( '#ri-grid' ).gridrotator( {
           rows		: 1,
            columns		: 5,
            animType	: 'fadeInOut',
            animSpeed	: 1000,
            interval	: 600,
            step		: 1,
            preventClick    : false,
            w1024	        : {
                    rows	: 1,
                    columns	: 5
            },
            w768			: {
                    rows	: 1,
                    columns	: 4
            },
  }); });
  </script>
  <!-- components -->
<?php echo $this->element('submit_snap'); ?>