<div class="leads-form__form" v-show="!success">
    <?php if ($form_settings['enable_counter']) : ?>
        <div class="leads-form__counter">
            <div class="leads-form__counter__headings">
                <small><?php echo $form_fields_translations['signed_up']; ?></small>
                <small><?php echo $form_fields_translations['goal']; ?></small>
            </div>
            <div class="leads-form__counter__values">
                <p>{{counter}}</p>
                <p>{{blockData.counterGoalValue}}</p>
            </div>

            <div class="leads-form__counter__progress">
                <div class="leads-form__counter__progress__bar" :style="{ width: `${percentReachedGoal}%` }" :class="{ 'done' : reachedGoal }"></div>
            </div>
        </div>
    <?php endif; ?>
    <div class="leads-form__form__container">
        <?php if ($form_status !== 'publish') : ?>
            <div class="leads-form__test">This form is not live!</div>
        <?php endif; ?>
        <?php if ($display != 'small') : ?>
            <h3><?php echo $form_settings['headline']; ?></h3>
            <?php echo $form_settings['description']; ?>
        <?php endif; ?>
        <div>
            <div class="input-container">
                <input @focus="hideInput = false; startedFilling = true" class="input--icon" type="email" name="email" placeholder="<?php echo $form_fields_translations['email']; ?>*" v-model="formFields.email.value" @keyup.enter="submit" />
                <?php GPPL4\svg_icon('email'); ?>
            </div>
            <div v-if="hasFieldErrors(emailErrors)" class="input-container__error">
                <ul>
                    <li v-for="(error, index) in emailErrors" :key="index" v-html="error"></li>
                </ul>
            </div>
        </div>
        <div>
            <div class="overflow-hidden">
                <transition name="fade">
                    <div class="input-container name" v-show="!hideInput">
                        <input class="fname input--icon" type="text" name="fname" placeholder="<?php echo $form_fields_translations['first_name']; ?>*" v-model="formFields.fname.value" @keyup.enter="submit" />
                        <?php GPPL4\svg_icon('user'); ?>
                    </div>
                </transition>
                <transition name="fade">
                    <div class="input-container name" v-show="!hideInput">
                        <input class="lname" type="text" name="lname" placeholder="<?php echo $form_fields_translations['last_name']; ?>*" v-model="formFields.lname.value" @keyup.enter="submit" />
                    </div>
                </transition>
            </div>
            <div v-if="hasFieldErrors(firstNameErrors) || hasFieldErrors(lastNameErrors)" class="input-container__error">
                <ul>
                    <li v-for="(error, index) in firstNameErrors" :key="index" v-html="error"></li>
                    <li v-for="(error, index) in lastNameErrors" :key="index" v-html="error"></li>
                </ul>
            </div>
        </div>
        <?php if ($form_settings['phone'] !== 'false' && $display != 'small') : ?>
            <transition name="fade">
                <div v-show="!hideInput">
                    <div class="input-container phone">
                        <input class="countrycode" type="text" name="phone-countrycode" disabled placeholder="<?php echo $form_fields_translations['country_code']; ?>" value="<?php echo $form_fields_translations['country_code']; ?>">
                        <input class="input--icon" type="tel" name="phone" placeholder="<?php echo $form_fields_translations['phone']; ?><?php echo $form_settings['phone'] == 'required' ? '*' : ''; ?>" v-model="formFields.phone.value" @keyup.enter="submit" />
                        <?php GPPL4\svg_icon('phone'); ?>

                    </div>
                    <div v-if="hasFieldErrors(phoneErrors)" class="input-container__error">
                        <ul>
                            <li v-for="(error, index) in phoneErrors" :key="index" v-html="error"></li>
                        </ul>
                    </div>
                </div>
            </transition>
        <?php endif; ?>
        <?php if ($form_settings['consent_method'] !== 'assumed') : ?>
            <div class="checkbox-container">
                <div class="checkbox">
                    <input type="checkbox" name="terms" v-model="formFields.consent.value" />
                    <span class="checkbox__box">
                        <?php GPPL4\svg_icon('check'); ?>
                    </span>
                    <span class="checkbox-label">
                        <?php echo $form_settings['consent_message'] !== '' ? $form_settings['consent_message'] : $form_fields_translations['terms_agree']; ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
        <a @click="submit" class="button button--submit">
            <span v-if="!loading"><?php GPPL4\svg_icon('send-message'); ?></span>
            <span v-html="loading ? '<?php echo $form_fields_translations['sending']; ?>' : '<?php echo addslashes($form_settings['call_to_action']); ?>'"></span>
        </a>
        <?php if ($form_settings['consent_method'] === 'assumed') : ?>
            <small><?php echo $form_settings['consent_message'] !== '' ? $form_settings['consent_message'] : $form_fields_translations['terms_agree']; ?></small>
        <?php endif; ?>
    </div>
</div>