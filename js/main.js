SampleSite = $.extend(window.SampleSite || {},
{
	InitVoiceStormDefaults: function()
	{
		url=document.URL;
        url = url.substring(0, url.lastIndexOf("/"));
		VoiceStorm.defaults.channelUrl = url+"/channel.html";
		VoiceStorm.defaults.profileLinkFormat = url+"/userprofile.php?id=$id";
		VoiceStorm.defaults.shareDialogLightboxContainer = '#share-modal-sharepost-container';

        VoiceStorm.currentUser().then(function(user)
        {
            if(window.location.pathname !='/welcome.php')
            {
                SampleSite.headerHelpers.showHeader(true);
                SampleSite.headerHelpers.userDisplayName(user.displayName);
            }
        });
	},
	UserNotSignedIn: function()
	{
		window.location.href="index.php";
	},
	UserSignedIn: function()
	{
		window.location.href = "home.php";
	},
    UserWelcome: function()
    {
        window.location.href="welcome.php";   
    },
    headerHelpers:
    {
        showHeader: ko.observable(false),
        userDisplayName: ko.observable(),
        btnLogout: function()
        {
            VoiceStorm.logout().then(SampleSite.UserNotSignedIn()).fail( function (error)
            {
              SampleSite.alertMessage("alertMessage", "danger", "Failed to logout");
            });
        }
    },
    alertMessage: function(id,status,message)
    {
        $('#'+id).addClass("alert-"+status);
        $("#"+id).text(message);
        $('#'+id).fadeIn("fast");
        $('#'+id).fadeOut(1500, function() {
            $("#"+id).removeClass("alert-"+status);
        });
    },
    tabSelector: function()
    {
        var pageURL=document.URL;
        var pageLink=pageURL.substring(pageURL.lastIndexOf('/')+1);
        $('.header-list a[href="'+pageLink+'"]').parent().attr('class', 'active'); 
    },
    lightBoxContainer: function()
    {
        VoiceStorm.jQuery('#share-modal-sharepost-container')
        .on('show.voicestorm.sharepost', function (e)
        {
            $('#share-modal-sharepost-container').empty();
            $('#share-modal-loading').show();
            $('#share-modal').modal('show');
        })
        .on('shown.voicestorm.sharepost', function (e)
        {
            $('#share-modal-loading').hide();
        })
        .on('shared.voicestorm.sharepost', function (e)
        {
            var id = e.detail;
            VoiceStorm.api('GET', 'postcomment/' + id).then(function (postcomment)
            {
                // Update page with new post comment
            })
        })
        .on('closed.voicestorm.sharepost', function (e)
        {
            $('#share-modal').modal('hide');
        });
    },
    headerBindings: function()
    {
        var AppViewModel=
        {
        }
        ko.applyBindings(AppViewModel);
    }

});

function VoiceStormAsyncInit() 
{
    SampleSite.InitVoiceStormDefaults();
    if (SampleSite.Page && SampleSite.Page.Init) SampleSite.Page.Init();
}
(function (d, s, id) // loads the SDK asynchronously 
{ 
    var js, fjs = d.getElementsByTagName(s)[0]; 
    if (d.getElementById(id)) { return; } 
    js = d.createElement(s); js.id = id; 
    js.src = 'https://publicmanagerdemo.voicestorm.com/v1/voicestorm.js'; 
    fjs.parentNode.insertBefore(js, fjs); 
}(document, 'script', 'voicestorm-sdk'));