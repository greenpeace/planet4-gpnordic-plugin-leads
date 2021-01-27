# Greenpeace Nordic<br>Leads Plugin

This plugin adds a Gutenberg block with a form available in various formats, it also adds a settings page for all forms created with the plugin and a post type (`leads-form`) with unique settings for every form.

### JS and CSS

Front-end stuff like compiled javascript and css etc are stored in the /public folder, don't edit those since they're compiled from scss and js files in **/assets/js/** and **/assets/scss/**.
The plugin uses Vue, jQuery, Lottie and GSAP - all except jQuery are loaded from the modules javascript file found in **/assets/js/modules/leads-form.js**
To compile new js and scss simply install dependecies using `npm i` and then run gulp using `gulp` (this will watch for changes in the js/scss stored in **/assets/** and compile new files on change.)

### Markup

The markup for the form itself is found in **/templates/blocks/leads-form/leads-form.php** (it's not a twig file I know, sorry), there you will also find the data being passed from Wordpress to Vue.

### Posting form

The data that are posted from the form are sent via javascript (**/assets/js/modules/leads-form.js**) to the form-controller found in **lib/controllers/leads-form-controller.php**.