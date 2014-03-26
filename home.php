<?php $title="Home"; include 'header.php'; ?>
<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<div class="col-xs-12 col-sm-9">
			<p class="pull-right visible-xs">
				<button id="toggle" type="button" class="btn btn-xs" data-toggle="offcanvas">Toggle nav</button>
			</p>		
			<div id='carousel' class="container-carousel clearfix" data-bind="visible: showShowCase">
				<div id="carousel-generic" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner"></div><!-- /.Wrapper for slides--><!-- Wrapper for slides -->
					<ol class="carousel-indicators" data-bind="foreach: showcasePosts"><!-- Indicators -->
						<li data-target="#carousel-generic" data-bind="attr:{'data-slide-to': $index()}, css:{active: !$index()}"></li>
					</ol><!-- /.Indicators-->
				</div><!--/#carousel-generic-->
			</div><!-- /.container-carousel-->
			<div class="container-stream-widget"><!--container-stream-widget-->
			 	<div class="stream"></div>
			    <div id="share-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			        <div class="modal-dialog">
					    <div class="modal-content">
					        <div class="modal-header">
						    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						    	<h4 class="modal-title" id="myModalLabel">Share a Post</h4>
							</div>
							<h4 id="share-modal-loading" style="display: none; margin-left: 20px;"><span class="glyphicon glyphicon-refresh"></span> Loading...</h4>
							<div id="share-modal-sharepost-container" class="modal-body"></div>
					    </div><!--/.modal-content-->
			        </div><!--/.modal-dialog-->
			    </div><!--/.share-modal-->
			</div><!--/.container-stream-widget-->
		</div><!--/span-->
		<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation"><!--sidebar-->
			<div class="list-group">
				<a href="#" class="list-group-item" data-bind="click: changeStream.bind($data, 'current'), css:{active: activeStream() == 'current'}">Social</a>
				<a href="#" class="list-group-item" data-bind="click: changeStream.bind($data, 'twitter'), css:{active: activeStream() == 'twitter'}">Twitter News</a>
				<a href="#" class="list-group-item" data-bind="click: changeStream.bind($data, 'facebook'), css:{active: activeStream() == 'facebook'}">Facebook News</a>
			</div><!--/list-group-->
		</div><!--/sidebar-->
	</div><!--/row-->
</div><!--/.container-->	
<script type="text/javascript">
	SampleSite =
	{
		Page:
		{
			Init: function()
			{
				VoiceStorm.currentUser().then(SampleSite.Page.downloadStreams()).fail(SampleSite.UserNotSignedIn);
			},
			downloadStreams: function()
			{
				$('.stream').VoiceStormStream({ stream: 'current' });
				var AppViewModel = 
				{
					activeStream: ko.observable('current'),
				    showShowCase: ko.observable(true),
				    showcasePosts: ko.observableArray([]),
				    streamPosts: ko.observableArray([]),
				    changeStream: function(streamValue) 
				    {	
				    	if(streamValue=="current")
				        {
				        	$('.stream').VoiceStormStream('option', 'stream', streamValue);
							$('.stream').VoiceStormStream('refresh');
				   		}	
				    	else
				        {
				        	$(".stream").empty();
				          	VoiceStorm.stream({name: streamValue, take: 5, include:'images'}).then(function(socialStream)
							{
								AppViewModel.streamPosts(socialStream.posts);
								var $streamElement = $('.container-stream-widget .stream');
								$.each(socialStream.posts, function (index, post)
								{
									var $socialPost = $('<div>').addClass('socialPost').VoiceStormRenderPost({ post: post, includeShareButton: true, includeShareButtonStats: true, imgSize: "Box100"});
									$streamElement.append($socialPost);
								});
							});
				        }
				        var isShow = (streamValue == 'current'?true:false);
				        AppViewModel.showShowCase(isShow);
				        AppViewModel.activeStream(streamValue);
				    }
				};
				VoiceStorm.stream({name: 'Showcase', take: 5, include:'images'}).then(function(stream)
				{
					AppViewModel.showcasePosts(stream.posts);
					var $carousel = $('#carousel .carousel-inner');
					$.each(stream.posts, function (index, post)
					{
						var $item = $('<div>').addClass('item').VoiceStormRenderPost({ post: post, includeShareButton: true, includeShareButtonStats: true });
						if (!index) $item.addClass('active');
						$carousel.append($item);
					});
				});
    			ko.applyBindings(AppViewModel);
   				SampleSite.lightBoxContainer();
			}
		}
	}
</script>
<?php include 'footer.php'; ?>