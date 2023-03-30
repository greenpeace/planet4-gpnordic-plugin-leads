<?php if ($form_settings['enable_counter']) : ?>
    <div class="leads-form__counter leads-form__counter--success">
        <div class="leads-form__counter__headings">
            <small>Signed up</small>
            <small>Goal</small>
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