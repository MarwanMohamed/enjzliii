/**
 usage:

 add attribute data-validation to any input to activate validation
 and separate each rule by | , you can add your own rules in bottom

 usage example :
 data-validation="required|alphanum_dash|minlength[6]|match[#password]"
 */

var Validator = {
    /*CALL BACK*/
    callback: function (component, msg) {
        if (msg)
            myNoty(msg);
    },
    form_validate_callback: function (elm) {

    },

    /*you can add new rules from here*/

    MESSAGES: {
        /*"fnName":"you errors message include {param} if needed"*/
        "alpha": "%field% value should has only characters",
        "alpha_dash": "%field% value should has only characters or _",
        "num": "%field% value should has only numbers",
        "alphanum": "%field% value should has only characters or numbers",
        "alphanum_dash": "%field% value should has only characters, numbers or _",
        "email": "%field% value should has a valid e-mail",
        "minlength": "%field% value should has length of %param% characters or more",
        "maxlength": "%field% value should has characters of length less than or equal to %param%",
        "required": "%field% is required",
        "match": "%field% does not match previous value",
    },
    /*
     str: input value
     param: rule parameter
     return true if input match condition you want
     */
    alpha: function (str) {
        var regex = /[A-Za-z]+/;
        return str.replace(regex, "").length < 1;
    },
    alpha_dash: function (str) {
        var regex = /[A-Za-z_]+/;
        return str.replace(regex, "").length < 1;
    },
    num: function (str) {
        var regex = /[0-9]+/;
        return str.replace(regex, "").length < 1;
    },
    alphanum: function (str) {
        var regex = /[A-Za-z0-9]+/;
        return str.replace(regex, "").length < 1;
    },
    alphanum_dash: function (str) {
        var regex = /[A-Za-z0-9_]+/;
        return str.replace(regex, "").length < 1;
    },
    email: function (str) {
        /* email regex source:
         http://www.w3resource.com/javascript/form/email-validation.php
         */
        var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return regex.test(str);
    },
    minlength: function (str, param) {
        return str.length >= param;
    },
    maxlength: function (str, param) {
        return str.length <= param;
    },
    required: function (str) {
        return str.length > 0;
    },
    match: function (str, param) {
        return $(param).val() == str;
    },


    /****************************************************************************/
    /**************************VALIDATOR CORE (DON'T EDIT)***********************/
    /****************************************************************************/
    validate: function ($component) {

        //get value of data-validation and split it into array of
        //rules by |
        $rules = $component.data('validation').split("|");
        $fieldtitle = $component.data('validation-title') || $component.attr('placeholder');
        var testClear = true;
        for (i = 0; i < $rules.length; i++) {//example: $rules[i]="fnname[param]"

            $ruleparam = $rules[i].replace("]", "").split("[");//example: {"fnname","param"}
            $fnname = $ruleparam[0];//example: fnname
            $fnparam = "";
            //if rule has parameter get it ex: rulewithparam[param]
            if ($ruleparam.length > 1) {
                $fnparam = $ruleparam[1];
            }

            //if function exists excute it
            if (typeof(window["Validator"][$fnname]) === 'function') {
                //if the function that related to rule not true do the follwoing
                if (Validator.excute($fnname, $fnparam, $component.val()) != true) {

                    //if errors message is not defined show this
                    var msg = "can not reach errors message of rule [" + $fnname + "]"
                    //if errors message defined fetch it and show it
                    if (typeof(window["Validator"]['MESSAGES'][$fnname]) !== 'undefined') {
                        msg = window["Validator"]['MESSAGES'][$fnname]
                            .toString()
                            .replace("%param%", $fnparam)
                            .replace("%field%", $fieldtitle);
                    }

                    //add bootstrap class to show errors
                    $component.closest(".form-group").addClass('has-errors').removeClass("has-success");

                    //disable submit
                    $component.closest('form').find('[type=submit]').addClass('disabled');
                    $component.closest('form').attr('onSubmit', 'return false');

                    //print current errors then stop checking
                    testClear = false;
                    //console.errors(msg);
                    /**/
                    Validator['callback']($component, msg);
                    /**/

                    break;

                } else {

                    //add bootstrap class to show success
                    $component.closest(".form-group").removeClass('has-errors').addClass("has-success");
                    /**/
                    Validator['callback']($component, msg);
                    /**/
                    //enable submit if and only if there is no any exists errors


                }
            } else {
                //add bootstrap class to show errors
                $component.closest(".form-group").addClass('has-errors').removeClass("has-success");

                //disable submit
                $component.closest('form').find('[type=submit]').addClass('disabled');
                $component.closest('form').attr('onSubmit', 'return false');

                testClear = false;

                var emsg = "rule of type [" + $fnname + "] does not exists";

                /**/
                Validator['callback']($component, msg);
                /**/


            }
        }
        return testClear;

    },

    //excute javascript function by it's string name
    excute: function (_fnName, param, strval) {
        return window["Validator"][_fnName](strval.toString(), param.toString());
    },

    init: function () {
        //on any input that have attribute of data-validation

        // when input value changed and input lost focus
        $(document).on('change', '[data-validation]', function () {
            Validator.validate($(this));
        });
        // when form submitted do the following
        $(document).on('submit', '.form', function (e) {
            //submit if submit button does not have .disabled class
                $testClear = true;
                //if there is at least one errors then testClear fail then dnt submit
                $(this).find("[data-validation]").each(function (idx, obj) {
                    $testClear &= (Validator.validate($(obj)))
                });
                if ($testClear) {
                        Validator['form_validate_callback']($(this));
                }
                    e.preventDefault();
                    return false;
                

        });

    },


};
Validator.init();
