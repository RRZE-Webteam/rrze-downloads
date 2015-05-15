(function() {

    tinymce.PluginManager.add('downloadrteshortcodes', function( editor )
    {
		
		editor.addMenuItem('shortcode_downloads', {
			text: 'Downloadliste einfügen',
			context: 'tools',
			onclick: function() {
				editor.insertContent('[download category=""]');
			}
		});

    });
})();