<html>
<head>
    <title>Laravel</title>

    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #000000;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
            margin-bottom: 40px;
        }

        .quote {
            font-size: 24px;
        }

        td {
            color: #000 !important;
            font-family: -webkit-pictograph;
        }


    </style>
</head>
<body>

<table class="table table-bordered table-striped">
    <?php
    $overallQ = 0;
    $overallA = 0;
    ?>
    <tr>
        @foreach ($channelList as $channel)
            <th>{{$channel['title']}}</th>
        @endforeach
        <th>Value</th>
        <th>Volume</th>
    </tr>
    <tr>
        @foreach ($channelList as $key=>$channel)
            <?php
            if (isset($sumData[$key]['vol'])) {
                $overallQ = $overallQ + $sumData[$key]['vol'];
            }
            if (isset($sumData[$key]['val'])) {
                $overallA = $overallA + $sumData[$key]['val'];
            }
            ?>
            <td> {{ isset($sumData[$key]['vol'])? $sumData[$key]['vol'] : 0 }}
                | {{ isset($sumData[$key]['val'])? $sumData[$key]['val'] : 0 }}</td>

        @endforeach
        <td>{{$overallQ}}</td>
        <td>{{$overallA}}</td>
    </tr>

</table>

<br>


<table class="table table-bordered table-striped">

    {{--<th>Zone</th>--}}
    {{--<th>Town</th>--}}
    {{--<th>Distributor</th>--}}
    <th>Brand</th>

    @foreach ($channelList as $channel)
        <th>{{$channel['title']}}</th>
    @endforeach

    <?php
    $totalAll = 0;
    $amountTotalAll = 0;
    $channelWise = array();
    ?>

    @foreach ($allData as $keyZone =>$valZone)
        <?php
        $col = sizeof($channelList);
        ?>
        <tr>
            <td colspan="<?php echo $col + 1?>"><h1>{{$zone[$keyZone]}}</h1></td>
        </tr>
        @foreach ($valZone as $keyTown =>$valTown)
            <tr>
                <td colspan="<?php echo $col + 1?>"><h2>{{$town[$keyTown]}}</h2></td>
            </tr>
            @foreach ($valTown as $keyDis =>$valDis)

                <tr>
                    <td colspan="<?php echo $col + 1?>"><h3>{{$distributor[$keyDis]}}</h3></td>
                </tr>

                @foreach ($valDis as $keyBrand =>$valBrand)
                    <tr>
                        <td>{{$brand[$keyBrand]}}</td>
                        @foreach ($channelList as $key=>$channel)
                            <td> {{ isset($valBrand[$key][0]['quantity'])? $valBrand[$key][0]['quantity'] : 0 }}
                                | {{ isset($valBrand[$key][0]['amount'])? $valBrand[$key][0]['amount'] : 0 }}</td>

                        @endforeach

                    </tr>
                @endforeach
            @endforeach
        @endforeach
    @endforeach
</table>
</div>
</body>
</html>
