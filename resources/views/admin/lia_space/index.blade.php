@extends('adminlte::page')

@section('title', 'Kits')

@section('content_header')
    <h1>Espaço LIA</h1>
@stop

@section('content')
    <br>
    <div class="row">
        <div class="col-12 col-sm-5">
            <img id="img" src="../images/lia_space/Lia.jpg" alt="" usemap="#lia_space" width="100%">
            <map name="lia_space" id="map">
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
        <div class="col-12 col-sm-7">
            <div id="space-info"  style="display: none;">
                <div class="row">
                    <div class="col-6">
                        <h4 id="space_title"></h4>
                    </div>
                    <div class="col-6">
                        <div class="float-sm-right">
                            <button class="btn btn-primary" onclick="editSpace()">Editar espaço</button>
                            <button class="btn btn-danger" onclick="deleteSpace(event)">Apagar espaço</button>
                        </div>
                    </div>
                </div>
                <br>
                <ul class="list-group">
                    <li class="list-group-item">
                        <label for="description">Descriçao:</label>
                        <p id="description"></p>
                    </li>
                    <li class="list-group-item">
                        <label for="lia_code">Código LIA:</label>
                        <p id="lia_code"></p>
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
            <div id="space-buttons" style="display: none;">
                <h4>Nenhuma informação encontrada para este espaço</h4>
                <br>
                <button onclick="createSpace()" class="btn btn-primary" >Criar Espaço</button>
            </div>
        </div>  
    </div>

    <script>
        var spaceID;
        var imgWidth;

        function showModal(id){
            spaceID = id;
            $.ajax({
                url: "/admin/lia-space",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    spaceID: id,
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                },
                success: function(data){
                    if(data.space == null){
                        $('#space-buttons').show();
                        $('#space-info').hide();
                    } else {
                        $('#space-buttons').hide();
                        $('#space-info').show();
                        $('#space_title').text('Espaço' + data.space.space_code)
                        $('#description').text(data.space.description)
                        $('#lia_code').text(data.space.lia_code)
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

        function createSpace(){
            window.location.replace('/admin/lia-space/create/' + spaceID)
        }

        function editSpace(){
            window.location.replace('/admin/lia-space/' + spaceID + '/edit');
        }

        function deleteSpace(){
            Swal.fire({
                title: 'Apagar espaço ' + spaceID + '?',
                showCancelButton: true,
                confirmButtonText: 'Apagar'
            }).then((result) => {
                if(result.value)  {
                    $.ajax({
                        url: '/admin/lia-space/' + spaceID,
                        type: 'DELETE',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            "_method": 'DELETE'
                        },
                        success: function(){
                        const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Espaço apagado'
                            });

                            $('#space-buttons').hide();
                            $('#space-info').hide();
                        }
                    });
                }
            });
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
    </script>
@endsection