<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="<?php echo JS_URL; ?>jquery-2.1.3.min.js"></script>
        <script src="<?php echo JS_URL; ?>RTCMultiConnection.js"></script>
        <script src="<?php echo JS_URL; ?>socketio.js"></script>
        <script>
        // ......................................................
        // ..................RTCMultiConnection Code.............
        // ......................................................

        var connection = new RTCMultiConnection();

        connection.session = {
           video:true,
           audio:true,
           oneway: true
       };

       connection.sdpConstraints.mandatory = {
           OfferToReceiveAudio: false,
           OfferToReceiveVideo: false
       };

        connection.onstream = function(event) {
            $("#connecting").hide();
            document.body.appendChild(event.mediaElement);
            scaleVideos();
        };
        connection.socketURL = "https://<?php echo HOST_IP; ?>:9001";
        connection.join("class<?php echo $classID;?>Cam");

        function scaleVideos() {
            var videos = document.querySelectorAll('video'),
                length = videos.length,
                video;
            var minus = 60;
            var windowHeight = 440;
            var windowWidth = 440;
            var windowAspectRatio = windowWidth / windowHeight;
            var videoAspectRatio = 16 / 9;
            var blockAspectRatio;
            var tempVideoWidth = 0;
            var maxVideoWidth = 0;


            for (var i = length; i > 0; i--) {
                blockAspectRatio = i * videoAspectRatio / Math.ceil(length / i);
                if (blockAspectRatio <= windowAspectRatio) {
                    tempVideoWidth = videoAspectRatio * windowHeight / Math.ceil(length / i);
                } else {
                    tempVideoWidth = windowWidth / i;
                }
                if (tempVideoWidth > maxVideoWidth)
                    maxVideoWidth = tempVideoWidth;
            }
            for (var i = 0; i < length; i++) {
                video = videos[i];
                if (video)
                    video.width = maxVideoWidth - minus;
            }
        }
        window.onresize = scaleVideos;
        </script>
    </head>
    <body style="margin:0">
    <div align="center" id="connecting"><h4>连 接 中 . . .</h4></div>
    </body>
</html>
