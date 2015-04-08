( function() {
	"use strict";

	var easy_custom_styles = function( editor, url ) {
		editor.addButton('custom_styles', function() {
			var values = [];
			
			for (var i = 0; i < list_easy_shortcodes.length; i++) {
				var _id = list_easy_shortcodes[i];
				values.push({text: _id, value: _id});
			}
	 
			return {
				type: 'listbox',
				//name: 'align',
				text: 'Shortcodes',
				label: 'Select :',
				fixedWidth: true,
				onselect: function(e) {
					if (e) {
						var obj_json_shortcode = easy_shortcodes[e.control.settings.value];

						if (obj_json_shortcode['is_immediat']) {
							editor.insertContent(obj_json_shortcode['shortcode']);
						} else {
							console.log(obj_json_shortcode['fields']);
							editor.windowManager.open( {
								title: 'Shortcode : '+ e.control.settings.value,
								body: {
									type: 'form', 
						          	items: obj_json_shortcode['fields']
						        },
								onsubmit: function( e ) {
									var output = '['+ obj_json_shortcode['name'];

									for (var i = 0; i < obj_json_shortcode['fields'].length; i++) {
										var name = obj_json_shortcode['fields'][i]['name'];
										var val = e.data[name]

										output += ' '+name+'='+val;
									}
									
									output += '][/'+obj_json_shortcode['name']+']';
									editor.insertContent( output );
								}
							});	
						}
					}		
					return false;
				},
				values: values,
			};
		});
	};
	tinymce.PluginManager.add( 'easy_custom_styles', easy_custom_styles );

} )();