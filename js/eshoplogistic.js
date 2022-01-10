if (!window.eslbutton) {

    eslbutton = (function ($) {

        'use strict';

        var eslbutton = function (params, product, $skuFeatures) {

            params = $.extend({}, params, product, $skuFeatures);
            this.init(params);

        };

        eslbutton.prototype = {

            _config: {
                box: '#esl-box',
                block: '.s-button-wrapper',
                staticBlock: '.js-features-section',
                skuSelect: '.sku-feature',
            },

            init: function (params) {

                var that = this;

                that.params = $.extend({}, that._config, params);
                that.initElements();
                that.initButton();

            },

            initElements: function(){
                var that = this,
                    elements = {};

                elements.block = $(that.params.block);
                elements.staticBlock = $(that.params.staticBlock);

                that.elements = elements;

            },

            initButton: function(){
                var that = this;

                if($(that.params.skuSelect).length > 0){
                    var features = that.params.skuFeatures
                    $(that.params.skuSelect).change(function () {
                        var key = "";
                        $(that.params.skuSelect).each(function () {
                            key += $(this).data('feature-id') + ':' + $(this).val() + ';';
                        });
                        var sku = {'sku_currect':features[key]};

                        that.postRequestButton(sku);
                    }).trigger('change');
                }else{
                    that.postRequestButton();
                }


            },

            postRequestButton: function (sku = ''){
                var that = this,
                    elements = that.elements;

                that.params = $.extend({}, that.params, sku);
                $.post(that.params.urlRequest, that.params, function(resp){
                    if($(that.params.box).length > 0){
                        $(that.params.box).remove();
                    }
                    if(resp.data.type === 'static'){
                        elements.staticBlock.before(resp.data.content);
                    }else{
                        elements.block.after(resp.data.content);
                    }

                    let css = ['https://api.eshoplogistic.ru/widget/'+resp.data.type+'/v1/css/app.css'],
                        js = ['https://api.eshoplogistic.ru/widget/'+resp.data.type+'/v1/js/chunk-vendors.js','https://api.eshoplogistic.ru/widget/'+resp.data.type+'/v1/js/app.js'];

                    for(const path of css){
                        let style = document.createElement('link');
                        style.rel="stylesheet"
                        style.href = path
                        if(resp.data.type === 'static'){
                            elements.staticBlock.append(style)
                        }else{
                            elements.block.append(style)
                        }
                    }
                    for(const path of js){
                        let script = document.createElement('script');
                        script.src = path
                        if(resp.data.type === 'static'){
                            elements.staticBlock.append(script)
                        }else{
                            elements.block.append(script)
                        }
                    }
                }, "json")
            },

        };

        return eslbutton;

    })(jQuery);

}
