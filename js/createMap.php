<script>
    var stage, holder;
    var x=<?php echo $villages[$village]['x']?>;
    var y=<?php echo $villages[$village]['y']?>;
    var villages=<?php echo json_encode($all_villages);?>;
    var map =new Array(400);
    function initMap(){
        for(var i=0;i<400;i++) {
            var row=new Array(400);
            villages.forEach(function(village) {
                if(i==village['x']) {
                    row[village['y']] = 1;
                }
            });

            map[i]=row;
        }
        mp(x, y);

    }
    function mp(mx,my) {
        stage = new createjs.Stage("mapCanvas");
        stage.enableMouseOver(20);
        createActors(mx,my);
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
    createActors = function (mx,my) {
        var village = new createjs.Bitmap("resources/graphics/map/v6.png");
        village.x = 280;
        village.y = 180;
        village.on("click", function () {
            //up();
        });
        stage.addChild(village);
        console.log(map[24][120]);
    }


</script>