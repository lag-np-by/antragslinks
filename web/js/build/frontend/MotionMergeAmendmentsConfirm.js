define(["require","exports"],function(t,i){"use strict";Object.defineProperty(i,"__esModule",{value:!0});var n=function(){function t(t){this.$widget=t,this.$sections=t.find(".motionTextHolder"),t.find("input[name=diffStyle]").change(this.onChangeDiffStyle.bind(this)),t.find("input[name=diffStyle]").first().change(),this.initResolutionFunctions(),this.initVotingFunctions()}return t.prototype.onChangeDiffStyle=function(){"diff"==this.$widget.find("input[name=diffStyle]:checked").val()?(this.$sections.find(".fullText").addClass("hidden"),this.$sections.find(".diffText").removeClass("hidden")):(this.$sections.find(".fullText").removeClass("hidden"),this.$sections.find(".diffText").addClass("hidden"))},t.prototype.initResolutionFunctions=function(){var t=this;this.$newStatus=this.$widget.find(".newMotionStatus input"),this.$newStatus.on("change",function(){"motion"===t.$newStatus.filter(":checked").val()?t.$widget.find(".newMotionInitiator").addClass("hidden"):t.$widget.find(".newMotionInitiator").removeClass("hidden")}).trigger("change"),this.$widget.find("#dateResolutionHolder").datetimepicker({locale:$("html").attr("lang"),format:"L"})},t.prototype.initVotingFunctions=function(){var t=$(".votingResultCloser"),i=$(".votingResultOpener"),n=$(".contentVotingResult, .contentVotingResultComment");i.click(function(){t.removeClass("hidden"),i.addClass("hidden"),n.removeClass("hidden")}),t.click(function(){t.addClass("hidden"),i.removeClass("hidden"),n.addClass("hidden")})},t}();i.MotionMergeAmendmentsConfirm=n});
//# sourceMappingURL=MotionMergeAmendmentsConfirm.js.map
