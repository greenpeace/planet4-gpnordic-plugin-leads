"use strict";!function(n){function o(e){e=jQuery(e).hasClass("leads-form")?"#"+e.attr("id"):e[0].children[0];var t=window["leads_form_"+jQuery(e).attr("data-block-id")];new Vue({el:e,data:{formId:jQuery(e).attr("data-form-id"),blockData:t,counter:0,targetCounter:+t.counter,goal:t.counterGoalValue,loading:!1,donateAmount:t.donateAmount,errors:[],emailErrors:[],firstNameErrors:[],lastNameErrors:[],phoneErrors:[],otherErrors:[],success:!1,formFields:t.formFields,showThankYouAnimation:!1,animationSpeed:.6,heroDescription:t.heroDescription,textLimit:300,textOpen:!1,display:t.display,heroTitle:t.heroTitle,hideInput:"collapse"==t.formStyle,dataLayer:window.dataLayer,sourceCode:t.sourceCode,startedFilling:!1},computed:{percentReachedGoal:function(){return Math.min(this.counter/t.counterGoalValue*100,100)},reachedGoal:function(){return this.counter>=this.goal},thankYouTitle:function(){return t.thankYouTitle.replace("${fname}",this.formFields.fname.value)},hasErrors:function(){return 0<this.errors.length},moreButtonText:function(){return this.textOpen?t.readLess:t.readMore},showReadMore:function(){return this.heroDescription.length>=this.textLimit}},watch:{startedFilling:function(){this.dataLayer&&this.dataLayer.push({event:"petitionFilling"})}},mounted:function(){var t=this;if(this.dataLayer&&this.dataLayer.push({sourceCode:this.sourceCode,counter:this.blockData.enableCounter?"yes":"no"}),gsap.timeline({}).from(".leads-form__content",{y:100,opacity:0,duration:this.animationSpeed}).from(".leads-form__form",{y:100,opacity:0,duration:this.animationSpeed},"-="+this.animationSpeed/2),this.blockData.enableCounter&&Array.isArray(this.blockData.counterApiEndpoints)){var e="";e="www.planet4.test"===n(location).attr("hostname")?"/wp-json/gplp/v2/leads/count/"+this.sourceCode+"?v="+Date.now():"/"+window.location.pathname.split("/")[1]+"/wp-json/gplp/v2/leads/count/"+this.sourceCode+"?v="+Date.now(),jQuery.get(e,function(e){t.targetCounter=e.counter,t.blockData.counterApiEndpoints.forEach(function(e){e&&""!==jQuery.trim(e)&&void 0!==e&&jQuery.get(e,t.formFields,function(e){t.targetCounter=t.targetCounter+ +e.counter,t.animateCounter()})}),0==t.blockData.counterApiEndpoints.length&&t.animateCounter()})}},methods:{animateCounter:lodash.debounce(function(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:this,t={val:e.counter},o=e.targetCounter;TweenLite.to(t,2,{val:o,roundProps:"val",onUpdate:function(){e.counter=t.val}})},1e3),getDonateUrl:function(e){return e.replace("%amount%",this.donateAmount)},hasFieldErrors:function(){return 0<(""+this.errorType).length},pushMessage:function(e,t){"email"==e?this.emailErrors.push(t):"fname"==e?this.firstNameErrors.push(t):"lname"==e?this.lastNameErrors.push(t):"phone"==e?this.phoneErrors.push(t):this.otherErrors.push(t),"small"==this.display&&"phone"==e||this.errors.push(t)},addBlur:function(){var e=this;window.setTimeout(function(){e.$refs.bkg.classList.add("blur"),e.$refs.smallBkg&&e.$refs.smallBkg.classList.add("blur")},800)},numbersOnly:function(e){var t=void 0===e.which?e.keyCode:e.which;String.fromCharCode(t).match(/^[0-9]+$/)||e.preventDefault()},checkMinVal:function(e){e.target.value=Math.max(+e.target.value,this.blockData.donateMinimumAmount)},submit:function(){var o=this;if(!this.loading){if(this.hideInput=!1,this.errors=[],this.emailErrors=[],this.firstNameErrors=[],this.lastNameErrors=[],this.phoneErrors=[],this.otherErrors=[],Object.keys(this.formFields).forEach(function(e){return""==o.formFields[e].value&&o.formFields[e].required&&o.pushMessage(o.formFields[e].id,t.errorMessages.required.replace("${fieldName}",o.formFields[e].fieldName))}),Object.keys(this.formFields).forEach(function(e){return""!==o.formFields[e].value&&""!==o.formFields[e].regex&&!o.formFields[e].regex.test(o.formFields[e].value)&&o.pushMessage(o.formFields[e].id,t.errorMessages.format.replace("${fieldName}",o.formFields[e].fieldName))}),this.dataLayer&&this.dataLayer.push({event:"errorMessage",errorMessageEmail:this.emailErrors[0],errorMessageFirstName:this.firstNameErrors[0],errorMessageLastName:this.lastNameErrors[0],errorMessagePhone:this.phoneErrors[0],errorMessageOther:this.otherErrors[0]}),0==this.errors.length){this.loading=!0;var e="";e="www.planet4.test"===n(location).attr("hostname")?"/wp-json/gplp/v2/leads":"/"+window.location.pathname.split("/")[1]+"/wp-json/gplp/v2/leads",jQuery.post(e,this.formFields,function(e){o.loading=!1,o.counter++,o.dataLayer&&o.dataLayer.push({event:"petitionSignup",gGoal:"Petition Signup",gConsent:o.formFields.consent.value?"optIn":"optOut",gPhone:o.formFields.phone.value?"withPhone":"withoutPhone"}),gsap.timeline({onComplete:function(){jQuery.ajax({url:t.pluginUrl+"bower_components/bodymovin/build/player/lottie_light.min.js",dataType:"script"}).then(function(){o.showThankYouAnimation=!0;var e=jQuery('[id*="leads-form-block_"]').map(function(){return this.id}).get();document.querySelector("#"+e[0]).scrollIntoView(),lottie.loadAnimation({container:o.$refs.animation,renderer:"svg",loop:!1,autoplay:!0,path:t.pluginUrl+"public/json/thank-you.json"}).addEventListener("complete",function(){o.success=!0,o.showThankYouAnimation=!1,Vue.nextTick(function(){gsap.timeline({}).from(".leads-form__thank-you",{y:100,opacity:0,duration:o.animationSpeed}).from(".leads-form__counter",{y:100,opacity:0,duration:o.animationSpeed},"-="+o.animationSpeed/2).from(".leads-form__share",{y:100,opacity:0,duration:o.animationSpeed},"-="+o.animationSpeed/2).from(".leads-form__donate",{y:100,opacity:0,duration:o.animationSpeed,onComplete:o.addBlur()},"-="+o.animationSpeed/2)});var e=document.querySelector("#donate-container").querySelectorAll(".donation-options")[0].className.split(" ")[0],t=document.getElementById("donate-button");switch(e){case"ghost":o.dataLayer&&o.dataLayer.push({event:"petitionThankYou",donationOption:"Pre-selected amount to donation"}),t.addEventListener("click",function(){o.dataLayer&&o.dataLayer.push({event:"petitionDonation",PetitionDonationLink:"Pre-selected amount to donation"})});break;case"button--submit":o.dataLayer&&o.dataLayer.push({event:"petitionThankYou",donationOption:"Direct link to choose amount"}),t.addEventListener("click",function(){o.dataLayer&&o.dataLayer.push({event:"petitionDonation",PetitionDonationLink:"Direct link to choose amount"})});break;default:console.log("Nada.")}document.getElementById("facebook").addEventListener("click",function(){o.dataLayer&&o.dataLayer.push({event:"uaevent",eventAction:"Facebook",eventCategory:"Social Share"})}),document.getElementById("twitter").addEventListener("click",function(){o.dataLayer&&o.dataLayer.push({event:"uaevent",eventAction:"Twitter",eventCategory:"Social Share"})}),document.getElementById("email").addEventListener("click",function(){o.dataLayer&&o.dataLayer.push({event:"uaevent",eventAction:"Email",eventCategory:"Social Share"})}),document.getElementById("whatsapp").addEventListener("click",function(){o.dataLayer&&o.dataLayer.push({event:"uaevent",eventAction:"Whatsapp",eventCategory:"Social Share"})})})})}}).to(".leads-form__content",{y:100,opacity:0,duration:o.animationSpeed}).to(".leads-form__form",{y:100,opacity:0,duration:o.animationSpeed},"-="+o.animationSpeed/2)}).fail(function(e){o.errors.push(e.responseJSON.message),o.otherErrors.push(e.responseJSON.message),o.loading=!1})}return!1}},limitedText:function(e,t){return e.length>=this.textLimit&&!t?e.substring(0,this.textLimit)+"...":e},lengthClass:function(e){return e.length<10?"under-10":e.length<20?"under-20":e.length<25?"under-25":e.length<30?"under-30":e.length<35?"under-35":e.length<45?"under-45":e.length<60?"under-60":e.length<85?"under-85":95<e.length?"over-95":""},toggleText:function(){var e=this;(new gsap.timeline).to(this.$refs.heroDescription,{opacity:0,duration:.2,onComplete:function(){return e.textOpen=!e.textOpen}}).to(this.$refs.heroDescription,{opacity:1,duration:.25})}}})}document.addEventListener("DOMContentLoaded",function(){0<jQuery(".leads-form").length&&n(".leads-form").each(function(e,t){o(n(t))})}),window.acf&&window.acf.addAction("render_block_preview/type=leads-form",function(e){window.setTimeout(o(e),2e3)})}(jQuery);