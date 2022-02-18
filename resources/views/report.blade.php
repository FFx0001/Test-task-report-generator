<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>"Отчет о продажах автомобилей"</title>
</head>
<body>
<p align="center">"Отчет о продажах автомобилей"</p>
<div>
    <p align="left">Город:</p>
    <p align="right">{{$time}}</p>
</div>
<br>
<table>

    <tr>
        <th>"Марка"</th>
        <th> Модель</th>
        <th> VIN  </th>
        <th> Объем двигателя </th>
        <th> Мощность двигателя</th>
        <th> Тип КПП </th>
        <th> Год выпуска </th>
        <th> Дата продажи </th>
        <th> Дилер </th>
    </tr>
    @foreach($sold_cars as $sold_car)
        <tr>
            <td> {{$sold_car->brand}} </td>
            <td> {{$sold_car->model}} </td>
            <td> {{$sold_car->vin}} </td>
            <td> {{$sold_car->engine_capacity}} </td>
            <td> {{$sold_car->engine_power}} </td>
            <td> {{$sold_car->type_of_kpp}} </td>
            <td> {{$sold_car->year_of_release}} </td>
            <td> {{$sold_car->date_of_sale}} </td>
            <td> {{$sold_car->dealer}} </td>
        </tr>
    @endforeach
</table>
</body>
