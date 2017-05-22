/************************************/
/*    NavBar                        */
/************************************/



/************************************/
/*    Select edit answer et asker   */
/************************************/
$(document).ready(function () {
    $('#insead_turkeybundle_answer_gender').selectpicker();
    $('#insead_turkeybundle_answer_birthdate_day').selectpicker();
    $('#insead_turkeybundle_answer_birthdate_month').selectpicker();
    $('#insead_turkeybundle_answer_birthdate_year').selectpicker();
    $('#insead_turkeybundle_asker_annual').selectpicker();
});


/************************************/
/*    info bulle initialisation     */
/************************************/
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
