<script>
   

    var stage, holder;
    function initGame() {
        stage = new createjs.Stage("gameCanvas");
        stage.enableMouseOver(20);
//Background added  ##################
        var background = new createjs.Bitmap("resources/graphics/back_none.jpg");
        stage.addChild(background);

        var main= new createjs.Bitmap("resources/graphics/main.gif");
            main.x=291;
            main.y=109;
        stage.addChild(main);
        main.on("click",function(){
            $(location).attr("href","game?open=main&village=<?php echo $village;?>");
        });

        var farm = new createjs.Bitmap("resources/graphics/farm.png");
        stage.addChild(farm);
        farm.x=450;
        farm.on("click",function(){
            $(location).attr("href","game?open=farm&village=<?php echo $village;?>");
        });


        var iron = new createjs.Bitmap("resources/graphics/iron.png");
        stage.addChild(iron);
        iron.x=10;
        iron.y=10;
        iron.on("click",function(){
            alert(<?php echo $villages[$village]['mina'];?>)
        });

        <?php if($villages[$village]['cazarma']>0){ ?>
            var cazarma = new createjs.Bitmap("resources/graphics/barracks.png");
            stage.addChild(cazarma);
            cazarma.x=380;
            cazarma.y=220;
            cazarma.on("click",function(){
                $(location).attr("href","game?open=barracks&village=<?php echo $village;?>");
            });
        <?php } ?>

        <?php if($villages[$village]['zid']>0){ ?>
        var zid = new createjs.Bitmap("resources/graphics/wall.png");
        stage.addChild(zid);
        zid.x=390;
        zid.y=300;
        zid.on("click",function(){
            alert(<?php echo $villages[$village]['zid'];?>)
        });
        <?php } ?>

        <?php if($villages[$village]['targ']>0){ ?>
        var fairy = new createjs.Bitmap("resources/graphics/market.png");
        stage.addChild(fairy);
        fairy.x=260;
        fairy.y=190;
        fairy.on("click",function(){
            $(location).attr("href","game?open=fair&village=<?php echo $village;?>");
        });
        <?php } ?>
        <?php if($villages[$village]['guvern']>0){ ?>
        var gouvern = new createjs.Bitmap("resources/graphics/gouvern.png");
        stage.addChild(gouvern);
        gouvern.x=90;
        gouvern.y=200;
        gouvern.on("click",function(){
            $(location).attr("href","game?open=government&village=<?php echo $village;?>");
        });
        <?php } ?>
        createjs.Ticker.on("tick", stage);
    }


</script>