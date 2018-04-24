/**
 * MudEye plugin for Craft CMS
 *
 * MudEyeFieldType JS
 *
 * @author    @cole007
 * @copyright Copyright (c) 2017 @cole007
 * @link      http://ournameismud.co.uk/
 * @package   MudEye
 * @since     1.0.0
 */

 ;(function ( $, window, document, undefined ) {

    var pluginName = "MudEyeFieldType",
        defaults = {
        };

    // Plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function(id) {
            var _this = this;

            $(function () {

/* -- _this.options gives us access to the $jsonVars that our FieldType passed down to us */
                var wrappers = $(_this.element).find('.input .field');
                $(wrappers).each(function(){
                    var wrapper = this;
                    $(wrapper).find('.heading').append('<small></small>');
                    var fields = $(_this.element).find('input[type=text],textarea');
                    $(fields).each(function (i) {
                        var field = this;
                        var val = $(this).val();
                        var val = $(this).val();
                        $(wrapper).has(this).find('.heading small').text(val.length);
                        $(wrapper).on('keyup','input[type=text],textarea',function (e) {
                            var val = $(this).val();
                            $(wrapper).find('.heading small').text(val.length);
                        });
                    });
                });

                
            });
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );
