(function() {
    tinymce.PluginManager.add('downloadsshortcodes', function(editor) {
        editor.addMenuItem('insertShortcodesDownloads', {
            icon: 'link',
            text: 'Downloads',
            // menu: menuItems,
            context: 'insert',
            onclick: function() {
                editor.insertContent('[downloads format="table"]<br>');
            }
        });
    });
})();