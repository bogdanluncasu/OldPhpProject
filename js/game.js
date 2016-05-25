/**
 * Created by bogdan on 4/2/16.
 */
$(document).ready(function () {
    
    $("#logout").click(
        function () {
            $(location).attr("href", "game/logout");
            logout();
        }
    );
    $("#home").click(
        function () {
            $(location).attr("href", "game");
        }
    );
    $("#search").on('input', function (){
        var search=$("#search");
        var pages=$("#rankPages");
        var tbody=$("#table tbody");
        $.post("game/getRankings", {
        }, function (data) {
            var array = JSON.parse(data);
            var result=JSON.parse("[]");
            var el=0;
            $.each(array, function(i, v) {
                if ((v.username).indexOf(search.val())!=-1) {
                    result[el]=v;
                    el++;
                }
            });
            $.post("game?open=ranking", {
                json: result
            }, function (data) {
                var parser=new window.DOMParser();
                var xml=parser.parseFromString(data, "text/xml");
                path="/html/body/div/div/table/tbody";
                if (document.implementation && document.implementation.createDocument)
                {
                    var nodes=xml.evaluate(path, xml, null, XPathResult.ANY_TYPE, null);
                    var result=nodes.iterateNext();
                    if(result!=null) {
                        var html = $(result);
                        tbody.replaceWith(html.prop('outerHTML'));
                    }else{
                        alert("Your browser does not support search widget");
                    }
                }

            });
        });





       console.log(search.val());
    });
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
                    $(location).attr("href", "game");
                }
            });
        });
    $("#createAlliance").click(
        function () {
            name=$("#allianceName").val();
            $.post("game/createAlliance", {
                name:name
            }, function (data) {
                if(data==1) {
                    location.href = '../../game?open=alliance';
                }else{
                    alert("Alliance exists");
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
                    alert("Empty coordinates..");
                }else if(data==4){
                    alert("You need more units..");
                }else  alert("You can not attack your own town!");
            });
        }
    );

});
equip=function(item){
    $.post("game/equipItem", {
        item:item
    }, function (data) {
            location.href = '../../game?open=fair';
        });
}
removeFromAlliance=function(i,id){
    var row=$("#ally"+i);
    $.post("game/removeFromAlliance", {
        id:id
    }, function (data) {
        row.remove();
    });
}
removeRequestFromAlliance=function(i,id){
    var row=$("#req"+i);
    $.post("game/removeRequestFromAlliance", {
        id:id
    }, function (data) {
        row.remove();
    });
}
addToAlliance=function(i,id){
    var row=$("#req"+i);
    $.post("game/addToAlliance", {
        id:id
    }, function (data) {
        location.href = '../../game?open=alliance';
    });
}
apply=function(id){
    $.post("game/applyToAlliance", {
        id:id
    }, function (data) {
        location.href = '../../game?open=alliance';
    });
}
abolishAlliance=function(id){
    $.post("game/abolishAlliance", {
        id:id
    }, function (data) {
        location.href = '../../game?open=alliance';
    });
}