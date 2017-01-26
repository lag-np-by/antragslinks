define(["require","exports"],function(e,t){"use strict";var i=function(){function e(t){this.$el=$("#"+t);var i=this.$el.data("ckeditor_initialized");if("undefined"==typeof i||!i){this.$el.data("ckeditor_initialized","1"),this.$el.attr("contenteditable","true");var n=e.createConfig(this.$el.attr("title"),"1"==this.$el.data("no-strike"),"1"==this.$el.data("track-changed"),"1"==this.$el.data("allow-diff-formattings"),"br"==this.$el.data("enter-mode")?CKEDITOR.ENTER_BR:CKEDITOR.ENTER_P);this.editor=CKEDITOR.inline(t,n),this.initMaxLen()}}return e.ckeditor_strip=function(e){var t=document.createElement("div");return t.innerHTML=e,""==t.textContent&&"undefined"==typeof t.innerText?"":t.textContent||t.innerText},e.ckeditor_charcount=function(t){var i=t.replace(/(\r\n|\n|\r)/gm,"").replace(/^\s+|\s+$/g,"").replace("&nbsp;","");return i=e.ckeditor_strip(i).replace(/^([\s\t\r\n]*)$/,""),i.length},e.prototype.maxLenOnChange=function(){var t=e.ckeditor_charcount(this.editor.getData());this.$currCounter.text(t),t>this.maxLen?(this.$warning.removeClass("hidden"),this.maxLenSoft||this.$submit.prop("disabled",!0)):(this.$warning.addClass("hidden"),this.maxLenSoft||this.$submit.prop("disabled",!1))},e.prototype.initMaxLen=function(){var e=this.$el.parents(".wysiwyg-textarea").first();e.data("max-len")&&(this.maxLen=e.data("max-len"),this.maxLenSoft=!1,this.$warning=e.find(".maxLenTooLong"),this.$submit=this.$el.parents("form").first().find("button[type=submit]"),this.$currCounter=e.find(".maxLenHint .counter"),this.maxLen<0&&(this.maxLenSoft=!0,this.maxLen=-1*this.maxLen),this.editor.on("change",this.maxLenOnChange),this.maxLenOnChange())},e.createConfig=function(e,t,i,n,a){var s={coreStyles_strike:{element:"span",attributes:{class:"strike"},overrides:"strike"},coreStyles_underline:{element:"span",attributes:{class:"underline"}},toolbarGroups:[{name:"tools"},{name:"document",groups:["mode","document","doctools"]},{name:"basicstyles",groups:["basicstyles","cleanup"]},{name:"paragraph",groups:["list","indent","blocks","align","bidi"]},{name:"links"},{name:"insert"},{name:"styles"},{name:"colors"},{name:"others"}],removePlugins:"stylescombo,save,showblocks,specialchar,about,preview,pastetext",extraPlugins:"tabletools",scayt_sLang:"de_DE",title:e,enterMode:a},r=t?"":" s",o=t?"":",strike",l="";return l=i||n?"strong"+r+" em u sub sup;h2 h3 h4;ul ol li [data-*](ice-ins,ice-del,ice-cts,appendHint){list-style-type};div [data-*](collidingParagraph,paragraphHolder,hasCollissions);p blockquote [data-*](ice-ins,ice-del,ice-cts,appendHint,collidingParagraphHead){border,margin,padding};span[data-*](ice-ins,ice-del,ice-cts,appendHint,underline"+o+",subscript,superscript);a[href,data-*](ice-ins,ice-del,ice-cts,appendHint);br ins del[data-*](ice-ins,ice-del,ice-cts,appendHint);":"strong"+r+" em u sub sup;ul ol li {list-style-type};h2 h3 h4;p blockquote {border,margin,padding};span(underline"+o+",subscript,superscript);a[href];",i?(s.extraPlugins+=",lite",s.lite={tooltips:!1}):s.removePlugins+=",lite",s.allowedContent=l,s},e.prototype.getEditor=function(){return this.editor},e}();t.AntragsgruenEditor=i});
//# sourceMappingURL=AntragsgruenEditor.js.map