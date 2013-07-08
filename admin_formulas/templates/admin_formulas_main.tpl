{config_load file=admin_formulas_lang_conf}

{literal}
	<style type="text/css">
		.eip_editable { background-color: #ff9; padding: 3px; }
		.eip_savebutton { background-color: #36f; color: #fff; }
		.eip_cancelbutton { background-color: #000; color: #fff; }
		.eip_saving { background-color: #903; color: #fff; padding: 3px; }
		.eip_empty { color: #afafaf; }	
	</style>
{/literal}

<script type="text/javascript">
	Event.observe(window, 'load', init, false);
	function init() {ldelim}{foreach from=$editinplace_init_formulas item=html}{$html}{/foreach}{rdelim}
</script>

<fieldset>
	<legend><img src="{$my_pligg_base}/templates/admin/images/manage_formulas.gif" align="absmiddle" /> {#PLIGG_Admin_Formulas_Modify#}</legend>
	
	{if $templatelite.GET.type eq ''}
		<img src="{$my_pligg_base}/templates/admin/images/error.gif" align="absmiddle" /> <a href = "{$URL_admin_formulas}&type=report">{#PLIGG_Admin_Formulas_Reporting#}</a><br />
	{else}
		{if $templatelite.GET.action eq ''}
			<h4> {#PLIGG_Admin_Formulas_Existing#}</h4><br /><br />
			{section name=formula loop=$formulas}	
				
				{$formulas[formula].title}
				
				&nbsp;&nbsp;&nbsp;
				
				{if $formulas[formula].enabled eq 1}
				<img src="{$my_pligg_base}/templates/admin/images/formula_disable.gif" align="absmiddle" /> <a href = "{$URL_admin_formulas}&type={$templatelite.GET.type}&action=disable_formula&id={$formulas[formula].id}">{#PLIGG_Admin_Formulas_Disable#}</a>
				{else}
				<img src="{$my_pligg_base}/templates/admin/images/formula_enable.gif" align="absmiddle" /> <a href = "{$URL_admin_formulas}&type={$templatelite.GET.type}&action=enable_formula&id={$formulas[formula].id}">{#PLIGG_Admin_Formulas_Enable#}</a>
				{/if}
				&nbsp;&nbsp;&nbsp;
				<img src="{$my_pligg_base}/templates/admin/images/formula_edit.gif" align="absmiddle" /> <a href = "{$URL_admin_formulas}&type={$templatelite.GET.type}&action=edit_formula&id={$formulas[formula].id}">{#PLIGG_Admin_Formulas_Edit#}</a>				
				&nbsp;&nbsp;&nbsp;
				{if $formulas[formula].id neq 1}
				<img src="{$my_pligg_base}/templates/admin/images/formula_delete.gif" align="absmiddle" /> <a href = "{$URL_admin_formulas}&type={$templatelite.GET.type}&action=delete_formula&id={$formulas[formula].id}" onClick="javascript:return confirm('{#PLIGG_Admin_Formulas_Delete_Confirm#}')">{#PLIGG_Admin_Formulas_Delete#}</a>
				{/if}
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$formulas[formula].formula} 
				<br /><br />	
			{/section}			
			
			<hr /><br />
			
			<img src="{$my_pligg_base}/templates/admin/images/formula_add.gif" align="absmiddle" />  <a href = "{$URL_admin_formulas}&type={$templatelite.GET.type}&action=new_formula">{#PLIGG_Admin_Formulas_Add_New#}</a>

				<br /><br />

				<h4>{#PLIGG_Admin_Formulas_Simulator#}</h4><br />
				{#PLIGG_Admin_Formulas_Simulator_Text_All#}<br />
				<form>
					<label>{#PLIGG_Admin_Formulas_Input_Votes#}</label><label><input type = "text" name = "votes" id = "votes" /> </label>
					<label>{#PLIGG_Admin_Formulas_Input_Reports#}</label><label><input type = "text" name = "reports" id = "reports" /></label>
					<label>{#PLIGG_Admin_Formulas_Input_hours_since_submit#}</label><label><input type = "text" name = "hours_since_submit" id = "hours_since_submit" /> </label>
					<input type = "hidden" name = "module" value = "admin_formulas" />
					<input type = "hidden" name = "type" value = "report" />
					<input type = "hidden" name = "action" value = "eval_formula" />
					<input type = "button" value="{#PLIGG_Admin_Formulas_Simulate#}" onclick="simulate(0)" class="submit"/><br />
				</form>
				<strong>{#PLIGG_Admin_Formulas_Results#}</strong><br/><span id="results"></span><br /> 
			<br />
		{/if}

				
		
		
		{if $templatelite.GET.action eq 'edit_formula'}

			<h4>{#PLIGG_Admin_Formulas_Edit_Formula#}</h4><br />
	
			{#PLIGG_Admin_Formulas_EditPage_Name#}<span id="eip_editformula_{$templatelite.GET.id}_title">{ $the_formula[0].title }</span><br />
			{#PLIGG_Admin_Formulas_EditPage_Formula#}<span id="eip_editformula_{$templatelite.GET.id}_formula">{ $the_formula[0].formula }</span><br />
			<a href = "{$URL_admin_formulas}&type={$templatelite.GET.type}">{#PLIGG_Admin_Formulas_EditPage_Return#}</a><br />
			
			<br /><hr /><br />
			<b>{#PLIGG_Admin_Formulas_Available_Vars#}</b><br /><br />
			{#PLIGG_Admin_Formulas_Available_Vars_Votes#}<br />
			{#PLIGG_Admin_Formulas_Available_Vars_Reports#} <br />
			{#PLIGG_Admin_Formulas_Available_Vars_hours_since_submit#}<br />
			<br />
			<h4>{#PLIGG_Admin_Formulas_Simulator#}</h4><br />
			{#PLIGG_Admin_Formulas_Simulator_Text_Single#}<br />
			<form>
				<label>{#PLIGG_Admin_Formulas_Input_Votes#}</label><label><input type = "text" name = "votes" id = "votes" /> </label>
				<label>{#PLIGG_Admin_Formulas_Input_Reports#}</label><label><input type = "text" name = "reports" id = "reports" /> </label>
				<label>{#PLIGG_Admin_Formulas_Input_hours_since_submit#}</label><label><input type = "text" name = "hours_since_submit" id = "hours_since_submit" /> </label>
				<input type = "hidden" name = "module" value = "admin_formulas" />
				<input type = "hidden" name = "type" value = "report" />
				<input type = "hidden" name = "action" value = "eval_formula" />
				<input type = "hidden" name = "id" id = "formulaID" value = "{$templatelite.GET.id}" />
				<input type = "button" value="{#PLIGG_Admin_Formulas_Simulate#}" onclick="simulate(1)" class="submit"/><br />
			</form>
			{#PLIGG_Admin_Formulas_Results#}<br/><span id="results"></span><br /> 

		{/if}

	{/if}
	
	<br />
</fieldset>

{literal}
	<style type="text/css">
		.eip_editable { background-color: #ff9; padding: 3px; }
		.eip_savebutton { background-color: #36f; color: #fff; }
		.eip_cancelbutton { background-color: #000; color: #fff; }
		.eip_saving { background-color: #903; color: #fff; padding: 3px; }
		.eip_empty { color: #afafaf; }	
	</style>
{/literal}

<script type="text/javascript">
	Event.observe(window, 'load', init, false);
	function init() {ldelim}{$editinplace_init}{rdelim}
</script>	
	
{literal}	
	<script type="text/javascript">
		function simulate(useID){

			var votes = document.getElementById('votes').value;
			var reports = document.getElementById('reports').value;
			var hours_since_submit = document.getElementById('hours_since_submit').value;
			if(useID == 1){
				var formulaID = document.getElementById('formulaID').value;
			}
		
			var url = 'module.php';
			var pars = 'module=admin_formulas&type=report&action=eval_formula'; 
			if(useID == 1){
				pars = pars + '&id=' + formulaID;
			}
			pars = pars + '&votes=' + votes + '&reports=' + reports + '&hours_since_submit=' + hours_since_submit;
			
			var myAjax = new Ajax.Request(
				url, 
				{
					method: 'get', 
					parameters: pars, 
					onComplete: showResponse
				});

			function showResponse(originalRequest)
			{
				document.getElementById('results').innerHTML = originalRequest.responseText;
			}
		}
	</script>	
{/literal}