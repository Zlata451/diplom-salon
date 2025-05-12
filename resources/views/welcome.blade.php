<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Салон краси</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(135deg, #f9f9f9, #ffe6f0);
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 3rem;
            color: #e91e63;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 40px;
            max-width: 600px;
        }

        .button {
            display: inline-block;
            padding: 14px 28px;
            margin: 10px;
            font-size: 1.1rem;
            color: white;
            background-color: #e91e63;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .button:hover {
            background-color: #c2185b;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <h1>Ласкаво просимо до нашого салону краси!</h1>
    <p>
        Ми робимо світ красивішим 💄✨<br>
        Запишіться до наших професіоналів та скористайтеся найкращими послугами вже сьогодні!
    </p>

    <a href="{{ route('login') }}" class="button">Вхід</a>
    <a href="{{ route('register') }}" class="button">Реєстрація</a>
</body>
</html>
