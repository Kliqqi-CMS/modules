{if $pagename eq "register"}
	{config_load file=agree_to_terms_lang_conf}
	<div class="control-group">
		<label class="control-label">Agree to Terms</label>
		<div class="controls">
			{if isset($register_agree_error)}
				<div class="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Warning!</strong> {#AgreeToTerms_Register_Error#}
				</div>
			{/if}
			<input type="checkbox" name="agree" value="agree" {if isset($register_agree_checked) && $register_agree_checked eq true} CHECKED{/if}> {#AgreeToTerms_I_Agree#}
		</div>
	</div>
	     
    <!-- Modal -->
    <div id="TermsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">{#AgreeToTerms_Terms_Title#}</h3>
		</div>
		<div style="font-size:0.8em;" class="modal-body agree_to_terms_body">
			<p>"The Company" will be used throughout this document to represent the organization hosting this website. The Company maintains this site (the "Site") for your personal entertainment, information, education, and communication. You may download material displayed on the Site for non-commercial, personal use only. You may not distribute, modify, transmit, reuse, report, or use the contents of the Site for public or commercial purposes, including the text, images, audio, and video without The Company’s written permission.</p>
			<p>All logos contained herein are registered trademarks. All brands and product names are trademarks or registered trademarks of their respective companies.</p>
			<p>Your access and use of the Site is also subject to the following terms and conditions ("Terms and Conditions") and all applicable laws. By accessing and browsing the Site, you accept, without limitation or qualification, the Terms and Conditions.</p>
			<p>
				<strong>Terms and Conditions</strong>
				<ol>
					<li>You should assume that everything you see or read on the Site is copyrighted unless otherwise noted and may not be used except as provided in these Terms and Conditions or in the text on the Site without the prior written permission of The Company. The Company neither warrants nor represents that your use of materials displayed on the Site will not infringe rights of third parties not owned by or affiliated with The Company.</li>
					<li>While The Company uses reasonable efforts to include accurate and up-to-date information on the Site, The Company makes no warranties or representations as to its accuracy. The Company assumes no liability or responsibility for any errors or omissions in the content on the Site.</li>
					<li>This web site is intended for adult users only, and children under the age of 18 are not eligible to participate in the commercial features of this web site.</li>
					<li>Your use and browsing of the Site is at your risk. Neither The Company nor any other party involved in creating, producing, or delivering the Site is liable for any direct, incidental, consequential, indirect, or punitive damages arising out of your access to, or use of, the Site. Without limiting the foregoing, everything on the Site is provided to you "AS IS" AND "AS AVAILABLE" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OR MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT. Please note that some jurisdictions may not allow the exclusion of implied warranties, so some of the above exclusions may not apply to you. Check your local laws for any restrictions or limitations regarding the exclusion of implied warranties. Because our web site is provided to you "As Is," you agree that The Company shall not be liable to you or any third party for any delay in delivery of, or failure to deliver any of your communications or other information you submit using our web site. Because our web site is provided to you "AS AVAILABLE," you agree that The Company shall not be liable to you or any third party for any modification, suspension, or discontinuance of our web site or your ability to access it. The Company also assumes no responsibility, and shall not be liable for any damages to, or viruses that may infect, your computer equipment or other property on account of your access to, use of, or browsing in the Site or your downloading of any materials, data, text, images, video, or audio from the Site.</li>
					<li>Any communication or material you transmit to the Site by electronic mail or otherwise, including any data, questions, comments, suggestions, or the like is, and will be treated as, non-confidential and non-proprietary. Anything you transmit or post may be used by The Company or its affiliates for any purpose, including but not limited to reproduction, disclosure, transmission, publication, broadcast, and posting. Furthermore, The Company is free to use any ideas, concepts, know-how, or techniques contained in any communication you send to the Site for any purpose whatsoever, including but not limited to developing, manufacturing and marketing products using such information.</li>
					<li>Images of people or places displayed on the Site are either the property of, or used with permission by, The Company. The use of these images by you, or anyone else authorized by you, is prohibited unless specifically permitted by these Terms and Conditions or specific permission provided elsewhere on the Site. Any unauthorized use of the images may violate copyright laws, trademark laws, the laws of privacy and publicity, and communications regulations and statutes.</li>
					<li>The Company has not reviewed all of the sites linked to the Site and is not responsible for the contents of any off-site pages or any other sites linked to the Site. Your linking to any other off-site pages or other sites is at your own risk.</li>
					<li>Unless otherwise noted or agreed in writing, any items that you purchase through The Company Web Site are subject to The Company warranty policy.</li>
					<li>The Company may, in its sole discretion and at anytime, discontinue The Company web site, or any part there of, with or without notice. You agree that you do not have any rights in our web site and that The Company will have no liability to you if this web site is discontinued or your ability to access our web site is terminated.</li>
					<li>The Company may at any time revise these Terms and Conditions by updating this section. You are bound by any such revisions and should therefore periodically visit this page to review the current Terms and Conditions to which you are bound.</li>
				</ol>
			</p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">{#AgreeToTerms_Close#}</button>
		</div>
    </div>
	{config_load file=agree_to_terms_pligg_lang_conf}
{/if}