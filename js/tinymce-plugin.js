(function() {
	tinymce.PluginManager.add('my_mce_button', function( editor, url ) {
		editor.addButton( 'my_mce_button', {
			// text: 'Adf.ly',
			image : wp_ulrs.adfly_icon,
			title : 'Insert Adf.ly Shortened URL',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Adf.ly Shortened URL',
					body: [
						{
							type: 'textbox',
							name: 'url',
							label: 'Original URL',
							value: ''
						},
						{
							type: 'listbox',
							name: 'label_type',
							label: 'URL Label Type',
							'values': [
								{text: 'Select', value: ''},
								{text: 'Original URL', value: 'long'},
								{text: 'Shortened URL', value: 'short'},
								{text: 'Text', value: 'text'}
							]
						},
						{
							type: 'textbox',
							name: 'label',
							label: 'Label Text (if \'URL Label Type\' is selected as \'Text\')'
						},
						{
							type: 'listbox',
							name: 'domain',
							label: 'Domain to be used in shortened url',
							'values': [
								{text: 'Select', value: ''},
								{text: 'adf.ly', value: 'adf.ly'},
								{text: 'q.gs', value: 'q.gs'},
							]
						},
						{
							type: 'listbox',
							name: 'ad_type',
							label: 'Ad type to use',
							'values': [
								{text: 'Select', value: ''},
								{text: 'Interstitial / Countdown', value: 'int'},
								{text: 'Banner', value: 'banner'}
							]
						},
						{
							type: 'listbox',
							name: 'target',
							label: 'Link opens in',
							'values': [
								{text: 'Select', value: ''},
								{text: 'New Tab', value: '_blank'},
								{text: 'Current Tab', value: ''}
							]
						}
					],
					onsubmit: function( e ) {
					editor.insertContent( '[mdc_adfly url="' + e.data.url + '" target="' + e.data.target + '" label_type="' + e.data.label_type + '" label="' + e.data.label + '" domain="' + e.data.domain + '" ad_type="' + e.data.ad_type + '"]');
					}
				});
			}
		});
	});
})();