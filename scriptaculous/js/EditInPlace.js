// Setup the EditInPlace area were we'll be keeping all our
// data and code.
var EditInPlace = Class.create();

// Default values for options, text, templates and states.
EditInPlace.defaults = {
	// Options that you'll commonly be overriding.
	id:						false,
	save_url:				false,
	form_type:				"text", // valid: text, textarea, select
	auto_adjust:			false,
	size:					false, // calculate at run time
	max_size:				60,
	rows:					false, // calculate at run time
	max_rows:				25,
	cols:					60,
	save_on_enter:			true,
	cancel_on_esc:			true,
	focus_edit:				true,
	select_text:			false, // problems in WebKit/Safari?
	click_event:			"click", // valid: click, dblclick
	more_data:				false,
	select_options:			false,
	external_control:		false,

	// Text we display at various points
	edit_title:				"Click to edit.",
	empty_text:				"Click to edit.",
	saving_text:			"Saving ...",
	savebutton_text:		"SAVE",
	cancelbutton_text:		"CANCEL",
	savefailed_text:		"Failed to save changes.",

	// CSS classes and colors we use
	mouseover_highlight:	"#ffff99",
	editfield_class:		"eip_editfield",
	savebutton_class:		"eip_savebutton",
	cancelbutton_class:		"eip_cancelbutton",
	saving_class:			"eip_saving",
	empty_class:			"eip_empty",

    // Templates.  Most people won't need to change this, if you
	// do be careful, it can easily break things.
	saving:					'<span id="#{saving_id}" class="#{saving_class}" style="display: none;">#{saving_text}</span>',
	text_form:				'<input type="text" size="#{size}" value="#{value}" id="#{id}_edit" name="#{id}_edit" class="#{editfield_class}" /> <br />',
	textarea_form:			'<textarea cols="#{cols}" rows="#{rows}" id="#{id}_edit" name="#{id}_edit" class="#{editfield_class}">#{value}</textarea> <br />',
	start_select_form:		'<select id="#{id}_edit" name="#{id}_edit" class="#{editfield_class}" /> <br />',
	select_option_form:		'<option id="#{id}_option_#{option}" name="#{id}_option_#{option}" value="#{option}" #{selected}>#{option_text}</option>',
	stop_select_form:		'</select>',
	start_form:				'<span id="#{id}_editor" style="display: none;">',
	stop_form:				'</span>',
	form_buttons:			'<span><input type="button" value="#{savebutton_text}" id="#{id}_save" name="#{id}_save" class="#{savebutton_class}" /> OR <input type="button" value="#{cancelbutton_text}" id="#{id}_cancel" name="#{id}_cancel" class="#{cancelbutton_class}" /> </span>',

	// Private options that are managed for you,
	// don't touch these.
	is_empty:				false,
	orig_text:				false,
	orig_text_length:		false,
	orig_text_encoded:		false,
	orig_bk_color:			false
};

EditInPlace.prototype = {
	// Constructor
	initialize: function(options) {
		// Start with the defaults and over ride with
		// the specific options were provided.
		this.opt = {};
		Object.extend(this.opt, EditInPlace.defaults);
		Object.extend(this.opt, options || { });
	},

	// Public methods

	// Make an element editable
	edit: function() {
		var opt = this.opt;
		var id = opt['id'];

		// Set the title
		$(id).title = opt['edit_title'];

		// Save and process original content
		this._saveOrigText();

		// Turn on event processing
		this._watchForEvents();
	},

	// Private methods

	// Save and process the original contents
	_saveOrigText: function() {
		var opt = this.opt;
		var id = opt['id'];

		// Save the contents and note the length
		opt['orig_text'] = $(id).innerHTML;
		opt['orig_text_length'] = opt['orig_text'].length;

		// Find the original background color
		opt['orig_bk_color'] = $(id).getStyle('background-color');
		var bk_id = id;
		while(!opt['orig_bk_color']) {
			try {
				bk_id = $(bk_id).up();
			}
			catch(err) {
				break;
			}
		}

		// If no color was found default to all white
		if(!opt['orig_bk_color']) {
			opt['orig_bk_color'] = "#ffffff";
		}

		// Ugly hack for WebKit/Safari
		if(Prototype.Browser.WebKit) {
			opt['orig_bk_color'] = '#ffffff';
		}

		// For select edits find the original option value
		if(opt['form_type'] == 'select') {
			for(var i in opt['select_options']) {
				if(opt['select_options'][i] == opt['orig_text']) {
					opt['orig_option'] = i;
					break;
				}
			}
		}

		// If auto_adjust is turned on determine the edit method to use
		if(opt['auto_adjust']) {
			if(opt['orig_text_lenth'] > opt['max_size']) {
				opt['form_type'] = 'textarea';
			}
			else {
				opt['form_type'] = 'text';
			}
		}

		// If the element was previously marked as empty but isn't
		// empty anymore then update the empty state and remove
		// the empty class
		if(opt['is_empty']) {
			if(!$(id).empty()) {
				opt['is_empty'] = false;
				$(id).removeClassName(opt['empty_class']);
			}
		}

		// If the element is currently empty update the empty state and class
		if($(id).empty()) {
			opt['is_empty'] = true;
			$(id).innerHTML = opt['empty_text'];
			$(id).addClassName(opt['empty_class']);
		}

		// Encode < > "
		opt['orig_text_encoded'] = opt['orig_text'].replace(/</g, '&lt;');
		opt['orig_text_encoded'] = opt['orig_text'].replace(/>/g, '&gt;');
		opt['orig_text_encoded'] = opt['orig_text'].replace(/"/g, '&quot;');
	},

	// Turn on event listening
	_watchForEvents: function() {
		var opt = this.opt;
		var id = opt['id'];

		// Bind event listeners
		opt['mouseover']	= this._mouseOver.bindAsEventListener(this, id);
		opt['mouseout']		= this._mouseOut.bindAsEventListener(this, id);
		opt['mouseclick']	= this._mouseClick.bindAsEventListener(this, id);
		opt['canceledit']	= this._cancelEdit.bindAsEventListener(this, id);
		opt['saveedit']		= this._saveEdit.bindAsEventListener(this, id);

		// Watch for events
		$(id).observe('mouseover', opt['mouseover']);
		$(id).observe('mouseout', opt['mouseout']);
		$(id).observe(opt['click_event'], opt['mouseclick']);

		// External control events
		if(opt['external_control']) {
			var ext_id = opt['external_control'];
			$(ext_id).observe('mouseover', opt['mouseover']);
			$(ext_id).observe('mouseout', opt['mouseout']);
			$(ext_id).observe(opt['click_event'], opt['mouseclick']);
		}
	},

	// Mouse over event handling
	_mouseOver: function(e) {
		var opt = this.opt;
		var id = opt['id'];

		$(id).setStyle({backgroundColor: opt['mouseover_highlight']});
	},

	// Mouse out event handling
	_mouseOut: function(e) {
		var opt = this.opt;
		var id = opt['id'];

		$(id).setStyle({backgroundColor: opt['orig_bk_color']});
	},

	// Mouse click event handling, go into edit mode
	_mouseClick: function(e) {
		var opt = this.opt;
		var id = opt['id'];

		// Hide the original element
		$(id).hide();

		// If there is an external control hide it too
		if(opt['external_control']) {
			$(opt['external_control']).hide();
		}

		// Compile the start of the edit form
		var form			= '';
		var start_form		= new Template(opt['start_form']);
		var stop_form		= new Template(opt['stop_form']);
		var form_buttons	= new Template(opt['form_buttons']);
		form += start_form.evaluate({id: id});

		// Put together the body of the form
		switch(opt['form_type']) {
			case 'text':
				var size = opt['orig_text_length'] + 15;
				if(size > opt['max_size']) {
					size = opt['max_size'];
				}
				size = (opt['size'] ? opt['size'] : size);

				var text_form = new Template(opt['text_form']);
				form += text_form.evaluate({
					id: id,
					size: size,
					value: opt['orig_text_encoded'],
					editfield_class: opt['editfield_class']
				});

				break;
			case 'textarea':
				var rows = (opt['orig_text_length'] / opt['cols']) + 2;
				for(var i = 0; i < opt['orig_text_length']; i++) {
					if(opt['orig_text'].charAt(i) == "\n") {
						rows++;
					}
				}
				if(rows > opt['max_rows']) {
					rows = opt['max_rows'];
				}
				rows = (opt['rows'] ? opt['rows'] : rows);

				var textarea_form = new Template(opt['textarea_form']);
				form += textarea_form.evaluate({
					id: id,
					cols: opt['cols'],
					rows: rows,
					value: opt['orig_text_encoded'],
					editfield_class: opt['editfield_class']
				});

				break;
			case 'select':
				var start_select_form = new Template(opt['start_select_form']);
				form += start_select_form.evaluate({
					id: id,
					editfield_class: opt['editfield_class']
				});

				var option_form = new Template(opt['select_option_form']);
				var selected = '';
				for(var i in opt['select_options']) {
					if(opt['select_options'][i] == opt['orig_text']) {
						selected = 'selected="selected"';
					}
					else {
						selected = '';
					}

					form += option_form.evaluate({
						id: id,
						option: i,
						selected: selected,
						option_text: opt['select_options'][i]
					});
				}

				var stop_select_form = new Template(opt['stop_select_form']);
				form += stop_select_form.evaluate({});

				break;
		}

		// Compile the end of the edit form
		form += form_buttons.evaluate({
			id: id,
			savebutton_class: opt['savebutton_class'],
			savebutton_text: opt['savebutton_text'],
			cancelbutton_class: opt['cancelbutton_class'],
			cancelbutton_text: opt['cancelbutton_text']
		});
		form += stop_form.evaluate({});

		this._displayForm(form);
	},

	// Save edit
	_saveEdit: function() {
		var opt = this.opt;
		var id = opt['id'];

		// Gather up all of the data to pass in the XHR.
		var params = {
			'id': id,
			'form_type': opt['form_type'],
			'old_content': opt['orig_text'],
			'new_content': $F(id + '_edit')
		};

		// Provide details on the options if this was a select edit
		if(opt['form_type'] == 'select') {
			params['new_option'] = params['new_content'];
			params['new_option_text'] = $(id + '_option_' + params['new_content']).innerHTML;

			params['old_option'] = opt['orig_option'];
			params['old_option_text'] = opt['orig_text'];

			// Over ride the *_content to use the *_option_text instead
			params['old_content'] = params['old_option_text'];
			params['new_content'] = params['new_option_text'];
		}

		// Glue all of the parameters together and escape content
		var post_data = '';
		for(var i in params) {
			post_data += '&' + i + '=' + encodeURIComponent(params[i]);
		}

		// Include any additional data that was provided
		if(opt['more_data']) {
			for(var i in opt['more_data']) {
				post_data += '&' + i + '=' + encodeURIComponent(params[i]);
			}
		}

		// Strip the first & off of the front of post_data
		post_data.sub('&', '', 1);

		// Put the saving message together
		var saving = new Template(opt['saving']);
		saving = saving.evaluate({
			saving_id: id + '_saving',
			saving_class: opt['saving_class'],
			saving_text: opt['saving_text']
		});

		// Remove the edit form
		$(id + '_editor').remove();

		// Show the saving message
		$(id).insert({after: saving});
		$(id + '_saving').show();

		// Need a copy of this object to deal with content issues
		var my_obj = this;

		// Make the save request
		var xhr = new Ajax.Request(
			opt['save_url'],
			{
				method: 'post',
				postBody: post_data,
				onSuccess: function(r) {
					// Set the content of the editable element
					$(id).innerHTML = r.responseText;

					// Process the new content as the original content
					my_obj._saveOrigText();

					// Remove the saving message
					$(id + '_saving').remove();

					// Show the new content
					$(id).show();
					$(id).setStyle({backgroundColor: opt['orig_bk_color']});

					if(opt['external_control']) {
						$(opt['external_control']).show();
					}
				},
				onFailure: function(r) {
					// Remove the saving message
					$(id + '_saving').remove();

					// Restore the original text of the editable element
					$(id).innerHTML = opt['orig_text'];
					$(id).show();
					$(id).setStyle({backgroundColor: opt['orig_bk_color']});

					if(opt['external_control']) {
						$(opt['external_control']).show();
					}

					// Notify the user that the save failed
					alert('Error saving changes.');
				}
			}
		);
	},

	// Cancel edit
	_cancelEdit: function() {
		var opt = this.opt;
		var id = opt['id'];

		$(id + '_editor').remove();
		$(id).show();

		// Make sure the mouse over highlight is turned off
		$(id).setStyle({backgroundColor: opt['orig_bk_color']});

		if(opt['external_control']) {
			$(opt['external_control']).show();
		}
	},

	// Display edit form
	_displayForm: function(form) {
		var opt = this.opt;
		var id = opt['id'];

		// Add the form after the original element
		$(id).insert({after: form});
		$(id + '_editor').show();

		// Focus on edit
		if(opt['focus_edit']) {
			$(id + '_edit').focus();
		}

		// Select edit text
		if(opt['select_text']) {
			$(id + '_edit').select();
		}

		// Watch for save and cancel button click
		$(id + '_save').observe('click', opt['saveedit']);
		$(id + '_cancel').observe('click', opt['canceledit']);

		// Need a copy of this to deal with context issues
		var my_obj = this;

		// Watch for the enter key
		if(opt['save_on_enter']) {
			$(id + '_edit').observe(
				'keypress',
				function(e) {
					if(e.keyCode == Event.KEY_RETURN) {
						my_obj._saveEdit();
					}
				}
			);
		}

		// Watch for the escape key
		if(opt['cancel_on_esc']) {
			$(id + '_edit').observe(
				'keypress',
				function(e) {
					if(e.keyCode == Event.KEY_ESC) {
						my_obj._cancelEdit();
					}
				}
			);
		}
	}
};

// Attach EditInPlace to $()
Element.addMethods({
	editInPlace: function(element, options) {
		if(!options) {
			var options = {};
		}

		options['id'] = $(element).id;

		// Tack on additional parameters to the options data
		Object.extend(options, arguments[1]);

		// Create a new object
		var eip = new EditInPlace(options);
		eip.edit();
	}
});
