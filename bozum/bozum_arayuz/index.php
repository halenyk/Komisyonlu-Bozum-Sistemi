<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bozum İşlemi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: auto;
            overflow: hidden;
            margin-top: 50px;
        }
        #main-header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-bottom: #77aaff 3px solid;
        }
        #main-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .card {
            background: #fff;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            display: block;
            width: 100%;
            background: #333;
            color: #fff;
            border: 0;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background: #555;
        }
    </style>
    <script>
        function hesaplaKomisyon() {
            var miktar = document.getElementById('miktar').value;
            if (miktar) {
                fetch('hesapla_komisyon.php?miktar=' + miktar)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('net_miktar').innerText = 'Net Miktar: ' + data.net_miktar + ' TL (Komisyon Oranı: ' + data.komisyon_orani + '%)';
                        document.getElementById('netMiktarInput').value = data.net_miktar;
                        document.getElementById('komisyonOraniInput').value = data.komisyon_orani;
                    });
            }
        }
    </script>
</head>
<body>
    <header id="main-header">
        <div class="container">
            <h1>Bozum İşlemi</h1>
        </div>
    </header>
    <div class="container">
        <div class="card">
            <form action="devam.php" method="POST">
                <label for="miktar">Bozmak İstediğiniz Miktar (TL):</label>
                <input type="number" id="miktar" name="miktar" required oninput="hesaplaKomisyon()">
                <p id="net_miktar">Net Miktar: </p>
                <input type="hidden" id="netMiktarInput" name="net_miktar">
                <input type="hidden" id="komisyonOraniInput" name="komisyon_orani">
                
                <button type="submit">Devam Et</button>
            </form>
        </div>
    </div>
</body>
</html>
