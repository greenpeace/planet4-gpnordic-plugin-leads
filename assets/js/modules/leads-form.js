(function ($) {
  /**
   * initializeBlock
   *
   * Adds custom JavaScript to the block HTML.
   *
   * @date    15/4/19
   * @since   1.0.0
   *
   * @param   object $block The block jQuery element.
   * @param   object attributes The block attributes (only available when editing).
   * @return  void
   */

  var initializeBlock = ($block) => {
    // console.log($block, jQuery($block).hasClass('leads-form'), $block[0].children[0])
    if (!jQuery($block).hasClass('leads-form'))
      $block = $block[0].children[0]
    else
      $block = `#${$block.attr('id')}`
    // console.log('Initialize Block', `leads_form_${jQuery($block).attr('data-block-id')}`, $block)
    const blockData = window[`leads_form_${jQuery($block).attr('data-block-id')}`]
    // console.log('blockData', blockData)

    new Vue({
      el: $block,
      data: {
        formId: jQuery($block).attr('data-form-id'),
        blockData: blockData,
        counter: 0,
        targetCounter: +blockData.counter,
        goal: blockData.counterGoalValue,
        loading: false,
        donateAmount: blockData.donateAmount,
        errors: [],
        emailErrors: [],
        firstNameErrors: [],
        lastNameErrors: [],
        phoneErrors: [],
        otherErrors: [],
        success: false,
        formFields: blockData.formFields,
        showThankYouAnimation: false,
        animationSpeed: 0.6,
        heroDescription: blockData.heroDescription,
        textLimit: 300,
        textOpen: false,
        display: blockData.display,
        heroTitle: blockData.heroTitle,
        hideInput: blockData.formStyle == 'collapse',
        dataLayer: window.dataLayer,
        sourceCode: blockData.sourceCode,
        startedFilling: false,
      },
      computed: {
        percentReachedGoal: function () {
          return Math.min((+this.counter / +blockData.counterGoalValue) * 100, 100);
        },
        reachedGoal: function () {
          return this.counter >= this.goal
        },
        thankYouTitle: function () {
          return blockData.thankYouTitle.replace('${fname}', this.formFields.fname.value)
        },
        hasErrors: function () {
          return this.errors.length > 0
        },
        moreButtonText: function () {
          if (!this.textOpen) {
            return blockData.readMore
          }
          return blockData.readLess
        },
        showReadMore: function () {
          return this.heroDescription.length >= this.textLimit
        },
      },
      watch: {
        startedFilling: function () {
          this.dataLayer && this.dataLayer.push({
            'event': 'petitionFilling'
          });
        }
      },
      mounted: function () {
        this.dataLayer && this.dataLayer.push({
          'sourceCode': this.sourceCode,
          'counter': this.blockData.enableCounter ? 'yes' : 'no'
        });
        gsap.timeline({})
          .from(".leads-form__content", { y: 100, opacity: 0, duration: this.animationSpeed })
          .from(".leads-form__form", { y: 100, opacity: 0, duration: this.animationSpeed }, `-=${this.animationSpeed / 2}`)

        if (this.blockData.enableCounter && Array.isArray(this.blockData.counterApiEndpoints)) {
          this.blockData.counterApiEndpoints.forEach(e => {
            if (e && jQuery.trim(e) !== '' && e !== undefined)
              jQuery.get(e, this.formFields, (response) => {
                this.targetCounter = this.targetCounter + +response.counter
                this.animateCounter()
              })
          })
          if (this.blockData.counterApiEndpoints.length == 0)
            this.animateCounter()
        }
      },
      methods: {
        animateCounter: lodash.debounce(function (t = this) {
          console.log('Updating counter')
          var Cont = { val: t.counter }, NewVal = t.targetCounter;
          TweenLite.to(Cont, 2, {
            val: NewVal, roundProps: "val", onUpdate: () => {
              t.counter = Cont.val
            }
          });
        }, 1000),
        getDonateUrl: function (url) {
          return url.replace("%amount%", this.donateAmount)
        },
        hasFieldErrors: function (errorType) {
          return `${this.errorType}`.length > 0
        },
        pushMessage: function (key, message) {
          if (key == 'email') {
            this.emailErrors.push(message)
          } else if (key == 'fname') {
            this.firstNameErrors.push(message)
          } else if (key == 'lname') {
            this.lastNameErrors.push(message)
          } else if (key == 'phone') {
            this.phoneErrors.push(message)
          } else {
            this.otherErrors.push(message)
          }
          if (!(this.display == 'small' && key == 'phone')) {
            this.errors.push(message)
          }
        },
        addBlur: function () {
          window.setTimeout(() => {
            this.$refs.bkg.classList.add('blur');
            this.$refs.smallBkg && this.$refs.smallBkg.classList.add('blur');
          }, 800)
        },
        numbersOnly(event) {
          let charCode = (typeof event.which == "undefined") ? event.keyCode : event.which;
          let charStr = String.fromCharCode(charCode);
          if (!charStr.match(/^[0-9]+$/))
            event.preventDefault();
        },
        checkMinVal($event) {
          $event.target.value = Math.max(+$event.target.value, this.blockData.donateMinimumAmount)
        },
        submit: function () {
          if (this.loading)
            return
          this.hideInput = false
          this.errors = []
          this.emailErrors = []
          this.firstNameErrors = []
          this.lastNameErrors = []
          this.phoneErrors = []
          this.otherErrors = []

          Object.keys(this.formFields).forEach(key => this.formFields[key].value == '' && this.formFields[key].required && this.pushMessage(this.formFields[key].id, blockData.errorMessages.required.replace('${fieldName}', this.formFields[key].fieldName)))
          Object.keys(this.formFields).forEach(key => this.formFields[key].value !== '' && this.formFields[key].regex !== '' && !this.formFields[key].regex.test(this.formFields[key].value) && this.pushMessage(this.formFields[key].id, blockData.errorMessages.format.replace('${fieldName}', this.formFields[key].fieldName)))

          if (this.errors.length == 0) {
            this.loading = true
            jQuery.post(`/wp-json/gplp/v1/leads`, this.formFields, (response) => {
              this.loading = false
              this.counter++
              this.dataLayer && this.dataLayer.push({
                'event': 'petitionSignup',
                'gGoal': 'Petition Signup',
                'gConsent': this.formFields.consent.value ? 'optin' : 'optout',
                'gPhone': 'withPhone'
              });

              gsap.timeline({
                onComplete: () => {
                  jQuery.ajax({
                    url: `${blockData.pluginUrl}bower_components/bodymovin/build/player/lottie_light.min.js`,
                    dataType: "script",
                  }).then(() => {
                    this.showThankYouAnimation = true
                    window.scrollTo({ top: 0, behavior: 'smooth' })
                    const a = lottie.loadAnimation({
                      container: this.$refs.animation, // the dom element that will contain the animation
                      renderer: 'svg',
                      loop: false,
                      autoplay: true,
                      path: `${blockData.pluginUrl}public/json/thank-you.json`, // the path to the animation json
                    })
                    a.addEventListener('complete', () => {
                      this.success = true
                      this.showThankYouAnimation = false
                      Vue.nextTick(() => {
                        gsap.timeline({})
                          .from(".leads-form__thank-you", { y: 100, opacity: 0, duration: this.animationSpeed })
                          .from(".leads-form__counter", { y: 100, opacity: 0, duration: this.animationSpeed }, `-=${this.animationSpeed / 2}`)
                          .from(".leads-form__share", { y: 100, opacity: 0, duration: this.animationSpeed }, `-=${this.animationSpeed / 2}`)
                          .from(".leads-form__donate", { y: 100, opacity: 0, duration: this.animationSpeed, onComplete: this.addBlur() }, `-=${this.animationSpeed / 2}`)
                      })
                    })
                  })
                }
              })
                .to(".leads-form__content", { y: 100, opacity: 0, duration: this.animationSpeed })
                .to(".leads-form__form", { y: 100, opacity: 0, duration: this.animationSpeed }, `-=${this.animationSpeed / 2}`)
            }).fail((error) => {
              this.errors.push(error.responseJSON.message)
              this.otherErrors.push(error.responseJSON.message)
              this.loading = false
              console.log(error.responseJSON)
            })
          }
          return false
        },
        limitedText: function (text, open) {
          if (text.length >= this.textLimit && !open) {
            return text.substring(0, this.textLimit) + "..."
          }
          return text
        },
        lengthClass: function (title) {
          if (title.length < 10) {
            return 'under-10'
          }
          if (title.length < 20) {
            return 'under-20'
          }
          if (title.length < 25) {
            return 'under-25'
          }
          if (title.length < 30) {
            return 'under-30'
          }
          if (title.length < 35) {
            return 'under-35'
          }
          if (title.length < 45) {
            return 'under-45'
          }
          if (title.length < 60) {
            return 'under-60'
          }
          if (title.length < 85) {
            return 'under-85'
          }
          if (title.length > 95) {
            return 'over-95'
          }
          return ''
        },
        toggleText: function () {
          let timeline = new gsap.timeline()
            .to(this.$refs.heroDescription, { opacity: 0, duration: 0.2, onComplete: () => this.textOpen = !this.textOpen })
            .to(this.$refs.heroDescription, { opacity: 1, duration: 0.25 })
        }
      }
    })
  }

  // Initialize each block on page load (front end).
  $(document).on('ready', () => {
    if (jQuery('.leads-form').length > 0) {
      $('.leads-form').each((index, block) => {
        initializeBlock($(block))
      })
    }
  })

  // Initialize dynamic block preview (editor).
  if (window.acf) {
    window.acf.addAction('render_block_preview/type=leads-form', ($block) => {
      window.setTimeout(initializeBlock($block), 2000)
    })
  }

})(jQuery)
