/**
 * Setting and create button on MCE Editor
 *
 * @author gmswebdesign
 * @package AP Background
 * @version 1.0.0
 */
(function () {
    tinymce.create('tinymce.plugins.ap_background_buttons', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init: function (ed, url) {
            ed.addButton('ap_add_button', {
                title: 'Insert Parallax Button',
                cmd: 'ap_add_button',
                image: url + '/button-icon/bt-add-button.png'
            });

            
            ed.addCommand('ap_add_button', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                if(selected_text){
                    return_text = '<a class="open-btn" href="#">' + selected_text + '</a>';
                }else{
                    return_text = '<a href="#" class="open-btn">Button label</a>';
                }
                ed.execCommand('mceInsertContent', 0, return_text);
            });
 
        },
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl: function (n, cm) {
            return null;
        },
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo: function () {
            return {
                longname: 'AP Add Button',
                author: 'gmswebdesign',
                authorurl: 'http://gmswebdesign.com/',
                infourl: '',
                version: "0.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('ap_background_buttons', tinymce.plugins.ap_background_buttons);
})();

