"use strict";!function(n){function o(t){t=jQuery(t).hasClass("leads-form")?"#"+t.attr("id"):t[0].children[0];var e=window["leads_form_"+jQuery(t).attr("data-block-id")];new Vue({el:t,data:{formId:jQuery(t).attr("data-form-id"),blockData:e,counter:0,targetCounter:+e.counter,goal:e.counterGoalValue,loading:!1,donateAmount:e.donateAmount,donateAmountInputValue:null,presetDonateAmount:0,errors:[],emailErrors:[],firstNameErrors:[],lastNameErrors:[],phoneErrors:[],otherErrors:[],success:!0,formFields:e.formFields,showThankYouAnimation:!1,animationSpeed:.6,heroDescription:e.heroDescription,textLimit:300,textOpen:!1,display:e.display,heroTitle:e.heroTitle,hideInput:"collapse"==e.formStyle,dataLayer:window.dataLayer,sourceCode:e.sourceCode,startedFilling:!1,formType:e.formType,multistepCount:e.multistepCount,multistepActive:0,multistepCompleted:[],multistepViewed:[],finalData:e.finalData,steps:e.steps},computed:{percentReachedGoal:function(){return Math.min(+this.counter/+e.counterGoalValue*100,100)},reachedGoal:function(){return this.counter>=this.goal},thankYouTitle:function(){return e.thankYouTitle.replace("${fname}",this.formFields.fname.value)},hasErrors:function(){return 0<this.errors.length},moreButtonText:function(){return this.textOpen?e.readLess:e.readMore},showReadMore:function(){return this.heroDescription.length>=this.textLimit},completedAllAsks:function(){return this.multistepCompleted.length===this.multistepCount-2}},watch:{startedFilling:function(){this.dataLayer&&this.dataLayer.push({event:"petitionFilling"})}},mounted:function(){var t,e=this;"multistep"!==this.formType&&(this.donateAmountInputValue=this.donateAmount),this.dataLayer&&this.dataLayer.push({sourceCode:this.sourceCode,counter:this.blockData.enableCounter?"yes":"no"}),gsap.timeline({}).from(".leads-form__content",{y:100,opacity:0,duration:this.animationSpeed}).from(".leads-form__main-container",{y:100,opacity:0,duration:this.animationSpeed},"-="+this.animationSpeed/2),this.blockData.enableCounter&&Array.isArray(this.blockData.counterApiEndpoints)&&(t="",t="www.planet4.test"===n(location).attr("hostname")?"/wp-json/gplp/v2/leads/count/"+this.sourceCode+"?v="+Date.now():"/"+window.location.pathname.split("/")[1]+"/wp-json/gplp/v2/leads/count/"+this.sourceCode+"?v="+Date.now(),jQuery.get(t,function(t){e.targetCounter=t.counter,e.blockData.counterApiEndpoints.forEach(function(t){t&&""!==jQuery.trim(t)&&void 0!==t&&jQuery.get(t,e.formFields,function(t){e.targetCounter=e.targetCounter+ +t.counter,e.animateCounter()})}),0==e.blockData.counterApiEndpoints.length&&e.animateCounter()}))},methods:{animateCounter:lodash.debounce(function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:this,e={val:t.counter},o=t.targetCounter;TweenLite.to(e,2,{val:o,roundProps:"val",onUpdate:function(){t.counter=e.val}})},1e3),setPreset:function(t){this.presetDonateAmount=t,this.donateAmount=null,this.donateAmountInputValue=null},setDonateAmount:function(t){this.donateAmountInputValue=t.target.value,this.donateAmount=t.target.value},getDonateUrl:function(t){var e=this.donateAmount&&0<this.donateAmount?this.donateAmount:this.presetDonateAmount;return t.replace("%amount%",e)},hasFieldErrors:function(t){return 0<(""+t).length},pushMessage:function(t,e){("email"==t?this.emailErrors:"fname"==t?this.firstNameErrors:"lname"==t?this.lastNameErrors:"phone"==t?this.phoneErrors:this.otherErrors).push(e),"small"==this.display&&"phone"==t||this.errors.push(e)},addBlur:function(){var t=this;window.setTimeout(function(){t.$refs.bkg.classList.add("blur"),t.$refs.smallBkg&&t.$refs.smallBkg.classList.add("blur")},800)},numbersOnly:function(t){var e=void 0===t.which?t.keyCode:t.which;String.fromCharCode(e).match(/^[0-9]+$/)||t.preventDefault()},checkMinVal:function(t){t.target.value=Math.max(+t.target.value,this.blockData.donateMinimumAmount)},submit:function(){var t,o=this;if(!this.loading)return this.hideInput=!1,this.errors=[],this.emailErrors=[],this.firstNameErrors=[],this.lastNameErrors=[],this.phoneErrors=[],this.otherErrors=[],Object.keys(this.formFields).forEach(function(t){return""==o.formFields[t].value&&o.formFields[t].required&&o.pushMessage(o.formFields[t].id,e.errorMessages.required.replace("${fieldName}",o.formFields[t].fieldName))}),Object.keys(this.formFields).forEach(function(t){return""!==o.formFields[t].value&&""!==o.formFields[t].regex&&!o.formFields[t].regex.test(o.formFields[t].value)&&o.pushMessage(o.formFields[t].id,e.errorMessages.format.replace("${fieldName}",o.formFields[t].fieldName))}),this.dataLayer&&this.dataLayer.push({event:"errorMessage",errorMessageEmail:this.emailErrors[0],errorMessageFirstName:this.firstNameErrors[0],errorMessageLastName:this.lastNameErrors[0],errorMessagePhone:this.phoneErrors[0],errorMessageOther:this.otherErrors[0]}),0==this.errors.length&&(this.loading=!0,t="",t="www.planet4.test"===n(location).attr("hostname")?"/wp-json/gplp/v2/leads":window.location.origin+"/wp-json/gplp/v2/leads",jQuery.post(t,this.formFields,function(t){o.loading=!1,o.counter++,o.dataLayer&&o.dataLayer.push({event:"petitionSignup",gGoal:"Petition Signup",gConsent:o.formFields.consent.value?"optIn":"optOut",gPhone:o.formFields.phone.value?"withPhone":"withoutPhone"}),"multistep"===o.formType?gsap.timeline({}).to(".leads-form__multistep__container",{y:100,opacity:0,duration:o.animationSpeed,onComplete:function(){return o.success=!0}}).to(".leads-form__multistep__container",{y:0,opacity:1,duration:o.animationSpeed}):gsap.timeline({onComplete:function(){jQuery.ajax({url:e.pluginUrl+"bower_components/bodymovin/build/player/lottie_light.min.js",dataType:"script"}).then(function(){o.showThankYouAnimation=!0;var t=jQuery('[id*="leads-form-block_"]').map(function(){return this.id}).get();document.querySelector("#"+t[0]).scrollIntoView(),lottie.loadAnimation({container:o.$refs.animation,renderer:"svg",loop:!1,autoplay:!0,path:e.pluginUrl+"public/json/thank-you.json"}).addEventListener("complete",function(){o.success=!0,o.showThankYouAnimation=!1,Vue.nextTick(function(){gsap.timeline({}).from(".leads-form__thank-you",{y:100,opacity:0,duration:o.animationSpeed}).from(".leads-form__counter",{y:100,opacity:0,duration:o.animationSpeed},"-="+o.animationSpeed/2).from(".leads-form__share",{y:100,opacity:0,duration:o.animationSpeed},"-="+o.animationSpeed/2).from(".leads-form__donate",{y:100,opacity:0,duration:o.animationSpeed,onComplete:o.addBlur()},"-="+o.animationSpeed/2)});var t=document.querySelector("#donate-container").querySelectorAll(".donation-options")[0].className.split(" ")[0],e=document.getElementById("donate-button");switch(t){case"ghost":o.dataLayer&&o.dataLayer.push({event:"petitionThankYou",sourceCode:o.sourceCode,stepName:"intro"}),e.addEventListener("click",function(){o.dataLayer&&o.dataLayer.push({event:"petitionDonation",PetitionDonationLink:"Pre-selected amount to donation"})});break;case"button--submit":o.dataLayer&&o.dataLayer.push({event:"petitionThankYou",donationOption:"Direct link to choose amount"}),e.addEventListener("click",function(){o.dataLayer&&o.dataLayer.push({event:"petitionDonation",PetitionDonationLink:"Direct link to choose amount"})});break;default:console.log("Nada.")}document.getElementById("facebook").addEventListener("click",function(){o.dataLayer&&o.dataLayer.push({event:"uaevent",eventAction:"Facebook",eventCategory:"Social Share"})})})})}}).to(".leads-form__content",{y:100,opacity:0,duration:o.animationSpeed}).to(".leads-form__form",{y:100,opacity:0,duration:o.animationSpeed},"-="+o.animationSpeed/2)}).fail(function(t){o.errors.push(t.responseJSON.message),o.otherErrors.push(t.responseJSON.message),o.loading=!1})),!1},limitedText:function(t,e){return t.length>=this.textLimit&&!e?t.substring(0,this.textLimit)+"...":t},lengthClass:function(t){return t.length<10?"under-10":t.length<20?"under-20":t.length<25?"under-25":t.length<30?"under-30":t.length<35?"under-35":t.length<45?"under-45":t.length<60?"under-60":t.length<85?"under-85":95<t.length?"over-95":""},toggleText:function(){var t=this;(new gsap.timeline).to(this.$refs.heroDescription,{opacity:0,duration:.2,onComplete:function(){return t.textOpen=!t.textOpen}}).to(this.$refs.heroDescription,{opacity:1,duration:.25})},copyLink:function(t){var e=this,o=1<arguments.length&&void 0!==arguments[1]?arguments[1]:void 0,n=document.createElement("input"),i="";switch(window.location.pathname.split("/")[1]){case"denmark":i="Link kopieret!";break;case"finland":i="Linkki kopioitu!";break;case"norway":i="Lenke kopiert!";break;case"sweden":i="Länk kopierad!";break;default:i="Link Copied!"}document.body.appendChild(n),n.value=t,n.select(),document.execCommand("copy"),document.body.removeChild(n),document.querySelector("#copy-link").innerHTML=i,this.dataLayer&&this.dataLayer.push({event:"uaevent",eventAction:"Copy link",eventCategory:"Social Share"}),o&&setTimeout(function(){e.completeMultistep(o)},1e3)},pushDataLayer:function(t,e){if(t){var o={};switch(t){case"thank_you_yes":o={event:"petitionTYButton",buttonName:"yes"};break;case"thank_you_no":o={event:"petitionTYButton",buttonName:"no"};break;case"share":o={event:"petitionThankYou",sourceCode:this.sourceCode,stepName:"share"};break;case"action_share":o={event:"uaEvent",eventAction:e,eventCategory:"Social share"};break;case"donation":o={event:"petitionThankYou",sourceCode:this.sourceCode,stepName:"donationOptions"};break;case"action_donation":o={event:"petitionDonation",PetitionDonationLink:this.donateAmount&&0<this.donateAmount?"custom amount to donation":"predefined amount to donation",amount:this.donateAmount&&0<this.donateAmount?this.donateAmount:this.presetDonateAmount};break;case"custom_ask":o={event:"petitionThankYou",sourceCode:this.sourceCode,stepName:"custom step",stepText:"{"+this.toKebabCase(e)+"}"};break;case"action_custom_ask":o={event:"customAsk",label:e};break;case"final":o={event:"petitionThankYou",sourceCode:this.sourceCode,stepName:"finalStep",stepCompleted:this.multistepCompleted.length+1+"/"+(this.multistepCount-1)};break;case"action_final":o={event:"checkCampaigns"};break;case"skip_step":o={event:"skipStep"}}this.dataLayer&&this.dataLayer.push(o)}},goToStep:function(t){this.multistepActive=t;var e=this.steps.step&&this.steps.step[this.multistepActive-1]?this.steps.step[this.multistepActive-1].select_step:this.multistepActive===this.steps.step.length+1?"final":null,o=null;"custom_ask"===e&&(o=this.steps.custom_ask_headline),this.pushDataLayer(e,o),this.multistepViewed.includes(t)||this.multistepViewed.push(t)},disagreeToShare:function(t,e){this.multistepViewed.push(t),this.multistepActive=e},wasCompleted:function(t){return this.multistepCompleted.includes(t)},wasSkipped:function(t){return this.multistepViewed.includes(t)&&!this.multistepCompleted.includes(t)&&this.multistepActive!==t},completeMultistep:function(t){this.multistepCompleted.includes(t)||this.multistepCompleted.push(t),this.nextStep()},prevStep:function(){0<this.multistepActive&&this.goToStep(this.multistepActive-1)},nextStep:function(){this.multistepActive<this.multistepCount&&this.goToStep(this.multistepActive+1)},isFirst:function(t){return t<=0},isLast:function(t){return t>=this.multistepCount-1},toKebabCase:function(t){return t&&t.match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g).map(function(t){return t.toLowerCase()}).join("-")}}})}document.addEventListener("DOMContentLoaded",function(){0<jQuery(".leads-form").length&&n(".leads-form").each(function(t,e){o(n(e))})}),window.acf&&window.acf.addAction("render_block_preview/type=leads-form",function(t){window.setTimeout(o(t),2e3)})}(jQuery);