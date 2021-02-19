"use strict";!function(n){function o(e){e=jQuery(e).hasClass("leads-form")?"#"+e.attr("id"):e[0].children[0];var o=window["leads_form_"+jQuery(e).attr("data-block-id")];new Vue({el:e,data:{formId:jQuery(e).attr("data-form-id"),blockData:o,counter:0,targetCounter:+o.counter,goal:o.counterGoalValue,loading:!1,donateAmount:o.donateAmount,errors:[],emailErrors:[],firstNameErrors:[],lastNameErrors:[],phoneErrors:[],otherErrors:[],success:!1,formFields:o.formFields,showThankYouAnimation:!1,animationSpeed:.6,heroDescription:o.heroDescription,textLimit:300,textOpen:!1,display:o.display,heroTitle:o.heroTitle,hideInput:"collapse"==o.formStyle,dataLayer:window.dataLayer,sourceCode:o.sourceCode,startedFilling:!1},computed:{percentReachedGoal:function(){return Math.min(this.counter/o.counterGoalValue*100,100)},reachedGoal:function(){return this.counter>=this.goal},thankYouTitle:function(){return o.thankYouTitle.replace("${fname}",this.formFields.fname.value)},hasErrors:function(){return 0<this.errors.length},moreButtonText:function(){return this.textOpen?o.readLess:o.readMore},showReadMore:function(){return this.heroDescription.length>=this.textLimit}},watch:{startedFilling:function(){this.dataLayer&&this.dataLayer.push({event:"petitionFilling"})}},mounted:function(){var t=this;if(this.dataLayer&&this.dataLayer.push({sourceCode:this.sourceCode,counter:this.blockData.enableCounter?"yes":"no"}),gsap.timeline({}).from(".leads-form__content",{y:100,opacity:0,duration:this.animationSpeed}).from(".leads-form__form",{y:100,opacity:0,duration:this.animationSpeed},"-="+this.animationSpeed/2),this.blockData.enableCounter&&Array.isArray(this.blockData.counterApiEndpoints)){var e="";e="www.planet4.test"===n(location).attr("hostname")?"/wp-json/gplp/v2/leads/count/"+this.sourceCode+"?v="+Date.now():"/"+window.location.pathname.split("/")[1]+"/wp-json/gplp/v2/leads/count/"+this.sourceCode+"?v="+Date.now(),jQuery.get(e,function(e){t.targetCounter=e.counter,t.blockData.counterApiEndpoints.forEach(function(e){e&&""!==jQuery.trim(e)&&void 0!==e&&jQuery.get(e,t.formFields,function(e){t.targetCounter=t.targetCounter+ +e.counter,t.animateCounter()})}),0==t.blockData.counterApiEndpoints.length&&t.animateCounter()})}},methods:{animateCounter:lodash.debounce(function(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:this,t={val:e.counter},o=e.targetCounter;TweenLite.to(t,2,{val:o,roundProps:"val",onUpdate:function(){e.counter=t.val}})},1e3),getDonateUrl:function(e){return e.replace("%amount%",this.donateAmount)},hasFieldErrors:function(){return 0<(""+this.errorType).length},pushMessage:function(e,t){"email"==e?this.emailErrors.push(t):"fname"==e?this.firstNameErrors.push(t):"lname"==e?this.lastNameErrors.push(t):"phone"==e?this.phoneErrors.push(t):this.otherErrors.push(t),"small"==this.display&&"phone"==e||this.errors.push(t)},addBlur:function(){var e=this;window.setTimeout(function(){e.$refs.bkg.classList.add("blur"),e.$refs.smallBkg&&e.$refs.smallBkg.classList.add("blur")},800)},numbersOnly:function(e){var t=void 0===e.which?e.keyCode:e.which;String.fromCharCode(t).match(/^[0-9]+$/)||e.preventDefault()},checkMinVal:function(e){e.target.value=Math.max(+e.target.value,this.blockData.donateMinimumAmount)},submit:function(){var t=this;if(!this.loading){if(this.hideInput=!1,this.errors=[],this.emailErrors=[],this.firstNameErrors=[],this.lastNameErrors=[],this.phoneErrors=[],this.otherErrors=[],Object.keys(this.formFields).forEach(function(e){return""==t.formFields[e].value&&t.formFields[e].required&&t.pushMessage(t.formFields[e].id,o.errorMessages.required.replace("${fieldName}",t.formFields[e].fieldName))}),Object.keys(this.formFields).forEach(function(e){return""!==t.formFields[e].value&&""!==t.formFields[e].regex&&!t.formFields[e].regex.test(t.formFields[e].value)&&t.pushMessage(t.formFields[e].id,o.errorMessages.format.replace("${fieldName}",t.formFields[e].fieldName))}),this.dataLayer&&this.dataLayer.push({event:"errorMessage",errorMessageEmail:this.emailErrors[0],errorMessageFirstName:this.firstNameErrors[0],errorMessageLastName:this.lastNameErrors[0],errorMessagePhone:this.phoneErrors[0],errorMessageOther:this.otherErrors[0]}),0==this.errors.length){this.loading=!0;var e="";e="www.planet4.test"===n(location).attr("hostname")?"/wp-json/gplp/v2/leads":"/"+window.location.pathname.split("/")[1]+"/wp-json/gplp/v2/leads",jQuery.post(e,this.formFields,function(e){t.loading=!1,t.counter++,t.dataLayer&&t.dataLayer.push({event:"petitionSignup",gGoal:"Petition Signup",gConsent:t.formFields.consent.value?"optIn":"optOut",gPhone:t.formFields.phone.value?"withPhone":"withoutPhone"}),gsap.timeline({onComplete:function(){jQuery.ajax({url:o.pluginUrl+"bower_components/bodymovin/build/player/lottie_light.min.js",dataType:"script"}).then(function(){t.showThankYouAnimation=!0,window.scrollTo({top:0,behavior:"smooth"}),lottie.loadAnimation({container:t.$refs.animation,renderer:"svg",loop:!1,autoplay:!0,path:o.pluginUrl+"public/json/thank-you.json"}).addEventListener("complete",function(){t.success=!0,t.showThankYouAnimation=!1,Vue.nextTick(function(){gsap.timeline({}).from(".leads-form__thank-you",{y:100,opacity:0,duration:t.animationSpeed}).from(".leads-form__counter",{y:100,opacity:0,duration:t.animationSpeed},"-="+t.animationSpeed/2).from(".leads-form__share",{y:100,opacity:0,duration:t.animationSpeed},"-="+t.animationSpeed/2).from(".leads-form__donate",{y:100,opacity:0,duration:t.animationSpeed,onComplete:t.addBlur()},"-="+t.animationSpeed/2)}),t.dataLayer&&t.dataLayer.push({event:"petitionThankYou",donationOption:"Pre-selected amount to donation"}),document.getElementById("donate-button").addEventListener("click",function(){t.dataLayer&&t.dataLayer.push({event:"petitionDonation",PetitionDonationLink:"Pre-selected amount to donation"})}),document.getElementById("facebook").addEventListener("click",function(){t.dataLayer&&t.dataLayer.push({event:"uaevent",eventAction:"Facebook",eventCategory:"Social Share"})}),document.getElementById("twitter").addEventListener("click",function(){t.dataLayer&&t.dataLayer.push({event:"uaevent",eventAction:"Twitter",eventCategory:"Social Share"})}),document.getElementById("email").addEventListener("click",function(){t.dataLayer&&t.dataLayer.push({event:"uaevent",eventAction:"Email",eventCategory:"Social Share"})}),document.getElementById("whatsapp").addEventListener("click",function(){t.dataLayer&&t.dataLayer.push({event:"uaevent",eventAction:"Whatsapp",eventCategory:"Social Share"})})})})}}).to(".leads-form__content",{y:100,opacity:0,duration:t.animationSpeed}).to(".leads-form__form",{y:100,opacity:0,duration:t.animationSpeed},"-="+t.animationSpeed/2)}).fail(function(e){t.errors.push(e.responseJSON.message),t.otherErrors.push(e.responseJSON.message),t.loading=!1,console.log(e.responseJSON)})}return!1}},limitedText:function(e,t){return e.length>=this.textLimit&&!t?e.substring(0,this.textLimit)+"...":e},lengthClass:function(e){return e.length<10?"under-10":e.length<20?"under-20":e.length<25?"under-25":e.length<30?"under-30":e.length<35?"under-35":e.length<45?"under-45":e.length<60?"under-60":e.length<85?"under-85":95<e.length?"over-95":""},toggleText:function(){var e=this;(new gsap.timeline).to(this.$refs.heroDescription,{opacity:0,duration:.2,onComplete:function(){return e.textOpen=!e.textOpen}}).to(this.$refs.heroDescription,{opacity:1,duration:.25})}}})}n(document).on("ready",function(){0<jQuery(".leads-form").length&&n(".leads-form").each(function(e,t){o(n(t))})}),window.acf&&window.acf.addAction("render_block_preview/type=leads-form",function(e){window.setTimeout(o(e),2e3)})}(jQuery);