SampleSite = $.extend(window.SampleSite || {},
{
    UserNotSignedIn: function()
    {
        window.location.href="index.php";
    },
    UserSignedIn: function()
    {
        window.location.href="home.php";
    },
    UserWelcome: function()
    {
        window.location.href="../welcome.php";
    },
    alertMessage: function(id,status,message)
    {
        $('#'+id).addClass("alert-"+status);
        $("#"+id).text(message);
        $('#'+id).fadeIn("fast");
        $('#'+id).fadeOut(1500, function() {
            $("#"+id).removeClass("alert-"+status);
        });
    }
});

function VoiceStormAsyncInit() 
{
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