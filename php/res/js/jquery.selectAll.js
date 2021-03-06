/**
 * jQuery Select All Item
 * jQuery 选择/取消全部
 * 
 * Version 1.0 (2012-5-3)
 * @requires jQuery v1.5.1
 *
 * Author Will shaoweizheng@163.com  qq:252075062
 *
 * Usage
 *      allRel参数为空则以allId为准
 *      allId: 全选框控件id(默认为 select_all)
 *      allRel: 全选框控件rel属性
 *      itemRel: 各项选框控件rel属性(默认为 item_data)
 *
 * Examples
 *      $.selectAll({"allRel":全选控件rel属性, "itemRel":各项控件rel属性值});
 *      或者
 *      $.selectAll({"allId":全选控件id, "itemRel":各项控件rel属性值});
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
;(function($){
    $.extend({
        selectAll: function(options){
            var defaultConfig = {
                allId: "select_all",//全选框控件id
                allRel: "",//全选框控件rel属性
                itemRel: "item_data"//各项选框控件rel属性
            };
            var options = $.extend(defaultConfig, options);
            var allControl = (options.allRel == "") ? $("#"+options.allId) : $(":checkbox[rel='"+options.allRel+"']");
            var _this, _checked;
            allControl.each(function(){
                _this = $(this);
                _this.on("click", function(){
                    _checked = _this.is(":checked");
                    $(":checkbox[rel='"+options.itemRel+"']").prop("checked", _checked);
                    allControl.prop("checked", _checked);
                });
            });

            $(":checkbox[rel='"+options.itemRel+"']").each(function(){
                $(this).on("click", function(){
                    if(!$(this).attr("checked")) allControl.prop("checked", false);
                });
            });
        }
    });
})(jQuery);