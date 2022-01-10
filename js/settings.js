if (!window.shopEslbuttonPluginSettings) {

    var shopEslbuttonPluginSettings = (function ($) {

        'use strict';

        var shopEslbuttonPluginSettings = function (params) {
            this.init(params);
        };

        shopEslbuttonPluginSettings.prototype = {

            _config: {

                container: ".shop-esl-main",
                successMsg: "<span class='success'><i style='vertical-align:middle' class='icon16 yes'></i>Сохранено</span>",
                errorMsg: "<span class='error'><i class='icon16 no'></i><span>Допущены ошибки</span></span>"

            },

            init: function (params) {

                var that = this;

                that.params = $.extend({}, that._config, params);

                that.initElements();

                that.onFormSave();

            },

            initElements: function () {

                var that = this,
                    elements = {};

                elements.container = $(that.params.container);

                elements.form = elements.container.find(".shop-esl-form");

                that.elements = elements;

            },

            onFormSave: function () {
                var that = this,
                    elements = that.elements;

                elements.form.each(function(){
                    var form = $(this),
                    timeout = null;

                    form.on("submit", function (e) {
                        e.preventDefault();
                        var form = $(this),
                            formStatus = form.find(".js-esl-form-status");

                        $.post("?plugin=eslbutton&action=formSave", form.serialize(), function (resp) {
                            if (resp.status == "fail") {
                                var errorHtml = $(that.params.errorMsg);
                                if(typeof(resp.errors.text) !== "undefined"){
                                    errorHtml.find("span").text(resp.errors.text);
                                }
                                formStatus.html(errorHtml).show();
                            } else if (resp.status == "ok") {
                                console.log(formStatus)
                                formStatus.html(that.params.successMsg).show();
                                if (timeout) {
                                    clearTimeout(timeout);
                                }
                                timeout = setTimeout(function () {
                                    formStatus.hide();
                                }, 3000);
                            }
                        }, "json");

                    });

                });
            },

        };

        return shopEslbuttonPluginSettings;

    })(jQuery);

}
