<html>
<head>
    <style type='text/css'>
        body,
        html {
            margin: 0;
            padding: 0;
            background-color: transparent;
            /* Fond transparent */
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: monospace;
            /* Police plus moderne */
            font-size: 24px;
        }

        .container {
            background-image: url("{{asset('assets/fond.jpg')}}");
            border: 20px solid #d8d2bf;
            width: 800px;
            height: 600px;
            background-color: transparent;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            padding: 40px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
        }

        .logo {
            color: #715700;;
            font-weight: normal;
            text-align: center;
        }

        .marquee,
        .assignment,
        .person,
        .reason {
            color: #000;
            font-weight: normal;
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
        }

        .marquee {
            margin-top: 30px;
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            justify-content: center;
        }

        .assignment {
            display: flex;
            justify-content: center;
            font-family: monospace;
        }

        .person {
            border-bottom: 2px solid #000;
            /* Bordure noire pour le nom */
            font-size: 32px;
            font-style: italic;
            margin: 20px auto;
           
        }

        .reason {
            text-align: center;
            font-family: system-ui;
            font-size: 12pt;        
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            ULTIMATE TEAM RACE
        </div>
        <hr style="color: #715700; width: 80%; height: 4px; background: #715700;background-color: #715700;">
        <div class="marquee">
            <img style="height: 139px;" src="{{asset('assets/sary.png')}}" alt="" srcset="">
        </div>

        <div class="assignment">
            Ce certificat est attribué à
        </div>

        <div class="person">
            Joe Nathan
        </div>

        <div class="reason">
            Ce certificat est décerné en reconnaissance de ses efforts, de sa persévérance et de son excellence. Nous saluons sa capacité à relever ce défi physique et mental et à se hisser au sommet avec grâce et courage.
        </div>
        <div class="footer" style="
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: space-between;
    align-items: center;
    ">
            <div class="signature">
                <p>______________</p>
                <p style="text-align: center;">Signature</p>
            </div>
            <div class="detail"></div>
            <div class="date">
                <p>______________</p>
                <p style="text-align: center;">Date</p>
            </div>
        </div>
    </div>
</body>

</html>