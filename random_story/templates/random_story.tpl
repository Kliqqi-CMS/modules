
<div class="featurebox">	
<div class="tlb">
{php}
	echo "<span><a onclick=\"new Effect.toggle('randomstory','blind', {queue: 'end'}); \"> <img src=\"".my_pligg_base."/templates/".The_Template."/images/expand.png\" alt=\"expand\" /></a></span>";
{/php}

<a href="#">Random Story</a>

</div>

<div id="randomstory">
		{if $random_story_randstoryurl neq ""}
			<a href = "{$random_story_randstoryurl}">Random Story</a>
		{else}
			There are no published stories!
		{/if}	
</div>
</div>
