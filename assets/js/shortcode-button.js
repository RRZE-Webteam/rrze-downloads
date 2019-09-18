/**
Shortcode script
*/
jQuery(document).ready(function($) {
  tinymce.PluginManager.add('rrzedownloadshortcode', function (editor) {

      editor.addMenuItem('rrze_downloads_shortcode', {
          text: editor.getLang('rrze_downloads_mce_plugin.adddownloadlist'),
          context: 'tools',
          onclick: function () {
              editor.insertContent('[downloads category=""]');
          }
      });

  });
});
