<script>
   

    var stage, holder;
    function initGame() {
        stage = new createjs.Stage("gameCanvas");
        stage.enableMouseOver(20);

        var background = new createjs.Bitmap("resources/graphics/back_none.jpg");
        stage.addChild(background);
        var main = new createjs.Bitmap("resources/graphics/main1.gif");
        stage.addChild(main);
        main.x=291;
        main.y=109;
        main.on("click",function(){
            alert(<?php echo $villages[$village]['mainBuilding'];?>)
        });
        var farm = new createjs.Bitmap("resources/graphics/farm2.png");
        stage.addChild(farm);
        farm.x=450;
        farm.on("click",function(){
            alert(<?php echo $villages[$village]['ferma']; ?>)
        });
        <?php if($villages[$village]['mina']>5){ ?>
        var iron = new createjs.Bitmap("resources/graphics/iron2.png");
        stage.addChild(iron);
        <?php } else if($villages[$village]['mina']<=5){ ?>
        var iron = new createjs.Bitmap("resources/graphics/iron1.png");
        stage.addChild(iron);
        <?php } ?>
        iron.x=20;
        iron.y=48;

        iron.name="Mina";
        iron.title="Mina";
        iron.on("click",function(){
            alert(<?php echo $villages[$village]['mina'];?>)
        });

        createjs.Ticker.on("tick", stage);
    }


</script>