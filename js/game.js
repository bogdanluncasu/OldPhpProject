/**
 * Created by bogdan on 4/2/16.
 */

$(document).ready(function () {
    $("#logout").click(
        function () {
            $(location).attr("href", "game/logout");
        }
    );
    $("#home").click(
        function () {
            $(location).attr("href", "game");
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
    
    $("#fight").click(
        function () {
            if ($('#barbar').is(':checked')) {
                var type = 1;
            } else if ($('#smart').is(':checked')) {
                var type = 2;
            } else {
                var type = 3;
            }

            $.post("game/chooseHero", {
                type: type
            }, function (data) {
                if(data=="ok") {
                    console.log("Daaaa");
                    $(location).attr("href", "game");
                }
            });
        });
    $("#attack").click(
        function () {
            x = $("#x").val();
            y = $("#y").val();
            u0 = $("#u0").val();
            u1 = $("#u1").val();
            u2 = $("#u2").val();
            u3 = $("#u3").val();
            u4 = $("#u4").val();
            u5 = $("#u5").val();
            u6 = $("#u6").val();
            u7 = $("#u7").val();
            u8 = $("#u8").val();
            u9 = $("#u9").val();



            $.post("game/attack", {
                x:x, y:y, u0:u0, u1:u1, u2:u2, u3:u3, u4:u4, u5:u5, u6:u6, u7:u7, u8:u8, u9:u9
            }, function (data) {
                console.log(data);
                if(data==1) {
                    $("#error").html("Atacul a fost instantiat!");
                }else if(data==2){
                    $("#error").html("Orasul nu exista!");
                }else  $("#error").html("Nu poti ataca propriul oras!");


            });
        }
    );


});