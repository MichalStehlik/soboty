<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
                background-color: #B0BEC5;
                font-family: sans-serif;
            }
            #page {
                width: 500px;
                margin: 10px auto;
                background-color: #ECEFF1; 
                border: 1px rgb(240,240,240) solid;
            }
            header {
                background-color: #2196F3;
                padding: 30px 0;
                color: white;
            }
            header h1 {
                text-align: center;
                font-weight: 100;
            }
            table.table {
                border-collapse: collapse;
                width: 100%;
            }
            table.table td, table.table th {
                padding: 5px;
                text-align: left;
            }
            table.table th {
                font-weight: bold;
            }
            #message {
                padding: 10px;
            }
            p {
                text-align: justify;
            }
        </style>
    </head>
    <body>
        <main id="page">
            <header>
            <h1>{{config('app.name')}}</h1>
            </header>
            <div id="message">
            @yield("content")
            </div> 
        </main>
    </body>
</html> 