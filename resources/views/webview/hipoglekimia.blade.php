<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gula Darah</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f4f4f4;
        }
        img {
            max-width: 100%; /* Fit image to screen width */
            height: auto; /* Maintain aspect ratio */
            cursor: pointer; /* Change cursor to pointer on hover */
            border-radius: 8px; /* Optional: add some rounding to image corners */
            transition: transform 0.2s; /* Smooth zoom transition */
        }
        .zoomed {
            transform: scale(2); /* Zoom image on click */
        }
    </style>
</head>
<body>
    <div style="padding-top:5px; padding-left:5px; padding-right:5px">
    <img src="https://simanis.codingaja.com/storage/education/hipoglikemia-1.png" >
    <div style="padding-top:5px; padding-left:5px; padding-right:5px">
    <img src="https://simanis.codingaja.com/storage/education/hipoglikemia-2.png" >
    
    <script>
        function zoomImage(img) {
            // Toggle zoom class
            img.classList.toggle('zoomed');

            // Remove zoom when clicking outside the image
            img.onclick = function() {
                img.classList.remove('zoomed');
            };

            // Remove zoom class if clicked anywhere else
            document.addEventListener('click', function(event) {
                if (!img.contains(event.target)) {
                    img.classList.remove('zoomed');
                }
            });
        }
    </script>
</body>