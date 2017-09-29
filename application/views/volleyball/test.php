<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
    <style>
        #big {
            font-family: 'Amatic SC', cursive;
        }
    </style>
    <script>
        function replacing() {
            document.getElementById('container').style.left = (window.innerWidth - 600) / 2;
            document.getElementById('container').style.top = (window.innerHeight - 600) / 2;
            document.getElementById('big').style.left = (window.innerWidth - 535) / 2;
            document.getElementById('big').style.top = (window.innerHeight - 650) / 2;
            document.getElementById('corp').style.left = (window.innerWidth - 300) / 2;
            document.getElementById('corp').style.top = (window.innerHeight + 500) / 2;
            document.getElementById('run').style.left = (window.innerWidth - 400) / 2;
            document.getElementById('run').style.top = (window.innerHeight + 100) / 2;

//            if(window.innerWidth < 546) window.resizeTo(600,600);
        }
    </script>
</head>
<body onresize="replacing()">
    <div id="container" class="container" style="position:absolute;border:1px solid black;"></div>
    <div id="big" style="position:absolute;top:150px;left:690px;"><h2 style="font-size:75pt;color:deepskyblue;text-shadow:2px 2px #ff0000;">Jerusalem Donkeys</h2></div>
    <div id="corp" style="position:absolute;top:760px;left:800px;"><h2 style="font-size:10pt;color:blanchedalmond;">Copyright JerusalemDonkeys Corp. All rights reserved.</h2></div>
    <div id="run" style="position:absolute;top:500px;left:770px;"><img src="/public/lib/volleyball_image/q.gif" width="400"></div>

    <script type="text/javascript" src="http://jindo.dev.naver.com/collie/deploy/collie.min.js"></script>
    <script type="text/javascript">
        replacing();

        let layer = new collie.Layer({
            width : 600,
            height : 600
        });

        collie.ImageManager.add({
            "ground" : "http://jindo.dev.naver.com/collie/img/small/ground.png",
            "sky" : "http://jindo.dev.naver.com/collie/img/small/sky.png",
            "cloud1" : "http://jindo.dev.naver.com/collie/img/small/cloud1.png",
            "cloud2" : "http://jindo.dev.naver.com/collie/img/small/cloud2.png",
            "cloud3" : "http://jindo.dev.naver.com/collie/img/small/cloud3.png",
            "cloud4" : "http://jindo.dev.naver.com/collie/img/small/cloud4.png"
        });

        let oBackground = new collie.DisplayObject({
            x : 0,
            y : 0,
            width : 600,
            height : 600,
            backgroundRepeat : "repeat", // Repeat X-Axis
            backgroundImage : "sky"
        }).addTo(layer);

        let oGround = new collie.DisplayObject({
            x : 0,
            width : 640 * 2, // Using Double width for continuously horizontal move.
            height : 88,
            velocityX : -80,
            backgroundRepeat : "repeat-x", // Repeat X-Axis
            rangeX : [-640, 0], // This object can move from first position to second position.
            positionRepeat : true, // This object move the other side when It's on one end of the edge.
            backgroundImage : "ground"
        }).bottom(0).addTo(layer);

        let oCloud1 = new collie.DisplayObject({ // 90, 51
            x : 330,
            y : 200,
            velocityX : -70,
            opacity : 0.8,
            backgroundImage : "cloud1",
            positionRepeat : true,
            rangeX : [-90, 600]
        }).addTo(layer);
        let oCloud2 = new collie.DisplayObject({ // 90, 51
            x : 500,
            y : 50,
            velocityX : -10,
            opacity : 0.8,
            backgroundImage : "cloud2",
            positionRepeat : true,
            rangeX : [-90, 600]
        }).addTo(layer);
        let oCloud3 = new collie.DisplayObject({ // 90, 51
            x : 100,
            y : 100,
            velocityX : -20,
            opacity : 0.8,
            backgroundImage : "cloud3",
            positionRepeat : true,
            rangeX : [-90, 600]
        }).addTo(layer);
        let oCloud4 = new collie.DisplayObject({ // 90, 51
            x : 0,
            y : 150,
            velocityX : -50,
            opacity : 0.8,
            backgroundImage : "cloud4",
            positionRepeat : true,
            rangeX : [-90, 600]
        }).addTo(layer);

        collie.Renderer.addLayer(layer);
        collie.Renderer.load(document.getElementById("container"));
        collie.Renderer.start();
    </script>
</body>
</html>