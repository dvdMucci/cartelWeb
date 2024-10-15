<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pantalla Principal</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            cursor: none;
        }
        .container {
            display: flex;
            height: 100%;
        }
        .image-area {
            width: 33%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box-area {
            width: 67%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
        }
        .box {
            width: 45%;
            height: 45%;
            border: 1px solid #000;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 75px; /* Tamaño ajustado para ocupar 3/4 del área */
            position: relative;
            text-align: center;
        }
        .highlight {
            background-color: yellow;
        }
        .blinking {
            animation: blink 1s step-start 0s infinite;
        }
        @keyframes blink {
            50% {
                opacity: 0;
            }
        }
        #message {
            display: none;
            position: absolute;
            top: 50%;
            left: 65%;
            transform: translate(-50%, -50%);
            font-size: 400%; /* Tamaño ajustado para ocupar 3/4 de la pantalla */
            background-color: red;
            color: black;
            padding: 10px;
            border: 2px solid #000;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-area">
            <img id="randomImage" src="" alt="Random Image" style="width: 100%;">
        </div>
        <div class="box-area">
            <div class="box" id="BOX1">BOX 1</div>
            <div class="box" id="BOX2">BOX 2</div>
            <div class="box" id="BOX3">BOX 3</div>
            <div class="box" id="BOX4">BOX 4</div>
        </div>
    </div>
    <div id="message">Pase por BOX</div>
    <script>
        window.addEventListener('load', function() {
            const silentAudio = new Audio('sounds/silent.mp3'); // Archivo de audio vacío o silencioso

            // Intentar reproducir el audio silencioso con un evento simulado
            function simulateClick() {
                const event = new MouseEvent('click', {
                    view: window,
                    bubbles: true,
                    cancelable: true
                });

                document.body.dispatchEvent(event);

                silentAudio.play().catch(error => {
                    console.error('Error playing silent audio:', error);
                });
            }

            // Simular el clic después de un pequeño retraso para asegurar que la página esté completamente cargada
            setTimeout(simulateClick, 1000);
        });

        // Precarga de archivos de audio
        const audioFiles = {
            'BOX1': new Audio('sounds/BOX1.mp3'),
            'BOX2': new Audio('sounds/BOX2.mp3'),
            'BOX3': new Audio('sounds/BOX3.mp3'),
            'BOX4': new Audio('sounds/BOX4.mp3'),
            'Espere': new Audio('sounds/Espere.mp3') // Audio para "Espere"
        };

        const images = <?php echo json_encode(glob("images/*.{jpg,jpeg,png,gif}", GLOB_BRACE)); ?>;

        function showRandomImage() {
            const randomIndex = Math.floor(Math.random() * images.length);
            document.getElementById('randomImage').src = images[randomIndex];
        }

        function highlightBox(boxId) {
            const box = document.getElementById(boxId);
            box.classList.add('blinking');
            setTimeout(() => {
                box.classList.remove('blinking');
            }, 45000); // Resaltar durante 45 segundos
        }

        function showMessage(messageText) {
            const message = document.getElementById('message');
            message.textContent = messageText;
            message.style.display = 'block';
            setTimeout(() => {
                message.style.display = 'none';
            }, 30000); // Mostrar mensaje durante 30 segundos
        }

        function playSound(boxId) {
            const audio = audioFiles[boxId];
            if (audio) {
                audio.currentTime = 0; // Reiniciar el audio
                audio.play().catch(error => {
                    console.error(`Error reproduciendo el audio para ${boxId}:`, error);
                });
            }
        }

        function handleCommand(command) {
            const [action, boxId] = command.split(':');
            if (action === 'highlight') {
                highlightBox(boxId);
                showMessage(`Pase por ${boxId.toUpperCase()}`);
                playSound(boxId);
            } else if (action === 'espere') {
                showMessage("Aguarde a ser llamado");
                playSound('Espere');
            }
        }

        function pollServer() {
            fetch('get_command.php')
                .then(response => response.json())
                .then(data => {
                    if (data.command) {
                        handleCommand(data.command);
                    }
                })
                .catch(error => {
                    console.error('Error consultando el servidor:', error);
                });
            setTimeout(pollServer, 2000);
        }

        showRandomImage();
        setInterval(showRandomImage, 30000); // Cambiar imagen cada 30 segundos
        pollServer();
    </script>
</body>
</html>
