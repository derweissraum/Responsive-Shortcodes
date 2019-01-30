(function() {

	tinymce.PluginManager.add('responsive_shortcodes_button', function(editor, url) {
		editor.addButton( 'responsive_shortcodes_button', {
			title: 'Shortcodes einfügen',
			type:  'menubutton',
			icon:  'icon responsive-shortcodes-icon',
			menu:  [

				/* Documentation Link */
				{
					text:    'Dokumentation anzeigen',
					onclick: function() {
						window.open('https://docs.der-weissraum.de/docs/responsive-shortcodes/verwendung/');
					},
				},

				/* Divider */
				{
					text: '-',
				},

				/* Music */
				{
					text:    'Musik/Playlist',
					onclick: function() {
						editor.insertContent( '[boxmusic title="Reingehört"]Shortcode Audio hier rein[/boxmusic]' );
					},
				},

				/* Video */
				{
					text:    'Video',
					onclick: function() {
						editor.insertContent( '[boxvideo title="Reingeschaut"]YouTube Link hier rein[/boxvideo]' );
					},
				},

				/* Accordion */
				{
					text:    'Akkordeon',
					onclick: function() {
						editor.insertContent( '[accordion]<br>[accordion_item title="Akkordeon Titel 1"]<br>Inhalt Akkordeon 1 steht hier.<br>[/accordion_item]<br>[accordion_item title="Akkordeon Titel 2"]<br>Inhalt Akkordeon 2 steht hier.<br>[/accordion_item]<br>[accordion_item title="Akkordeon Titel 3"]<br>Inhalt Akkordeon 3 steht hier.<br>[/accordion_item]<br>[/accordion]' );
					},
				},

				/* Alert */
				{
					text:    'Hinweis',
					onclick: function() {
						editor.insertContent( '[alert color="red" icon="alarm"]Hier steht der Hinweistext[/alert]' );
					},
				},

				/* Box */
				{
					text:    'Kasten',
					onclick: function() {
						editor.insertContent( '[box title="Kastentitel"]Kasteninhalt steht hier.[/box]' );
					},
				},

				/* Button */
				{
					text:    'Schaltfläche',
					onclick: function() {
						editor.insertContent( '[button color="green" url="https://www.domain.de/"]Schaltflächentext[/button]' );
					},
				},

				/* Call to Action */
				{
					text:    'Handlungsaufforderung',
					onclick: function() {
						editor.insertContent( '[call_to_action color="blue" button_text="Schaltflächentext" button_url="https://www.domain.de/"]<br>Text zur Handlungsaufforderung.<br>[/call_to_action]' );
					},
				},

				/* Clear Floats */
				{
					text:    'Schweben aufheben',
					onclick: function() {
						editor.insertContent( '[clear_floats]' );
					},
				},

				/* Columns */
				{
					text:    'Spalten',
					onclick: function() {
						editor.insertContent( '[columns]<br>[column width="one-third"]<br>Spaltentext Eins.<br>[/column]<br>[column width="one-third"]<br>Spaltentext Zwei.<br>[/column]<br>[column width="one-third"]<br>Spaltentext Drei.<br>[/column]<br>[/columns]' );
					},
				},

				/* Highlight */
				{
					text:    'Hervorhebung',
					onclick: function() {
						editor.insertContent( '[highlight]Hier steht der hervorgehobene Text.[/highlight]' );
					},
				},

				/* Icon */
				{
					text:    'Symbol',
					onclick: function() {
						editor.insertContent( '[icon id=""]' );
					},
				},

				/* Tabs */
				{
					text:    'Register',
					onclick: function() {
						editor.insertContent( '[tabs]<br>[tab title="Registertitel 1"]<br>Registertext 1 steht hier.<br>[/tab]<br>[tab title="Registertitel 2"]<br>Registertext 2 steht hier.<br>[/tab]<br>[tab title="Registertitel 3"]<br>Registertext 3 steht hier.<br>[/tab]<br>[/tabs]' );
					},
				},

				/* Toggle */
				{
					text:    'Textschalter',
					onclick: function() {
						editor.insertContent( '[toggle title="Textschalter Titel"]<br>Inhalt des Textschalters steht hier.<br>[/toggle]' );
					},
				},

			],
		});
	});
})();
