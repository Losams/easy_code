(function($) {
    var sc,
    ShortCode = {

        settings: {
            shortcodes: $('.custom_shortcode'),
            insert_shortcode: $('#insert_shortcode'),
            prototype: $('#form_shortcode').attr('data-prototype'),
        },

        init: function() {
            sc = this.settings;
            formPopup = this;
            
            this.resizeTB();
            $(window).resize(function() { formPopup.resizeTB() });
            this.bindUIActions();
        },

        bindUIActions: function() {

            sc.insert_shortcode.on('click', function() {
                if (window.tinyMCE) {

                    sc.shortcodes.each(function() {
                        var input = $(this),
                            id = input.attr('name'),
                            re = new RegExp("{{"+id+"}}","g");
                        sc.prototype = sc.prototype.replace(re, input.val());
                    });
                    
                    window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, sc.prototype);
                    tb_remove();
                }
            });
           
        },
        resizeTB: function()
        {
            var ajaxCont = $('#TB_ajaxContent'),
                tbWindow = $('#TB_window'),
                formPopup = $('#custom_form_shortcode');

            ajaxCont.css({
                //height: (tbWindow.outerHeight()-47),
                overflow: 'auto', // IMPORTANT
                width: formPopup.outerWidth()
            });

            tbWindow.css({
                height: formPopup.outerHeight() + 50,
                width: formPopup.outerWidth(),
                marginLeft: -(formPopup.outerWidth()/2)
            });
            
            $('#TB_window').addClass('forceHeight');
            $('body').append('<style>.forceHeight{height:auto!important;}</style>');
        },

    };

    ShortCode.init();

})(jQuery);
