/**
 * Created by bogdan on 4/2/16.
 */
$(document).ready(function () {
    $("#logout").click(
        function () {
            $(location).attr("href", "game/logout");
        }
    );
    $("#smart,#barbar,#mage").click(function () {
        var barbaroffset = $("#barbar").offset();
        var smartoffset = $("#smart").offset();
        var mageoffset = $("#mage").offset();
        if ($("#barbar").is(':checked'))
            $("#fight").offset({top: barbaroffset.top + 20, left: barbaroffset.left});
        if ($("#smart").is(':checked'))
            $("#fight").offset({top: smartoffset.top + 20, left: smartoffset.left});
        if ($("#mage").is(':checked'))
            $("#fight").offset({top: mageoffset.top + 20, left: mageoffset.left});

    });

});