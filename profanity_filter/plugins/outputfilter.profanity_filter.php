<?php
function template_outputfilter_profanity_filter($output, &$smarty)
{
	$wordlist = "anus|arse|ass|ballsack|bastard|bitch|biatch|blowjob|blow job|bollock|bollok|boner|bum|buttplug|clitoris|cock|coon|cunt|damn|dildo|dyke|fag|feck|fellate|fellatio|felching|fuck|f u c k|fudgepacker|fudge packer|Goddamn|God damn|jizz|labia|muff|nigger|nigga|penis|prick|pube|queer|scrotum|sex|shit|sh1t|slut|smegma|tosser|twat|vagina|whore";
	return preg_replace("/\b($wordlist)\b/ie", 'preg_replace("/./","*","\\1")', $output);
}
?> 