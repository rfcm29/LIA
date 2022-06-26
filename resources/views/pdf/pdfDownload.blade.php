
        <div class="container">
            <h3>
                Requisição de Material - Laboratório de Interação e Audiovisuais
                (L 3.6)
            </h3>

            <br />
            <br />
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Nome</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                            value="{{$user->name}}"
                        />
                    </div>
                </div>
                <br />
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Contacto Telefonico</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                            value="{{$user->numero_tela}}"
                        />
                    </div>
                </div>
                <br />
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Email</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                            value="{{$user->email}}"
                        />
                    </div>
                </div>
                <br />
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Numero Mecanografico</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                            value="{{$user->numero_meca}}"
                        />
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Nome</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                        />
                    </div>
                </div>
                <br />
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Contacto Telefonico</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                        />
                    </div>
                </div>
                <br />
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Email</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                        />
                    </div>
                </div>
                <br />
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Numero Mecanografico</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                        />
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Nome</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                        />
                    </div>
                </div>
                <br />
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Contacto Telefonico</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                        />
                    </div>
                </div>
                <br />
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Email</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                        />
                    </div>
                </div>
                <br />
                <div class="col-md-4">
                    <div class="input-group input-group-lg">
                        <label>Numero Mecanografico</label>
                        <input
                            type="text"
                            class="form-control"
                            aria-describedby="sizing-addon1"
                        />
                    </div>
                </div>
            </div>
            <br />
            <br />
            <label>Motivo da Reserva</label>
            <textarea
                type="text"
                class="form-control"
                rows="3"
                aria-describedby="sizing-addon1"
                
            >{{$reserva->razao_pedido}}</textarea>
            <br />
            <br />
            <label>Curso e Disciplina Envolvida</label>
            <textarea
                type="text"
                class="form-control"
                rows="3"
                aria-describedby="sizing-addon1"
                
            >{{$reserva->curso_disciplina}}</textarea>




            <table style="width:100%">
                <tr>
                    <th>Inicio da Reserva</th>
                    <th>Fim da Reserva</th>
                </tr>
                <tr>
                <td>{{$reserva->data_inicio}}</td>
                <td>{{$reserva->data_fim}}</td>
                </tr>
            </table>

            <br />
            <br />
            <table style="width:100%">
                <tr>
                    <th>Nome do Produto</th>
                    
                </tr>
               
                @foreach ($linhas['items'] as $item)
                <tr>
                <td>{{$item[0]->name}}</td>
               
                </tr>
                @endforeach

                @foreach ($linhas['kits'] as $kit)
                <tr>
                   
                    <td>{{$kit[0]->name}}</td>
                    
                </tr>
                @endforeach
                
            </table>

            <h4>
                Após receber o equipamento e ter verificado a sua composição e o
                seu estado de conservação, declaro que tomei conhecimento que:
            </h4>

            <p>
                -O equipamento pertence à Escola Superior de Tecnologia e Gestão
                do Instituto Politécnico de Viana do Castelo e está alocado ao
                Laboratório de Interação e Audiovisuais (L 3.6);
            </p>
            <p>
                - O equipamento apenas poderá ser utilizado como suporte à
                realização de trabalhos no âmbito de aulas/projectos.
            </p>
            <p>
                - Não é permitida a disponibilização do equipamento a terceiros;
            </p>
            <p>
                - A duração da requisição do equipamento é apenas entre o
                período mencionado anteriormente. Findo este período, o
                equipamento deve ser devolvido na data indicada, no mesmo estado
                de conservação em que me foi entregue. Caso tal não aconteça,
                estarei sujeito às penalizações indicadas nos termos da
                avaliação das disciplinas do curso em que me encontro inscrito,
                assim como do regulamento interno da unidade orgânica a que
                pertenço.
            </p>

            <p>_______________________________</p>

            <br>
            
            <label>Requerente __________________________</label>
            <br>
            <br>
            <label>Requerente __________________________</label>
            <br>
            <br>
            <label>Requerente __________________________</label>
            <br>
            <br>
            <label> Responsável pelo Laboratório de Interação e Audiovisuais (L 3.6) __________________________</label>

            <br>
            <label>Data de Levantamento do Pedido:_________________</label>
            <br>
            <br>
            <br>
            <br>
            <label>Data de Entrega:_________________</label>
            <br>
            <label> Responsável pelo Laboratório de Interação e Audiovisuais (L 3.6) __________________________</label>

            <br>
            <br>
            <br>

            <label>Observações:__________________________________________________________________________
                
            </label>
            <p>___________________________________________________________________________________</p>
            <p>___________________________________________________________________________________</p>
            <p>___________________________________________________________________________________</p>

            


            
        </div>
   
