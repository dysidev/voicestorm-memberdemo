<?php $title="Index"; include 'header.php'; ?>
<div class="container">
	<div class="index-content">
		<ul class="nav nav-tabs nav-justified">
				<li class="active"><a href="#signIn" data-toggle="tab">Sign In</a></li>
				<li><a href="#signUp" data-toggle="tab">Sign Up</a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div id="alertMessage" class="alert"></div>
				<div class="tab-pane active" id="signIn">
					<form class="form-horizontal" role="form">
				  	<div class="form-group">
						<label for="loginEmail" class="col-sm-2 control-label">Email Address</label>
						<div class="col-sm-6">
						  <input type="email" class="form-control" id="loginEmail" placeholder="Email" data-bind="value: userName">
						</div>
				  	</div>
				  	<div class="form-group">
						<label for="loginPassword" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-6">
						  <input type="password" class="form-control" id="loginPassword" placeholder="Password" data-bind="value: userPassword">
						</div>
				  	</div>
				  	<!--<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
							<div class="checkbox">
								<label><input type="checkbox"> Remember me</label>
						  	</div>
						</div>
				  	</div>-->
				  	<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
					  		<button class="btn btn-primary" data-bind="click: btnLogin">Log in</button>
						</div>
				  	</div>
				  	<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
					  		<a href="forgotpassword.php">Trouble signing in?</a>
						</div>
				  	</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"> Sign in with </label>
						<div class="col-sm-6">
							<button class="facebook" data-bind="click: btnSocial.bind($data, 'Facebook')">Facebook</button>
							<button class="twitter" data-bind="click: btnSocial.bind($data, 'Twitter')">Twitter</button>
						</div>
					</div>
				</form>
				</div>
				<div class="tab-pane" id="signUp">
					<form class="form-horizontal" role="form">
				  	<div class="form-group">
						<label for="regEmail" class="col-sm-2 control-label">Email Address</label>
						<div class="col-sm-6">
						  <input type="email" class="form-control" id="regEmail" placeholder="Email" data-bind="value: regEmail">
						</div>
				  	</div>
				  	<div class="form-group">
						<label for="regPassword" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-6">
						  <input type="password" class="form-control" id="regPassword" placeholder="Password" data-bind="value: regPassword">
						</div>
				  	</div>
				  	<div class="form-group">
						<label for="confirmPassword" class="col-sm-2 control-label">Confirm Password</label>
						<div class="col-sm-6">
						  <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" data-bind="value: confirmPassword">
						</div>
				  	</div>
				  	<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
							<div class="checkbox">
								<label><input type="checkbox"  data-bind="checked: regTerms">I agree to the <a href="#" data-toggle="modal" data-target="#confirmModal">Terms of Service and Privacy Policy</a></label>
						  	</div>
                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Terms and Conditions</h4>
                          </div>
                          <div class="modal-body">Here goes terms and conditions.</div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>
              </div>
						</div>
				  	</div>
				  	<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
					  		<button class="btn btn-primary" data-bind="click: btnReg">Sign Up</button>
						</div>
				  	</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"> Sign Up with </label>
						<div class="col-sm-6">
							<button class="facebook" data-bind="click: btnRegSocial.bind($data, 'Facebook')">Facebook</button>
							<button class="twitter" data-bind="click: btnRegSocial.bind($data, 'Twitter')">Twitter</button>
						</div>
					</div>
				</form>
				</div>
		</div>
	</div>
</div><!--/container-->
<!--<hr>
<footer>
	<p>&copy; Dynamic Signal 2013</p>
</footer>-->
<script type="text/javascript">
	SampleSite =
	{
		Page:
		{
			Init: function()
			{
				VoiceStorm.currentUser().then(SampleSite.UserSignedIn).fail(SampleSite.Page.userSign());
			},
			userSign: function()
			{
				var AppViewModel = 
				{
					userName: ko.observable(),
					userPassword: ko.observable(),
			        regEmail: ko.observable(""),
			        regPassword: ko.observable(""),
			        confirmPassword: ko.observable(""),
			        regTerms: ko.observable(false),
					btnSocial:  function(param)
					{
						VoiceStorm.socialLogin(param).then(SampleSite.UserSignedIn).fail(function(error)
						{
							SampleSite.alertMessage("alertMessage","danger","Invalid login");		
						});
					},
					btnLogin: function()
					{
					    VoiceStorm.login(AppViewModel.userName(), AppViewModel.userPassword()).then(function (user) {
					        if (user.status == "New" && user.email) {
					            SampleSite.UserWelcome();
					        }
					        else {
					            SampleSite.UserSignedIn();
					        }
					    }).fail(function(error)
						{
							SampleSite.alertMessage("alertMessage","danger","Invalid login");
						});
					},
			        isValid: function()
			        {
			            if((AppViewModel.regEmail()!== "") && (AppViewModel.regPassword() !== "") && (AppViewModel.confirmPassword() !== ""))
			            {
			                if(AppViewModel.regPassword() === AppViewModel.confirmPassword())
			                {
			                    if(AppViewModel.regTerms()=== true)
			                    {
			                        return true;
			                    }
			                    else
			                    {
			                       SampleSite.alertMessage("alertMessage","danger","You must accept the Terms of Service and Privacy Policy before you can continue");
			                       return false; 
			                    }
			                }
			                else
			                {
			                    SampleSite.alertMessage("alertMessage","danger","Passwords do not match");
			                    return false;
			                }
			            }
			            else 
			            {
			                SampleSite.alertMessage("alertMessage", "danger", "Please fill the required fields");                
			                return false;
			            }
			        },
			        btnReg: function()
			        {
			            if(AppViewModel.isValid())
			            {
			                $.ajax(
			                {
			                    url: 'register.php',
			                    type: 'POST',
			                    dataType: 'json',
			          			data: {'email' : AppViewModel.regEmail(), 'password' : AppViewModel.regPassword()}
			                }).then(function(response)
			                { 
			                    if(response.result === 'error') SampleSite.alertMessage("alertMessage", "danger", response.msg); 
			                    else if (response.result === 'success')
			                    {
			                        VoiceStorm.loginWithToken(response.token, response.expiration).then(function()
			                        {
			                            VoiceStorm.currentUser().then(function () {
			                                SampleSite.UserWelcome();
			                            }).fail(SampleSite.UserNotSignedIn);
			                        }).fail(SampleSite.UserNotSignedIn);
			                    }
			                }).fail(function() 
			                { 
			                   SampleSite.alertMessage("alertMessage", "danger", "Please check your internet connection"); 
			                });
			            }
			        },
			        btnRegSocial: function(param)
			        {
			            VoiceStorm.socialRegister(param).then(SampleSite.UserWelcome).fail(function (error)
			            {
			                SampleSite.alertMessage("alertMessage","danger","Cannot Register");  
			            });
			        }
				}
				ko.applyBindings(AppViewModel); 
			}
		}
	}
</script>
<?php include 'footer.php'; ?>