/**
 * Debit credit amounts are calculated here after cloning the fields
 */

function amountCalculation() {
    let totalDebit = 0,
        totalCredit = 0;
    $(".dataRow").each(function () {
        let accountType = $(this)
            .children("td")
            .find(".accountType")
            .find(":selected")
            .text();
        let amount = parseInt(
            $(this).children("td").find(".amountField").val()
        );

        if (accountType === "Dr") {
            totalDebit += amount;
        } else {
            totalCredit += amount;
        }
    });
    $("#debitAmount").text(totalDebit);
    $("#creditAmount").text(totalCredit);
}
$("#add").on("click", function () {
    amountCalculation();
});
$("#remove").on("click", function () {
    amountCalculation();
});
