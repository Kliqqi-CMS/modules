{literal}
    <style>
    #openid{
        border: 1px solid gray;
        display: inline;
    }
    #openid, #openid INPUT{
        font-family: "Trebuchet MS";
        font-size: 12px;
    }
    #openid LEGEND{
        1.2em;
        font-weight: bold;
        color: #FF6200;
        padding-left: 5px;
        padding-right: 5px;
    }
    #openid INPUT.openid_login{
       background: url(imgs/3rdparty/openid-login-bg.gif) no-repeat;
       background-color: #fff;
       background-position: 0 50%;
       color: #000;
       padding-left: 18px;
       width: 220px;
       margin-right: 10px;
    }
    #openid A{
    color: silver;
    }
    #openid A:hover{
        color: #5e5e5e;
    }
</style>
{/literal}

<div>
	<fieldset id="openid">
		<legend>OpenID Login</legend>
		<form action="{$my_pligg_base}/module.php?module=openid" method="post" onsubmit="this.login.disabled=true;">
			<input type="hidden" name="openid_action" value="login">
			<div><input type="text" name="openid_url" class="openid_login"><input type="submit" name="login" value="login &gt;&gt;"></div>
			<div><a href="http://www.myopenid.com/" class="link" >Get an OpenID</a></div>
		</form>
	</fieldset>
</div>

<div style="margin-top: 2em; font-family: arial; font-size: 0.8em; border-top:1px solid gray; padding: 4px;">Sponsored by: <a href="http://www.fivestores.com">FiveStores</a> - get your free online store; includes extensive API for developers; <i style="color: gray;">integrated with  <a href="http://en.wikipedia.org/wiki/OpenID">OpenID</a></i></div>
