	<!-- Login -->
	<div id="login">
		<div class="loginContent">
			<form action="{$URL_login}" method="post">
				<label for="log"><b>{#PLIGG_Visual_Login_Username#}: </b></label>
				<input class="field" type="text" name="username" id="log" size="23" />
				<br />
				<label for="pwd"><b>{#PLIGG_Visual_Login_Password#}:</b></label>
				<input class="field" type="password" name="password" class="login" id="pwd" size="23" />
				<label for="rememberme">{#PLIGG_Visual_Login_Remember#}: </label>
				<div class="left">
				<input name="persistent" id="rememberme" class="rememberme" type="checkbox" checked="checked" /> 
				</div>
				<input type="hidden" name="processlogin" value="1"/>
				<input type="hidden" name="return" value="{$templatelite.get.return|sanitize:3}"/>
				<input type="submit" name="submit" value="" class="button_login" />
			</form>

			<div class="left"><Br /><Br />Not a member? <a href="./register.php">{#PLIGG_Visual_Register_Register#}</a> | <a href="./login.php">{#PLIGG_Visual_Login_ForgottenPassword#}?</a></div>
		</div>
		<div class="loginClose"><a href="#" id="closeLogin">Close Login</a></div>
	</div> <!-- /login -->
	<div id="search">
		<div class="searchContent">
			{if isset($templatelite.get.search)}
				{assign var=searchboxtext value=$templatelite.get.search|sanitize:2}
			{else}
				{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
			{/if}
		
			{if $SearchMethod eq 4}
				<!-- SiteSearch Google -->
				<form method="get" action="{$my_base_url}{$my_pligg_base}/search.php" target="_top">
					<label for="sbi" style="display: none">"{$searchboxtext}</label>
					<input name="q" type="text" size="15" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}" />
					<label for="sbb" style="display: none">{#PLIGG_Visual_Search_Go#}</label>
					<input type="submit" name="sa" value="" class="button_search" />

					<input type="hidden" name="sitesearch" value="{$my_base_url}{$my_pligg_base}" id="ss1"></input>

					<input type="hidden" name="flav" value="0002"></input>
					<input type="hidden" name="client" value="pub-7688534628068296"></input>
					<input type="hidden" name="forid" value="1"></input>
					<input type="hidden" name="ie" value="ISO-8859-1"></input>
					<input type="hidden" name="oe" value="ISO-8859-1"></input>
					<input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:11"></input>
					<input type="hidden" name="hl" value="en"></input>
				</form>
				<!-- SiteSearch Google -->				
			{else}
				<form action="{$my_pligg_base}/search.php" method="get" name="thisform-search" id="thisform-search">
					<input type="text" size="25" class="searchfield" name="search" id="searchsite" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}"/>
					<input type="submit" value="" class="button_search" />
				</form>
				<div class="clear"></div>
			{/if}
		</div>
		<div class="searchClose"><a href="#" id="closeSearch">Close Search</a></div>
	</div> 

    <div id="container">
		<div id="top">
		<!-- login -->
			<ul class="login">
		    	<li class="left">&nbsp;</li>
		         <li><a id="toggleSearch" href="#">Search</a></li>
				<li>|</li>
				<li><a id="toggleLogin" href="#">Log In</a></li>
			</ul> <!-- / login -->
		</div> <!-- / top -->

        <div class="clearfix"></div>

	</div><!-- / container -->