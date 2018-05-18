<script>
var myNewURL = refineURL();
window.history.pushState("object or string", "Title", "/" + myNewURL );
  function refineURL()
{
    //get full URL
    var currURL= window.location.href; //get current address

    //Get the URL between what's after '/' and befor '?' 
    //1- get URL after'/'
    var afterDomain= currURL.substring(currURL.lastIndexOf('/') + 1);
    //2- get the part before '?'
    var beforeQueryString= afterDomain.split("?")[0];  

    return beforeQueryString;     
} 
</script>
</head>
<body>
	<header>
		<div class="hd-top">
			<div class="hd-logo">
				<a ><div class="logo"></div></a>
			</div>
			<div class="hd-search-bar">
				<div class="search-bar">
					<input type="text" name="q" class="search-input" value="<?php echo $_GET['sub3'];?>"></input>
				</div>
				<div class="search-box">
					<div class="s-box"></div>
				</div>
			</div>
			<div class="sign-in">
				<div class="apps-icon"></div>
				<button class="btn-sign-in">Sign in</button>
			</div>
		</div>
		<div class="hd-bottom">
			<div>
				<div class="left-blnk"></div>
				<div class="menu">
					<ul>
						<li class="menu-first"><a  style="color: #4285f4;">Web</a></li>
						<li style="width: 70px; padding-left: 5px;"><a >News</a></li>
						<li><a >Shopping</a></li>
						<li style="width: 67px; padding-left: 5px;"><a >Videos</a></li>
						<li><a >Images</a></li>
						<li style="width: 69px; padding-right: 10px;"><a >More<img src="/assets/images/down-arrow.png" style="padding-left: 3px;"></a></li>
						<li><a >Search tools</a></li>
					</ul>
				</div>
			</div>
			<div style="float: right; margin-right: 28px;">
				<button class="btn-settings"><span class="settigns-icon"></span></button>
			</div>
		</div>
	</header>

	<div style="padding-left: 126px;">
		<div class="result-time">About 99,700,000 results (0.32 seconds) </div>
		<div class="left-side-bdy">
