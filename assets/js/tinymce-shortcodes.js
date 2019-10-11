(function() {
    tinymce.PluginManager.add('downloadsshortcodes', function(editor) {
        editor.addMenuItem('insertShortcodesDownloads', {
            icon: 'link',
            text: 'Downloads',
            context: 'insert',
            onclick: function() {
                editor.insertContent('[downloads category="" cat="" tags="" type="" format="" htmlpre="" htmlpost="" htmlitempre="" htmlitempost="" search_application="" search_image="" search_video="" search_audio="" search_text="" showsize="" showcreated="" showexcerpt="" showcontent="" errormsg="" orderby="" sort=""]<br>');
            }
        });
    });
})();