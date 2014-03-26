<?php $title="Post"; include 'header.php'; ?>
<div class="container">
	<div id="renderpost"></div>
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
</div>

<script type="text/javascript">
	SampleSite =
	{
		Page:
		{
			Init: function()
			{
				VoiceStorm.currentUser().then(SampleSite.Page.renderPost()).fail(SampleSite.UserNotSignedIn);
			},
			renderPost: function()
			{
				var postId = purl().param('id');
				if(!postId)
				{
					SampleSite.UserNotSignedIn();
				}
				else
				{
					SampleSite.headerBindings();
					$('#renderpost').VoiceStormRenderPost(
					{
						postId: postId,
						includeShareButton: true
					});
					SampleSite.lightBoxContainer();
				}
			}
		}
	}
</script>
<?php include 'footer.php'; ?>