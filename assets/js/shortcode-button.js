/**
Shortcode script
*/
jQuery(document).ready(function($) {
  tinymce.PluginManager.add('rrzedownloadshortcode', function (editor) {

      editor.addMenuItem('rrze-downloads_shortcode', {
          text: editor.getLang('rrze-downloads_mce_plugin.adddownloadlist'),
          context: 'tools',
          onclick: function () {
              editor.insertContent('[downloads category=""]');
          }
      });

  });
});
