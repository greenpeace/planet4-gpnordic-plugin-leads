(function ($) {
  /**
   * initializeBlock
   *
   * Adds custom JavaScript to the block HTML.
   *
   * @date    15/4/19
   * @since   1.0.1
   *
   * @param   object $block The block jQuery element.
   * @param   object attributes The block attributes (only available when editing).
   * @return  void
   */

  var initializeBlock = ($block) => {
    //console.log($block, jQuery($block).hasClass('leads-form'), $block[0].children[0])
    if (!jQuery($block).hasClass("leads-form")) $block = $block[0].children[0];
    else $block = `#${$block.attr("id")}`;
    // console.log('Initialize Block', `leads_form_${jQuery($block).attr('data-block-id')}`, $block)
    const blockData =
      window[`leads_form_${jQuery($block).attr("data-block-id")}`];
    // console.log('blockData', blockData)

    new Vue({
      el: $block,
      data: {
        formId: jQuery($block).attr("data-form-id"),
        blockData: blockData,
        counter: 0,
        targetCounter: +blockData.counter,
        goal: blockData.counterGoalValue,
        loading: false,
        donateAmount: blockData.donateAmount,
        donateAmountInputValue: null,
        presetDonateAmount: 0,
        errors: [],
        emailErrors: [],
        firstNameErrors: [],
        lastNameErrors: [],
        phoneErrors: [],
        otherErrors: [],
        success: true,
        formFields: blockData.formFields,
        showThankYouAnimation: false,
        animationSpeed: 0.6,
        heroDescription: blockData.heroDescription,
        textLimit: 300,
        textOpen: false,
        display: blockData.display,
        heroTitle: blockData.heroTitle,
        hideInput: blockData.formStyle == "collapse",
        dataLayer: window.dataLayer,
        sourceCode: blockData.sourceCode,
        startedFilling: false,
        // Multistep
        formType: blockData.formType,
        multistepCount: blockData.multistepCount,
        multistepActive: 0,
        multistepCompleted: [],
        multistepViewed: [],
        finalData: blockData.finalData,
        steps: blockData.steps,
      },
      computed: {
        percentReachedGoal: function () {
          return Math.min(
            (+this.counter / +blockData.counterGoalValue) * 100,
            100
          );
        },
        reachedGoal: function () {
          return this.counter >= this.goal;
        },
        thankYouTitle: function () {
          return blockData.thankYouTitle.replace(
            "${fname}",
            this.formFields.fname.value
          );
        },
        hasErrors: function () {
          return this.errors.length > 0;
        },
        moreButtonText: function () {
          if (!this.textOpen) {
            return blockData.readMore;
          }
          return blockData.readLess;
        },
        showReadMore: function () {
          return this.heroDescription.length >= this.textLimit;
        },
        completedAllAsks() {
          return this.multistepCompleted.length === this.multistepCount - 2;
        },
      },
      watch: {
        startedFilling: function () {
          this.dataLayer &&
            this.dataLayer.push({
              event: "petitionFilling",
            });
        },
      },
      mounted: function () {
        if (this.formType !== "multistep")
          this.donateAmountInputValue = this.donateAmount;

        this.dataLayer &&
          this.dataLayer.push({
            sourceCode: this.sourceCode,
            counter: this.blockData.enableCounter ? "yes" : "no",
          });
        gsap
          .timeline({})
          .from(".leads-form__content", {
            y: 100,
            opacity: 0,
            duration: this.animationSpeed,
          })
          .from(
            ".leads-form__main-container",
            { y: 100, opacity: 0, duration: this.animationSpeed },
            `-=${this.animationSpeed / 2}`
          );

        if (
          this.blockData.enableCounter &&
          Array.isArray(this.blockData.counterApiEndpoints)
        ) {
          // fix for the local dev env
          let jQueryPostStrCounter = "";
          if ($(location).attr("hostname") === "www.planet4.test") {
            jQueryPostStrCounter = `/wp-json/gplp/v2/leads/count/${
              this.sourceCode
            }?v=${Date.now()}`;
          } else {
            jQueryPostStrCounter = `/${
              window.location.pathname.split("/")[1]
            }/wp-json/gplp/v2/leads/count/${this.sourceCode}?v=${Date.now()}`;
            //console.log(jQueryPostStrCounter)
          }

          jQuery.get(jQueryPostStrCounter, (count) => {
            // jQuery.get(`/${window.location.pathname.split('/')[1]}/wp-json/gplp/v2/leads/count/${this.sourceCode}?v=${Date.now()}`, (count) => {
            this.targetCounter = count.counter;
            this.blockData.counterApiEndpoints.forEach((e) => {
              if (e && jQuery.trim(e) !== "" && e !== undefined)
                jQuery.get(e, this.formFields, (response) => {
                  this.targetCounter = this.targetCounter + +response.counter;
                  this.animateCounter();
                });
            });
            if (this.blockData.counterApiEndpoints.length == 0)
              this.animateCounter();
          });
        }
      },
      methods: {
        animateCounter: lodash.debounce(function (t = this) {
          var Cont = { val: t.counter },
            NewVal = t.targetCounter;
          TweenLite.to(Cont, 2, {
            val: NewVal,
            roundProps: "val",
            onUpdate: () => {
              t.counter = Cont.val;
            },
          });
        }, 1000),
        setPreset(amount) {
          this.presetDonateAmount = amount;
          this.donateAmount = null;
          this.donateAmountInputValue = null;
        },
        setDonateAmount(event) {
          this.donateAmountInputValue = event.target.value;
          this.donateAmount = event.target.value;
        },
        getDonateUrl: function (url) {
          const amount =
            this.donateAmount && this.donateAmount > 0
              ? this.donateAmount
              : this.presetDonateAmount;
          return url.replace("%amount%", amount);
        },
        hasFieldErrors: function (errorType) {
          return `${errorType}`.length > 0;
        },
        pushMessage: function (key, message) {
          if (key == "email") {
            this.emailErrors.push(message);
          } else if (key == "fname") {
            this.firstNameErrors.push(message);
          } else if (key == "lname") {
            this.lastNameErrors.push(message);
          } else if (key == "phone") {
            this.phoneErrors.push(message);
          } else {
            this.otherErrors.push(message);
          }
          if (!(this.display == "small" && key == "phone")) {
            this.errors.push(message);
          }
        },
        addBlur: function () {
          window.setTimeout(() => {
            this.$refs.bkg.classList.add("blur");
            this.$refs.smallBkg && this.$refs.smallBkg.classList.add("blur");
          }, 800);
        },
        numbersOnly(event) {
          let charCode =
            typeof event.which == "undefined" ? event.keyCode : event.which;
          let charStr = String.fromCharCode(charCode);
          if (!charStr.match(/^[0-9]+$/)) event.preventDefault();
        },
        checkMinVal($event) {
          $event.target.value = Math.max(
            +$event.target.value,
            this.blockData.donateMinimumAmount
          );
        },
        submit: function () {
          if (this.loading) return;
          this.hideInput = false;
          this.errors = [];
          this.emailErrors = [];
          this.firstNameErrors = [];
          this.lastNameErrors = [];
          this.phoneErrors = [];
          this.otherErrors = [];

          Object.keys(this.formFields).forEach(
            (key) =>
              this.formFields[key].value == "" &&
              this.formFields[key].required &&
              this.pushMessage(
                this.formFields[key].id,
                blockData.errorMessages.required.replace(
                  "${fieldName}",
                  this.formFields[key].fieldName
                )
              )
          );
          Object.keys(this.formFields).forEach(
            (key) =>
              this.formFields[key].value !== "" &&
              this.formFields[key].regex !== "" &&
              !this.formFields[key].regex.test(this.formFields[key].value) &&
              this.pushMessage(
                this.formFields[key].id,
                blockData.errorMessages.format.replace(
                  "${fieldName}",
                  this.formFields[key].fieldName
                )
              )
          );

          this.dataLayer &&
            this.dataLayer.push({
              event: "errorMessage",
              errorMessageEmail: this.emailErrors[0],
              errorMessageFirstName: this.firstNameErrors[0],
              errorMessageLastName: this.lastNameErrors[0],
              errorMessagePhone: this.phoneErrors[0],
              errorMessageOther: this.otherErrors[0],
            });

          if (this.errors.length == 0) {
            this.loading = true;
            // fix for the local dev env
            let jQueryPostStr = "";
            if ($(location).attr("hostname") === "www.planet4.test") {
              jQueryPostStr = `/wp-json/gplp/v2/leads`;
            } else {
              jQueryPostStr = `${window.location.origin}/wp-json/gplp/v2/leads`;
            }
            jQuery
              .post(jQueryPostStr, this.formFields, (response) => {
                // jQuery.post(`/${window.location.pathname.split('/')[1]}/wp-json/gplp/v2/leads`, this.formFields, (response) => {
                this.loading = false;
                this.counter++;
                this.dataLayer &&
                  this.dataLayer.push({
                    event: "petitionSignup",
                    gGoal: "Petition Signup",
                    gConsent: this.formFields.consent.value
                      ? "optIn"
                      : "optOut",
                    gPhone: this.formFields.phone.value
                      ? "withPhone"
                      : "withoutPhone",
                  });

                // For multistep
                if (this.formType === "multistep") {
                  gsap
                    .timeline({})
                    .to(".leads-form__multistep__container", {
                      y: 100,
                      opacity: 0,
                      duration: this.animationSpeed,
                      onComplete: () => (this.success = true),
                    })
                    .to(".leads-form__multistep__container", {
                      y: 0,
                      opacity: 1,
                      duration: this.animationSpeed,
                    });
                  this.pushDataLayer("thank_you");
                }
                // Regular
                else {
                  gsap
                    .timeline({
                      onComplete: () => {
                        jQuery
                          .ajax({
                            url: `${blockData.pluginUrl}bower_components/bodymovin/build/player/lottie_light.min.js`,
                            dataType: "script",
                          })
                          .then(() => {
                            this.showThankYouAnimation = true;
                            //window.scrollTo({ top: 0, behavior: 'smooth' })
                            var blockID = jQuery('[id*="leads-form-block_"]')
                              .map(function () {
                                return this.id;
                              })
                              .get();
                            document
                              .querySelector("#" + blockID[0])
                              .scrollIntoView();
                            const a = lottie.loadAnimation({
                              container: this.$refs.animation, // the dom element that will contain the animation
                              renderer: "svg",
                              loop: false,
                              autoplay: true,
                              path: `${blockData.pluginUrl}public/json/thank-you.json`, // the path to the animation json
                            });
                            a.addEventListener("complete", () => {
                              this.success = true;
                              this.showThankYouAnimation = false;

                              Vue.nextTick(() => {
                                gsap
                                  .timeline({})
                                  .from(".leads-form__thank-you", {
                                    y: 100,
                                    opacity: 0,
                                    duration: this.animationSpeed,
                                  })
                                  .from(
                                    ".leads-form__counter",
                                    {
                                      y: 100,
                                      opacity: 0,
                                      duration: this.animationSpeed,
                                    },
                                    `-=${this.animationSpeed / 2}`
                                  )
                                  .from(
                                    ".leads-form__share",
                                    {
                                      y: 100,
                                      opacity: 0,
                                      duration: this.animationSpeed,
                                    },
                                    `-=${this.animationSpeed / 2}`
                                  )
                                  .from(
                                    ".leads-form__donate",
                                    {
                                      y: 100,
                                      opacity: 0,
                                      duration: this.animationSpeed,
                                      onComplete: this.addBlur(),
                                    },
                                    `-=${this.animationSpeed / 2}`
                                  );
                              });

                              const element =
                                document.querySelector("#donate-container");
                              const elementChildren =
                                element.querySelectorAll(".donation-options");
                              let firstElementChild =
                                elementChildren[0].className.split(" ")[0];
                              const donateBtn =
                                document.getElementById("donate-button");
                              switch (firstElementChild) {
                                case "ghost":
                                  this.dataLayer &&
                                    this.dataLayer.push({
                                      event: "petitionThankYou",
                                      sourceCode: this.sourceCode,
                                      stepName: "intro",
                                    });

                                  donateBtn.addEventListener("click", () => {
                                    this.dataLayer &&
                                      this.dataLayer.push({
                                        event: "petitionDonation",
                                        PetitionDonationLink:
                                          "Pre-selected amount to donation",
                                      });
                                  });
                                  break;

                                case "button--submit":
                                  this.dataLayer &&
                                    this.dataLayer.push({
                                      event: "petitionThankYou",
                                      donationOption:
                                        "Direct link to choose amount",
                                    });

                                  donateBtn.addEventListener("click", () => {
                                    this.dataLayer &&
                                      this.dataLayer.push({
                                        event: "petitionDonation",
                                        PetitionDonationLink:
                                          "Direct link to choose amount",
                                      });
                                  });
                                  break;

                                default:
                                  console.log("Nada.");
                                  break;
                              }

                              const fbShare =
                                document.getElementById("facebook");
                              fbShare.addEventListener("click", () => {
                                this.dataLayer &&
                                  this.dataLayer.push({
                                    event: "uaevent",
                                    eventAction: "Facebook",
                                    eventCategory: "Social Share",
                                  });
                              });

                              // const twShare = document.getElementById("twitter");
                              // twShare.addEventListener('click', () =>{
                              //   this.dataLayer && this.dataLayer.push({
                              //     'event': 'uaevent',
                              //     'eventAction': 'Twitter',
                              //     'eventCategory':'Social Share'
                              //   });
                              // });

                              // const eShare = document.getElementById("email");
                              // eShare.addEventListener('click', () =>{
                              //   this.dataLayer && this.dataLayer.push({
                              //     'event': 'uaevent',
                              //     'eventAction': 'Email',
                              //     'eventCategory':'Social Share'
                              //   });
                              // });

                              // const waShare = document.getElementById("whatsapp");
                              // waShare.addEventListener('click', () =>{
                              //   this.dataLayer && this.dataLayer.push({
                              //     'event': 'uaevent',
                              //     'eventAction': 'Whatsapp',
                              //     'eventCategory':'Social Share'
                              //   });
                              // });
                            });
                          });
                      },
                    })
                    .to(".leads-form__content", {
                      y: 100,
                      opacity: 0,
                      duration: this.animationSpeed,
                    })
                    .to(
                      ".leads-form__form",
                      { y: 100, opacity: 0, duration: this.animationSpeed },
                      `-=${this.animationSpeed / 2}`
                    );
                }
              })
              .fail((error) => {
                this.errors.push(error.responseJSON.message);
                this.otherErrors.push(error.responseJSON.message);
                this.loading = false;
              });
          }
          return false;
        },
        limitedText: function (text, open) {
          if (text.length >= this.textLimit && !open) {
            return text.substring(0, this.textLimit) + "...";
          }
          return text;
        },
        lengthClass: function (title) {
          if (title.length < 10) {
            return "under-10";
          }
          if (title.length < 20) {
            return "under-20";
          }
          if (title.length < 25) {
            return "under-25";
          }
          if (title.length < 30) {
            return "under-30";
          }
          if (title.length < 35) {
            return "under-35";
          }
          if (title.length < 45) {
            return "under-45";
          }
          if (title.length < 60) {
            return "under-60";
          }
          if (title.length < 85) {
            return "under-85";
          }
          if (title.length > 95) {
            return "over-95";
          }
          return "";
        },
        toggleText: function () {
          let timeline = new gsap.timeline()
            .to(this.$refs.heroDescription, {
              opacity: 0,
              duration: 0.2,
              onComplete: () => (this.textOpen = !this.textOpen),
            })
            .to(this.$refs.heroDescription, { opacity: 1, duration: 0.25 });
        },
        copyLink(url, stepIndex = undefined) {
          // Implementing the winning A/B test version
          let copyURL = document.createElement("input");

          let setLanguage = window.location.pathname.split("/")[1];
          let $linkCopied = "";

          switch (setLanguage) {
            case "denmark":
              $linkCopied = "Link kopieret!";
              break;
            case "finland":
              $linkCopied = "Linkki kopioitu!";
              break;
            case "norway":
              $linkCopied = "Lenke kopiert!";
              break;
            case "sweden":
              $linkCopied = "Länk kopierad!";
              break;
            default:
              $linkCopied = "Link Copied!";
          }

          document.body.appendChild(copyURL);
          copyURL.value = url;
          copyURL.select();
          document.execCommand("copy");
          document.body.removeChild(copyURL);
          document.querySelector("#copy-link").innerHTML = $linkCopied;

          this.pushDataLayer("action_share", "Copy link");

          if (stepIndex)
            setTimeout(() => {
              this.completeMultistep(stepIndex);
            }, 1000);
        },
        pushDataLayer(key, dynamicValue) {
          if (!key) return;
          let dataObj = {};
          switch (key) {
            case "thank_you":
              dataObj = {
                event: "petitionThankYou",
                sourceCode: this.sourceCode,
                stepName: "intro",
              };
              break;
            case "thank_you_yes":
              dataObj = {
                event: "petitionTYButton",
                buttonName: "yes",
              };
              break;
            case "thank_you_no":
              dataObj = {
                event: "petitionTYButton",
                buttonName: "no",
              };
              break;
            case "share":
              dataObj = {
                event: "petitionThankYou",
                sourceCode: this.sourceCode,
                stepName: "share",
              };
              break;
            case "action_share":
              dataObj = {
                event: "uaEvent",
                eventAction: dynamicValue,
                eventCategory: "Social share",
              };
              break;
            case "donation":
              dataObj = {
                event: "petitionThankYou",
                sourceCode: this.sourceCode,
                stepName: "donationOptions",
              };
              break;
            case "action_donation":
              const donateOption =
                this.donateAmount && this.donateAmount > 0
                  ? this.donateAmountInputValue === null
                    ? "direct link to donation"
                    : "custom amount to donation"
                  : "predefined amount to donation";
              const amount =
                this.donateAmount && this.donateAmount > 0
                  ? this.donateAmount
                  : this.presetDonateAmount;
              dataObj = {
                event: "petitionDonation",
                PetitionDonationLink: donateOption,
                amount: amount,
              };
              break;
            case "custom_ask":
              dataObj = {
                event: "petitionThankYou",
                sourceCode: this.sourceCode,
                stepName: "custom step",
                stepText: `{${this.toKebabCase(dynamicValue)}}`,
              };
              break;
            case "action_custom_ask":
              dataObj = {
                event: "customAsk",
                label: dynamicValue,
              };
              break;
            case "final":
              dataObj = {
                event: "petitionThankYou",
                sourceCode: this.sourceCode,
                stepName: "finalStep",
                stepCompleted: `${this.multistepCompleted.length + 1}/${
                  this.multistepCount - 1
                }`,
              };
              break;
            case "action_final":
              dataObj = {
                event: "checkCampaigns",
              };
              break;
            case "skip_step":
              dataObj = {
                event: "skipStep",
              };
              break;
          }
          this.dataLayer && this.dataLayer.push(dataObj);
        },
        /**
         * Multistep
         */
        goToStep(stepIndex) {
          // Set step to active
          this.multistepActive = stepIndex;

          // Get type of active step for dataLayer
          const activeStepType =
            this.steps.step && this.steps.step[this.multistepActive - 1]
              ? this.steps.step[this.multistepActive - 1].select_step
              : this.multistepActive === this.steps.step.length + 1
              ? "final"
              : null;
          let dynamicValue = null;
          if (activeStepType === "custom_ask")
            dynamicValue = this.steps.custom_ask_headline;
          console.log(activeStepType, dynamicValue);
          this.pushDataLayer(activeStepType, dynamicValue);

          // Mark step as viewed
          if (!this.multistepViewed.includes(stepIndex))
            this.multistepViewed.push(stepIndex);
        },
        disagreeToShare(skipIndex, goToIndex) {
          // Mark share step as viewed, so that it will be displayed as skipped
          this.multistepViewed.push(skipIndex);
          // Set step to active
          this.goToStep(goToIndex);
        },
        wasCompleted(stepIndex) {
          return this.multistepCompleted.includes(stepIndex);
        },
        wasSkipped(stepIndex) {
          return (
            this.multistepViewed.includes(stepIndex) &&
            !this.multistepCompleted.includes(stepIndex) &&
            this.multistepActive !== stepIndex
          );
        },
        completeMultistep(stepIndex) {
          if (!this.multistepCompleted.includes(stepIndex)) {
            this.multistepCompleted.push(stepIndex);
          }
          this.nextStep();
        },
        prevStep() {
          if (this.multistepActive > 0) this.goToStep(this.multistepActive - 1);
        },
        nextStep() {
          if (this.multistepActive < this.multistepCount) {
            this.goToStep(this.multistepActive + 1);
          }
        },
        isFirst(stepIndex) {
          return stepIndex <= 0;
        },
        isLast(stepIndex) {
          return stepIndex >= this.multistepCount - 1;
        },
        toKebabCase(str) {
          return (
            str &&
            str
              .match(
                /[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g
              )
              .map((x) => x.toLowerCase())
              .join("-")
          );
        },
      },
    });
  };

  // Initialize each block on page load (front end).
  document.addEventListener("DOMContentLoaded", () => {
    if (jQuery(".leads-form").length > 0) {
      $(".leads-form").each((index, block) => {
        initializeBlock($(block));
      });
    }
  });

  // Initialize dynamic block preview (editor).
  if (window.acf) {
    window.acf.addAction("render_block_preview/type=leads-form", ($block) => {
      window.setTimeout(initializeBlock($block), 2000);
    });
  }
})(jQuery);
