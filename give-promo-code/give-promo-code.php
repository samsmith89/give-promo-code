<?php
/*
 * Plugin Name: Give Promo Code
 * Plugin URI:
 * Description: This plugin add's promo code functionality to Give donation forms.
 * Version: 1.0
 * Author: Sam Smith
 * Author URI: https://gsamsmith.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * NOTE: This is not a "snippet" but a plugin that you can install and activate. You can put it in a
 * folder in your /plugins/ directory, or even just drop it directly into the /plugins/ directory
 * and it will activate like any other plugin.
 *
 * DISCLAIMER: This is provided as a solution for adding promo code functionality with the current markup of the Give plugin . We provide no
 * guarantees to and updates that Give may make to their plugin. For more information please reference the custom development agreement that was signed by both parties.
 *
 */

function my_give_apply_promo_code()
{
    // have it echo something here just to make sure we got
    ?>
    <script>
        //Define the elements needed, and finds the Promo Code donation level
        const myGiveBtns = document.querySelectorAll('.give-donation-level-btn');
        const myBtnArray = [...myGiveBtns].filter(e => e.innerHTML == "Individual PROMO");
        const myGiveBtn = myBtnArray[0];
        const myBtnArrayTwo = [...myGiveBtns].filter(e => e.innerHTML == "Organization PROMO");
        const myGiveBtnTwo = myBtnArrayTwo[0];

        //Hides the Promo Code donation level on the page
        if (myBtnArray == 0) {} else {
            myGiveBtn.style.display = "none";
            document.querySelector(".promo-div").style.display = "inherit";
        }

        if (myBtnArrayTwo == 0) {} else {
            myGiveBtnTwo.style.display = "none";
            document.querySelector(".promo-div").style.display = "inherit";
        }

        //Checks the value of the Promo Code input
        function checkMath() {
            const x = document.getElementById("give_promo_code").value;
            //Defines the value needed to trigger the Promo Code level selection
            if ((x == "off50") && (myGiveBtn !== undefined)) {
                (function() {
                    myGiveBtn.click();
                    toggleSuccess();
                    const z = document.querySelector(".promo-failed");
                    if (z.style.display === "block") {
                        z.style.display = "none";
                    } else {
                        z.style.display = "none";
                    }
                }());
            }

            if ((x == "off50org") && (myGiveBtnTwo !== undefined)) {
                (function() {
                    myGiveBtnTwo.click();
                    toggleSuccess();
                    const z = document.querySelector(".promo-failed");
                    if (z.style.display === "block") {
                        z.style.display = "none";
                    } else {
                        z.style.display = "none";
                    }
                }());
            } else {
                // toggleFailed();
            };
        };

        //Toggles the display of the Promo Code on the form upon selection
        function togglePromo() {
            const y = document.querySelector("#give-promo-wrap");
            if (y.style.display === "none") {
                y.style.display = "block";
            } else {
                y.style.display = "none";
            }
        }

        //Runs in checkMath(), if the promo code goes through a success message appears
        function toggleSuccess() {
            const z = document.querySelector(".promo-success");
            if (z.style.display === "none") {
                z.style.display = "block";
            } else {
                z.style.display = "none";
            }
        }

        function toggleFailed() {
            const z = document.querySelector(".promo-failed");
            if (z.style.display === "none") {
                z.style.display = "block";
            } else {
                z.style.display = "none";
            }
        }

        //Prevents form submission on "Enter" and applies to Promo Code button
        const promoButton = document.getElementById("give_promo_code");

        if (promoButton !== null) {
            promoButton.onkeypress = function(e) {
                var key = e.charCode || e.keyCode || 0;
                if (key == 13) {
                    e.preventDefault();
                    document.getElementById("promo-button").click();
                }

            }
        } else {}
    </script>
<?php
}



add_action('wp_footer', 'my_give_apply_promo_code');


function give_add_promo_code_field()
{
    ?>
    <p class="promo-failed" style="display: none;">Not a valid Promo code</p>
    <p class="promo-div" style="display: none;"><a href="javascript:void(0);" onclick="togglePromo()" class="promo-toggle"><em>Apply a Promo Code</em></a></p>
    <p id="give-promo-wrap" class="form-row js-give-promo-wrap" style="display: none;">
        <label class="give-label" for="give-promo-code">
            Promo code
            <span class="give-tooltip give-icon give-icon-question" data-tooltip="Please insert a vaild promo code"></span>
        </label>

        <input class="js-give-promo give-input" type="text" name="give_promo_code" id="give_promo_code" style="width: 200px;">
        <button type="button" onclick="checkMath()" id="promo-button" style="margin-top: 18px;">Apply Code</button>
    </p>
    <p class="promo-success" style="display: none;">Promo Code Applied!</p>
<?php
}

add_action('give_payment_mode_before_gateways_wrap', 'give_add_promo_code_field', 10, 2);
