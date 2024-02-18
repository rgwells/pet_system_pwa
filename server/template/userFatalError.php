<?php
// this needs to be styled to produce a generic simple
// popup-like error box for showing a fatal message to the user.
// an additional fixed message can be added

// The variables $title & $text are passed in from the error function
// below is the values passwd in from a bad login:

// $title = "Authentication Error!";
// $text = "The link you followed is invalid. It may have expired. Please get a new link in-world!";
// uncomment the lines above to work on this page directly.

?>
<html lang="en">
<head>
    <title><?php echo $title?></title>
    <style>
    * {box-sizing: border-box;}
    html, body {
        margin: 0;
        padding: 0;
        background-color: #282828;
        font-family: 'Milonga', cursive;
        font-weight: bold;
        /*text-shadow: 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836, 0 0 0.3vw #3b3836;*/
    }
    body {
        display: block;
        
    }
    h1, h2, h3, h4, h5, h6 {
        font-size: 5vw;
    }
    h1, h2, h3, h4, h5, h6, p {
        padding:0;
        margin:0;
    }
    .content {
        position: relative;
        font-size: 4vw;
    }
    .content img {width:100vw;height:auto;}

    .slogan {
        position: absolute;
        top: 72%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        text-align: center;
        background-color: #ffffff66;
        border-radius: 1.5vh;
        padding: 1.4vh 0;
    }
    .rainbow-text {
        background-image: repeating-linear-gradient(45deg, violet, indigo, blue, green, yellow, orange, red, violet);
        text-align: center;
        background-size: 800% 800%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rainbow 8s ease infinite;
    }

    @keyframes rainbow { 
        0%{background-position:0% 50%}
        50%{background-position:100% 25%}
        100%{background-position:0% 50%}
    }
    </style>

</head>
<body  >
    <div class="content">
        <img src="../public/img/frame/logo-pandemon.webp" alt=""/>
        <div class="slogan">
            <h1 id="error_heading" class="rainbow-text">Welcome to<br>Pandemon World!</h1><br>
            <p class="rainbow-text">Please stand by while we load data!</p>
        </di>
    </div>
</body>
</html>
