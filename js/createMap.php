<script>
    var stage, holder;
    var x=<?php echo $villages[$village]['x']?>;
    var y=<?php echo $villages[$village]['y']?>;
    function init() {
        stage = new createjs.Stage("mapCanvas");
        stage.enableMouseOver(20);
        createActors();
        var up = new createjs.Bitmap("resources/graphics/map/up.png");
        up.x = 300;
        up.on("click", function () {
            console.log(y);
        });
        stage.addChild(up);
        var right = new createjs.Bitmap("resources/graphics/map/right.png");
        right.x = 580;
        right.y = 200;
        right.on("click", function () {
            //up();
        });
        stage.addChild(right);
        var left = new createjs.Bitmap("resources/graphics/map/left.png");
        left.y = 200;
        left.on("click", function () {
            //up();
        });
        stage.addChild(left);
        var down = new createjs.Bitmap("resources/graphics/map/down.png");
        down.x = 300;
        down.y = 400;
        down.on("click", function () {
            //up();
        });
        stage.addChild(down);
        createjs.Ticker.on("tick", stage);
    }
    createActors = function () {

        for (var i = 0; i < 9; i++) {
            var grass = new Array();
            for (var j = 0; j < 9; j++) {
                if(i==5&&j==3)
                    grass[j] = new createjs.Bitmap("resources/graphics/map/v1.png");
                else
                    grass[j] = new createjs.Bitmap("resources/graphics/map/gras1.png");
                grass[j].x = 53 * (j + i) % 472 + 50;
                grass[j].y = 38 * i + 50;
                grass[j].on("click", function () {
                    //up();
                });
                stage.addChild(grass[j]);
            }
        }
    }


</script>