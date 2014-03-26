<?php $title="Home"; include 'header.php'; ?>
<div class="container">
	<legend>Welcome</legend>
	<span id="userDisplayName" data-bind="text: userDisplayName"></span>
	<a href="#" class="btn btn-primary pull-right" data-bind="click: btnLogout">Logout</a>
</div><!--/container-->

<script type="text/javascript">
    SampleSite =
    {
        Page:
        {
            Init: function()
            {
                VoiceStorm.currentUser().then(SampleSite.Page.welcome()).fail(SampleSite.UserNotSignedIn);
            },
            welcome: function()
            {
                var AppViewModel=
                {
                    userDisplayName: ko.observable(),
                    btnLogout: function()
                    {
                        VoiceStorm.logout().then(function ()
                        {
                            window.location.href="index.php";
                        }).fail( function (error)
                        {
                            SampleSite.alertMessage("alertMessage", "danger", "Failed to logout");
                        });
                    }
                }
                VoiceStorm.currentUser().then(function (user)
                {
                    AppViewModel.userDisplayName=user.displayName;
                }); 
                ko.applyBindings(AppViewModel);
            }
        }
    }
</script>
<?php include 'footer.php'; ?>