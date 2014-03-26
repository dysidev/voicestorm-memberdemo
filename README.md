#Introduction

VoiceStorm is a platform that allows you to create advocacy communities for a brand, organization, or cause. Community managers source and distribute approved content to members. Members share the content on their social channels, thereby amplifying the brand message. Learn more at http://www.dynamicsignal.com.

##Purpose of this test package:
While you can use the stock VoiceStorm member hub with any VoiceStorm community, many organizations want to use the VoiceStorm APIs (documented at [dev.voicestorm.com](http://dev.voicestorm.com)) to create a custom hub, with their own branding and layout, hosted on their own site. This test package is intended to help you do just that.

The objective of this guide is to get a custom VS site up and running. Every VS instance has three components:

<ol>
<li>The VS instance itself, which includes all services, the Public API access, etc.</li><li>A manager app, which allows the manger to configure and run the community on a day-to-day basis.</li><li>A member app, which you will build using the VS APIs.</li>
</ol>

This test package includes a member app (https://www.publicmemberdemo.com/) that is pointed at a test instance of VoiceStorm (https://publicmanagerdemo.voicestorm.com). You can use this test package to get a live environment up and running, and to make sure it is configured properly. Also, you can use it as an example/guide when building your member hub the way you actually want it.

##Try out the sample site:

Before getting started with the code, create an account for yourself on the sample site: https://www.publicmemberdemo.com.

<ol>
<li>Go to the Sign Up page.</li>
<li>Sign up with email, Facebook, or Twitter.</li>
<li>Once you create your account and log in, you will land on the news feed page.</li>
<ol>
<li>The main part of the newsfeed shows content.</li>
<li>The sidebar allows you to see content from Facebook and Twitter.</li>
</ol><li>Go to your profile page.</li>
<ol><li>This is accessible from the dropdown arrow next to your name in the header on the left hand side.</li>
<li>URL: https://www.publicmemberdemo.com/profile.php</li>
<li>Explore the bio, photo, channels, and settings tabs.</li>
<li>Be sure to connect one or more social channels so that you can share content.</li>
  </ol>
<li>Go back to the news feed and try sharing a few posts.</li>
<li>Go look at the leaderboard (link in the header).</li>
<li>Finally, try submitting your own post.</li>
<ol>
<li>Note that you won’t be able to see your submitted post until someone publishes it, so don’t spend a lot of time on it.
</ol>
</ol>

##Download, install, and run your own instance of the sample site:

To get your own instance of the member app running, you will need to download the sample code and modify it to point at your own VoiceStorm instance.  The guide below will walk you through this process in 5 steps:

1.    **Set up your webserver** to run the member hub and install the test package. Once installed properly, the test member hub will run against the test VS instance.
2.	Contact Dynamic Signal and **get your own VS instance** and API credentials.
3.	**Make configurations** to your VS instance in the manager app.
4.	Modify the test package in order to **point it at your new VS instance.**
5.	**Test it!**

The sample site is built using widgets, JavaScript SDK, and limited use of of REST APIs to make authentic calls to the server.  Further reference docs and required documentation are available at http://dev.voicestorm.com/.  Once you go through this guide, you should have enough background to build your own member hub.

###Step 1: Set up webserver/environment

<ol>
<li>Install WAMP, or comparable webserver.</li>
<ol>
<li>Actual requirements are:</li>
<ol>
<li>Webserver</li>
<li>PHP</li>
<li>CURL</li>
<li>HTTPS cert</li>
</ol><li>No database is required</li>
</ol><li>Test the environment:</li>
<ol>
<li>Ensure CURL is installed.</li>
<li>Ensure PHP is installed.</li>
</ol><li>Save “samplesite” directory into the WAMP file structure.</li>
</ol>

You should now be able to run the code against our test VS instance. Try it by opening up your install location in a browser. Next, let’s get you set up on your own VoiceStorm instance.

###Step 2: Obtain your VoiceStorm instance

You will need to contact DS and request an instance of VoiceStorm with API access.  Be sure you get the following from the DS rep:

<ol>
<li>URL for the new community (<i>example</i>.voicestorm.com)</li>
<li>The Admin -> API should be visible in the manager application (<i>example</i>.voicestorm.com/manage/api), and this information should be available in that tab:</li>
<ol>
<li>Access Token</li>
<li>Manager login credentials</li>
<li>Token Secret</li>
<li>REST API Base URL</li>
<li>VoiceStorm JS SDK URL</li>
</ol>
</ol>

###Step 3: Configure your new VoiceStorm community

1.  **Set Up API**
    2. 	At Admin -> API (*example*.voicestorm.com/manage/api) make the following changes:

| API Settings | URL | Explanation |
| ------------ | ---- | -----------|
| Trusted API Domains |    *[example.com] | Domain whitelist. | 
| Post Routing URL  |  http://[example.com]/samplesite/renderpost.php?id=$id | Landing page for In-App posts |
| Reset Password URL    | http://[example.com]/samplesite/reset.php?code=$code | Appears in a "reset password" email |
| Registration URL | http://[example.com]/samplesite/index.php | User is redirected to this link when registering
|Community Homepage URL | http://[example.com]/samplesite/ | Appears in the "Welcome" email sent to a new user. |

<ol>
<li><b>Connect Feeds</b></li>
<ol>
<li>VoiceStorm provides two mechanisms to stock the community with content.</li>
<li>Direct user submissions.</li>
<li>Feeds, eg.</li>
<ol>
<li>RSS</li>
<li>Facebook Page</li>
<li>Twitter</li>
</ol><li>Once feeds are attached, the community will import posts from these feeds and display them to members for sharing.</li></ol>


<li><b>Set Up Streams</b></li>
<ol>
<li>Streams control content organization throughout the member hub.</li>
<li>All content that appears on the home page is fed by a particular stream:</li>
<ol>
<li>Current</li>
<li>Showcase</li>
<li>Twitter</li>
<li>Facebook</li>
</ol>
</ol>
</ol>

###Step 4: Modify test package to point at your own VoiceStorm instance

Download the code to your machine, and make the following changes, using tokens and URLs found at Admin -> API (*example*.voicestorm.com/manage/api).

<table>
<tr>
<th>File</th>
<th>Code Line</th>
<th>From API Page</th>
</tr>
<tr>
<td>js/main.js</td>
<td>js.src</td>
<td>VoiceStorm JS SD</td>
</tr>
<tr>
<td rowspan="3">config.php</td>
<td>$ACCESS</td>
<td>Access Token</td>
<tr>
<td>$SECRET</td>
<td>Token Secret
</tr>
<tr>
<td>$BASE_URL</td>
<td>REST API Base URL</td>
</tr>
<tr>
<td>Channel.html</td>
<td>script src</td>
<td>VoiceStorm JS SDK</td>
<tr>
<td>/claim/js/claim.js</td>
<td>js.src</td>
<td>VoiceStorm JS SD</td>
</tr>
<tr>
<td rowspan="3">/claim/config.php</td>
<td>$ACCESS</td>
<td>Access Token</td>
<tr>
<td>$SECRET</td>
<td>Token Secret
</tr>
<tr>
<td>$BASE_URL</td>
<td>REST API Base URL</td>
</tr>
</table>

**Examples**

```javascript
js.src = 'https://[example].voicestorm.com/v1/voicestorm.js';
```

```php
$ACCESS="XXXXXXXXXXXXXXXXXXXX";
$SECRET= "XXXXXXXXXXXXXXXXXXXX";
$BASE_URL="https://[example].voicestorm.com/v1";
```

```html
<script src="http://[example].voicestorm.com/v1/voicestorm.js"></script>
```

####Registration and Log-In

VoiceStorm provides two registration options:

<table>
<tr>
<th>Public Sign Up</th>
<th>Claim Account</th>
<tr>
<td>
<ul>
<li>Any user may sign up for an account at any time.</li>
</ul>
</td>
<td>
<ul>
<li>Only users with an approved email address or email domain (i.e. “whitelisted”) may sign up.</li>
<li>The Claim Account page allows users to enter an email address.  If whitelisted, the user receives an email with a registration link.</li>
<li>Community managers can also invite users directly via email at any time.</li>
</ul>
</td>
</tr>
</table>

In order to test registration in Claim Account mode, the following additional changes are required:

**At Admin -> API (example.voicestorm.com/manage/api)**

<table>
<tr>
<th>API Settings</th>
<th>URL</th>
</tr>
<tr>
<td>Invitation URL</td>
<td>http://[example.com]/samplesite/claim/registerform.php?code=$code</td>
</tr>
<tr>
<td>Community Homepage URL</td>
<td>http://[example].com/samplesite/claim/</td>
</tr>
</table>

###Step 5: Testing

Please test the following functions

<ol>
<li>Register:</li>
<ol>
<li>For public spheres, via http://[example.com]/samplesite/</li>
<li>For Claim Account spheres, via http://[example.com]/samplesite/claim/ (all other activity can be tested at the root directory).</li></ol>
<li>Send a broadcast email.</li>
<ol>
<li>Utilize the View and Share options from the email</li></ol>
<li>Reset password.</li>
<li>Make sure to exercise all of the above-listed routing URLs.</li>
</ol>

**Have any questions?**

We are eager to hear them. Email us at [info@dynamicsignal.com](mailto:info@dynamicsignal.com)
