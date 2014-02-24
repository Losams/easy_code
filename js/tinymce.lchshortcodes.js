(function ()
{
    // create lchShortcodes plugin
    tinymce.create("tinymce.plugins.lchShortcodes",
    {
        init: function ( ed, url )
        {
            ed.addCommand("lchPopup", function ( a, params )
            {
                var popup = params.identifier;
                // load thickbox
                tb_show("lch: insèrer shortcode", url + "/../class/shortcodes.popup.php?popup=" + popup + "&width=640&height=480");
            });
        },
        createControl: function ( btn, e )
        {
            

            if ( btn == "easy_code_button" )
            {   
                var a = this;
                
                var btn = e.createSplitButton('easy_code_button', {
                    title: "Insert lch Shortcode",
                    image: e.url + "/../../wp-content/plugins/easy-code/img/easy-code-icon.png",
                    icons: false,
                    onclick : function() {
                        document.getElementById('content_easy_code_button_open').click();
                    }
                });

                btn.onRenderMenu.add(function (c, b)
                {  
                    jQuery.post(ajaxurl, {action:'get_all_shortcode_forge'}, function(html){
                        for(var i = 0; i < html.length; i++) {
                            var obj = html[i];
                            if (obj.is_immediat) {
                                a.addImmediate( b, obj.title, obj.shortcode );
                            } else {
                                a.addWithPopup( b, obj.title, obj.name);    
                            }
                        }                 
                    });
                });
                
                return btn;
            }
            
            return null;
        },
        addWithPopup: function ( ed, title, id ) {
            ed.add({
                title: title,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("lchPopup", false, {
                        title: title,
                        identifier: id
                    })
                }
            })
        },
        addImmediate: function ( ed, title, sc) {
            ed.add({
                title: title,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
                }
            })
        },
        getInfo: function () {
            return {
                longname: 'Plugin Easy-Code',
                author: 'SAMSON Louis',
                authorurl: 'https://github.com/Losams',
                infourl: 'https://github.com/Losams',
                version: "1.0"
            }
        }
    });
    
    tinymce.PluginManager.add("lchShortcodes", tinymce.plugins.lchShortcodes);
})();