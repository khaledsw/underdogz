/**
 * Setting and create button on MCE Editor
 *
 * @author Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */
(function() {
    tinymce.create('tinymce.plugins.ap_background_buttons', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init: function(ed, url) {
            var menuitems = [];
            var paralist = JSON.parse(btAdvParallaxBackgroundCfg.parallaxs);
            if (paralist.length <= 0) {
                menuitems.push({text: 'No parallax was found', value: ''});
            } else {
                for (var i = 0; i < paralist.length; i++) {
                    menuitems.push({text: paralist[i][0], value: paralist[i][1]});
                }
            }
            ed.addButton('ap_add_button', {
                title: 'Insert Parallax',
                type: 'menubutton',
                menu: menuitems,
                //cmd: 'ap_add_button',
                image: url + '/button-icon/ap_icon.png',
                onselect: function(e) {
                    var para_alias = e.control._value;
                    if (para_alias === '') {
                        ed.selection.setContent('');
                    } else {
                        ed.selection.setContent('[adv_parallax_back alias="' + para_alias + '"]');
                    }
                }
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
        createControl: function(n, cm) {
            return null;
        },
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo: function() {
            return {
                longname: 'AP Add Button',
                author: 'inwavethemes',
                authorurl: 'http://inwavethemes.com/',
                infourl: '',
                version: "0.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('ap_background_buttons', tinymce.plugins.ap_background_buttons);
})();

