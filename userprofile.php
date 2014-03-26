<?php $title="User Profile"; include 'header.php'; ?>
    	<div class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
  					<img id="userImg" alt="No Picture"/>&nbsp;
  					<h3><span id="displayName"></span><span id="userLocation"></span></h3>
  				</div>
	  			<ul class="list-group">
				    <li class="list-group-item"><label>Title:&nbsp;</label><span id="userTitle"></span></li>
				    <li class="list-group-item"><label>About Me:&nbsp;</label><span id="userAbout"></span></li>
				    <li class="list-group-item"><label>Points:&nbsp;</label><span id="points"></span></li>
				    <li class="list-group-item"><label>Email:&nbsp;</label><span id="userEmail"></span></li>
				    <li class="list-group-item"><label>Organization:&nbsp;</label><span id="userOrgName"></span></li>
	  			</ul>
			</div>
		</div>
<script type="text/javascript">
	SampleSite =
	{
		Page:
		{
			Init: function()
			{
				VoiceStorm.currentUser().then(SampleSite.Page.userProfile()).fail(SampleSite.UserNotSignedIn);
			},
			userProfile: function()
			{
				var profileId = purl().param('id');
				if(!profileId)
				{
					SampleSite.UserNotSignedIn();
				}
				else
				{
					SampleSite.headerBindings();
					VoiceStorm.user({id: profileId, include:"channels", include: "images"}).then(function (user)
					{
						if(user.profilePictureImages) $('#userImg').attr('src', user.profilePictureImages.Square80.url);
						else $('#userImg').attr('src', "imgs/default80.jpg");
						$("#displayName").html(user.displayName);
						if(user.location) $("#userLocation").html(' ('+user.location+')');
						$("#userAbout").html(user.aboutMe);
						$("#points").html(user.pointBalance);
						$("#userEmail").html(user.email);
						$("#userOrgName").html(user.organizationName);					
						$('#userTitle').html(user.title);
					});
				}
			}
		}
	}
</script>
<?php include 'footer.php'; ?>