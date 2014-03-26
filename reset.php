<?php $title="Reset Password"; include 'header.php'; ?>
<div class="container">
	<form class="form-horizontal" role="form">
		<legend>Reset Password</legend>
		<div class="form-group">
			<div class="col-sm-6">Create a new password for your account.</div>
		</div>
		<div id="alertMessage" class="alert"></div>
	  	<div class="form-group">
			<label for="claimRegPassword" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-6">
			  <input type="password" class="form-control" id="resetPassword" placeholder="Password" data-bind="value: resetPassword">
			</div>
	  	</div>
	  	<div class="form-group">
			<label for="claimConfirmPassword" class="col-sm-2 control-label">Confirm Password</label>
			<div class="col-sm-6">
			  <input type="password" class="form-control" id="confirmResetPassword" placeholder="Confirm Password" data-bind="value: confirmResetPassword">
			</div>
	  	</div>
	  	<div class="form-group">
			<div class="col-sm-offset-2 col-sm-6">
		  		<button type="submit" class="btn btn-primary" data-bind="click: savePassword">Save Password</button>
			</div>
	  	</div>
	</form>
</div><!--/container-->
<script type="text/javascript">
    SampleSite =
    {
        Page:
        {
            Init: function()
            {
                VoiceStorm.currentUser().then(SampleSite.UserSignedIn).fail(SampleSite.Page.resetPassword());
            },
            resetPassword: function()
            {
            	var tokenValue = purl().param('code');
            	if(!tokenValue)
				{
					SampleSite.UserNotSignedIn();
				}
				else
				{
					var AppViewModel=
					{
				        resetPassword: ko.observable(""),
				        confirmResetPassword: ko.observable(""),               	
				        isValid: function()
				        {
				            if((AppViewModel.resetPassword() !== "") && (AppViewModel.confirmResetPassword() !== ""))
				            {
				                if(AppViewModel.resetPassword() !== AppViewModel.confirmResetPassword())
				                {
				                    SampleSite.alertMessage("alertMessage","danger","Passwords do not match");
				                    return false;
				                }
				                else
				                {
				                    return true;
				                }
				            }
				            else 
				            {
				                SampleSite.alertMessage("alertMessage", "danger", "Please fill the required fields");                
				                return false;
				            }
				        },
				        savePassword: function()
				        {
				            if(AppViewModel.isValid())
				            {
				            	options={token:tokenValue, newPassword: AppViewModel.resetPassword()};
                				VoiceStorm.api("POST", "login/resetpassword", options).then(function (result)
                				{
				                	SampleSite.alertMessage("alertMessage", "success", "Password changed successfully");
				                	AppViewModel.resetPassword("");
				                	AppViewModel.confirmResetPassword("");

				            	}).fail(function (err)
				            	{
				            		if(err.code=="invalid_request" && err.messages=="Token is invalid") 
				            		{
				            			SampleSite.alertMessage("alertMessage", "danger", "Please re-enter your email address and send the instructions again.");

				            		}
  				            		else SampleSite.alertMessage("alertMessage", "danger", "please try again");
				            	});
				        	}
				    	}
	            	}
	            	ko.applyBindings(AppViewModel);
            	}
        	}
    	}
    }
</script>
<?php include 'footer.php'; ?>