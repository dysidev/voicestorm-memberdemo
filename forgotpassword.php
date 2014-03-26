<?php $title="Forgot Password"; include 'header.php'; ?>
<div class="container">
	<form class="form-horizontal" role="form">
		<legend>Confirm Email address of the account</legend>
		<div class="form-group">
			<div class="col-sm-6">We will send instructions to the email address associated with your account. </div>
		</div>
		<div id="alertMessage" class="alert"></div>
		<div class="form-group">
			<label for="forgotPasswordEmail" class="col-sm-2 control-label">Email Address</label>
			<div class="col-sm-6">
		  		<input type="email" class="form-control" id="forgotPasswordEmail" placeholder="Confirm Email Address" data-bind="value: forgotPasswordEmail">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-6">
		  		<button class="btn btn-primary" data-bind="click: btnSendInstructions">Send Instructions</button>
			</div>
	  	</div>
	</form>
</div><!--/.container-->
<script type="text/javascript">
	SampleSite =
	{
		Page:
		{
			Init: function()
			{
				VoiceStorm.currentUser().then(SampleSite.UserSignedIn).fail(SampleSite.Page.forgotPassword());
			},
			forgotPassword: function()
			{
				var AppViewModel = 
				{
					forgotPasswordEmail: ko.observable(),
					btnSendInstructions: function()
					{
						options={email:AppViewModel.forgotPasswordEmail()};
                        VoiceStorm.api("POST", "login/forgotpassword", options).then(function (result)
                        {
                            SampleSite.alertMessage("alertMessage","success","Check your email account now for the instructions to create a new password");
                            AppViewModel.forgotPasswordEmail("");  
                        }).fail(function (er)
                        {
                            SampleSite.alertMessage("alertMessage", "danger", er.messages);
                        }); 
					}
				}
				ko.applyBindings(AppViewModel);
			}
		}
	}
</script>
<?php include 'footer.php'; ?>