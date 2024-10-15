<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Control de Boxes</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: repeat(2, 1fr);
            grid-gap: 10px;
            width: 90%;
            height: 90%;
        }
        .button {
            width: 100%;
            height: 100%;
            font-size: 50px;
            background-color: #4CAF50;
            color: white;
            border: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 20px; /* Redondea los bordes del botón */
        }
        .button.blinking {
            animation: blink 1s step-start 0s infinite;
        }
        @keyframes blink {
            50% {
                opacity: 0;
            }
        }
        .button-wide {
            grid-column: span 2; /* Ocupa ambas columnas */
            background-color: #2196F3; /* Color diferente para el botón "Espere" */
        }
    </style>
    <script>
        function sendCommand(boxId) {
            const button = document.getElementById(boxId);
            button.classList.add('blinking');
            setTimeout(() => {
                button.classList.remove('blinking');
            }, 30000); // Parpadeo durante 30 segundos

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "set_command.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("boxId=" + boxId + "&action=highlight");
        }

        function sendEspere() {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "set_command.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("boxId=Espere&action=espere");
        }
    </script>
</head>
<body>
    <div class="container">
        <button class="button" id="BOX1" onclick="sendCommand('BOX1')">Box 1</button>
        <button class="button" id="BOX2" onclick="sendCommand('BOX2')">Box 2</button>
        <button class="button" id="BOX3" onclick="sendCommand('BOX3')">Box 3</button>
        <button class="button" id="BOX4" onclick="sendCommand('BOX4')">Box 4</button>
        <button class="button button-wide" id="ESPERE" onclick="sendEspere()">Espere Llamado</button>
    </div>
</body>
</html>
