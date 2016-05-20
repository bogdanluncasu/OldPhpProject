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
        createActors(mx-3,my-3,100,50);
        var up = new createjs.Bitmap("resources/graphics/map/up.png");
        up.x = 300;
        up.on("click", function () {
            mp(mx,my-1);
        });
        stage.addChild(up);
        var right = new createjs.Bitmap("resources/graphics/map/right.png");
        right.x = 580;
        right.y = 200;
        right.on("click", function () {
            mp(mx+1,my);
        });
        stage.addChild(right);
        var left = new createjs.Bitmap("resources/graphics/map/left.png");
        left.y = 200;
        left.on("click", function () {
            mp(mx-1,my);
        });
        stage.addChild(left);
        var down = new createjs.Bitmap("resources/graphics/map/down.png");
        down.x = 300;
        down.y = 400;
        down.on("click", function () {
            mp(mx,my+1);
        });
        stage.addChild(down);
        createjs.Ticker.on("tick", stage);
    }
    createActors = function (mx,my,x,y) {
        if(x>450||y>300)return;
        if(map[mx][my]==1) {
            var village = new createjs.Bitmap("resources/graphics/map/v6.png");
            village.on("click", function () {
                console.log("SDASA");
            });
        }else{
            var village = new createjs.Bitmap("resources/graphics/map/gras1.png");

        }
        village.x = x;
        village.y = y;
        createActors(mx+1,my,x+53,y);
        createActors(mx,my+1,x,y+38);
        stage.addChild(village);
    }


</script>