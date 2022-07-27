@extends('index')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 content-header">
                <h1>Espaço LIA</h1>
            </div>
            <div class="col-2">
                <input type="date" class="form-control" name="start_date" id="start_date">
            </div>
            <div class="col-2">
                <input type="date" class="form-control" name="end_date" id="end_date">
            </div>
            <div class="col-2">
                <button class="btn btn-primary" onclick="checkAvailability()">Ver disponibilidade</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 col-sm-6">
                <img id="img" src="images/lia_space/Lia.jpg" alt="" usemap="#lia_space" width="100%" onresize="myFunction()">
    
                <map id="map" name="lia_space">
                    <!-- espaço 3 -->
                    <area shape="rect" coords="21, 135, 93, 187" href="#" alt="" onclick="showModal(3)">
                    <!-- espaço 2 -->
                    <area shape="rect" coords="21, 246, 93, 297" href="#" alt="" onclick="showModal(2)">
                    <!-- espaço 1 --> 
                    <area shape="rect" coords="21, 355, 93, 406" href="#" alt="" onclick="showModal(1)">
                    <!-- espaço 4 -->
                    <area shape="rect" coords="158, 31, 229, 82" href="#" alt="" onclick="showModal(4)">
                    <!-- espaço 5 -->
                    <area shape="rect" coords="329, 31, 401, 82" href="#" alt="" onclick="showModal(5)">
                    <!-- espaço 6 -->
                    <area shape="rect" coords="468, 153, 538, 206" href="#" alt="" onclick="showModal(6)">
                    <!-- espaço 7 -->
                    <area shape="rect" coords="468, 285, 538, 336" href="#" alt="" onclick="showModal(7)">
                    <!-- espaço 8 -->
                    <area shape="rect" coords="468, 427, 538, 479" href="#" alt="" onclick="showModal(8)">
                </map>
            </div>
            <div class="col-12 col-sm-6">
                <div id="space-info"  style="display: none;">
                    <div class="row">
                        <div class="col-6">
                            <h4 id="space_title"></h4>
                        </div>
                    </div>
                    <br>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <label for="description">Descriçao:</label>
                            <p id="description"></p>
                        </li>
                        <li class="list-group-item">
                            <label for="price">Custo de reserva:</label>
                            <p id="price"></p>
                        </li>
                    </ul>
                    <h3 class="content-header">Itens pertencentes ao espaço</h3>
                    <ul id="itens" class="list-group">
                    </ul>
                </div>
                <div id="inactive-space" style="display: none;">
                    <h4>Espaço inativo!</h4>
                </div>
            </div>
        </div>
    </div>

    <script>
        var currentSpace;
        function showModal(id){
            currentSpace = id;
            $.ajax({
                url: "lia-space",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    spaceID: id
                },
                success: function(data){
                    if(data.space == null){
                        $('#space-info').hide();
                        $('#inactive-space').show();
                    } else {
                        $('#inactive-space').hide();
                        $('#space-info').show();
                        $('#space_title').text('Espaço' + data.space.space_code)
                        $('#description').text(data.space.description)
                        $('#price').text(data.space.cost)
                        $('#itens').empty();
                        data.itens.forEach(item => {
                            var markup = 
                                '<li class="list-group-item">' +   
                                    item.description
                                '</li>' ;
                            $('#itens').append(markup);
                        });
                    }
                }
            })
        }

        function checkAvailability(){
            $.ajax({
                url: "lia-space/availability",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    spaceID: currentSpace,
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                },
                success: function(data){
                    if(data.available == true){
                        Swal.fire({
                        title: 'Espaço disponivel',
                        text: "Pretende reservar?",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Reservar',
                        cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                window.location.replace("/lia-space/reserve?spaceID=" + currentSpace + "&start_date=" + $('#start_date').val() + "&end_date=" + $('#end_date').val());
                            }
                        })
                    } else {
                        Swal.fire({
                        title: 'Espaço indisponivel',
                        text: "Espaço encontra-se ocupado para as datas selecionadas"
                        });
                    }
                },
                error: function(data){
                    console.log(data.reponse);
                }
            })
        }

        window.onload = function () {
            var ImageMap = function (map, img) {
                    var n,
                        areas = map.getElementsByTagName('area'),
                        len = areas.length,
                        coords = [],
                        previousWidth = 561;
                    for (n = 0; n < len; n++) {
                        coords[n] = areas[n].coords.split(',');
                    }
                    this.resize = function () {
                        var n, m, clen,
                            x = img.offsetWidth / previousWidth;
                        for (n = 0; n < len; n++) {
                            clen = coords[n].length;
                            for (m = 0; m < clen; m++) {
                                coords[n][m] *= x;
                            }
                            areas[n].coords = coords[n].join(',');
                        }
                        previousWidth = document.body.clientWidth;
                        return true;
                    };
                    window.onresize = this.resize;
                },
                imageMap = new ImageMap(document.getElementById('map'), document.getElementById('img'));
            imageMap.resize();
            return;
        }

        function myFunction() {
            var ImageMap = function (map, img) {
                    var n,
                        areas = map.getElementsByTagName('area'),
                        len = areas.length,
                        coords = [],
                        previousWidth = 561;
                    for (n = 0; n < len; n++) {
                        coords[n] = areas[n].coords.split(',');
                    }
                    this.resize = function () {
                        var n, m, clen,
                            x = img.offsetWidth / previousWidth;
                        for (n = 0; n < len; n++) {
                            clen = coords[n].length;
                            for (m = 0; m < clen; m++) {
                                coords[n][m] *= x;
                            }
                            areas[n].coords = coords[n].join(',');
                        }
                        previousWidth = document.body.clientWidth;
                        return true;
                    };
                    window.onresize = this.resize;
                },
                imageMap = new ImageMap(document.getElementById('map'), document.getElementById('img'));
            imageMap.resize();
            return;
        }
    </script>
@endsection