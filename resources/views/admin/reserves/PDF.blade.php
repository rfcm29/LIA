<div class="container">
    <h3>
        Requisição de Material - Laboratório de Interação e Audiovisuais
        (L 3.6)
    </h3>
    <h4>Técnico responsavél</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="input-group">
                <label>Nome</label>
                <input
                    type="text"
                    class="form-control"
                    aria-describedby="sizing-addon1"
                    value={{Auth::user()->name}}
                />
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <label>Email</label>
                <input
                    type="text"
                    class="form-control"
                    aria-describedby="sizing-addon1"
                    value={{Auth::user()->email}}
                />
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <label>Contacto Telefonico</label>
                <input
                    type="text"
                    class="form-control"
                    aria-describedby="sizing-addon1"
                    value={{Auth::user()->phone}}
                />
            </div>
        </div>
    </div>
    <h4>Requerente</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="input-group">
                <label>Nome</label>
                <input
                    type="text"
                    class="form-control"
                    aria-describedby="sizing-addon1"
                    value="{{$reserve->user->name}}"
                />
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <label>Email</label>
                <input
                    type="text"
                    class="form-control"
                    aria-describedby="sizing-addon1"
                    value="{{$reserve->user->email}}"
                />
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <label>Contacto Telefonico</label>
                <input
                    type="text"
                    class="form-control"
                    aria-describedby="sizing-addon1"
                    value="{{$reserve->user->phone}}"
                />
            </div>
        </div>
    </div>
</div>
<h4>Reserva</h4>
<div class="col-md-4">
    <div class="input-group">
        <label>Motivo da Reserva</label>
        <input
            type="text"
            class="form-control"
            aria-describedby="sizing-addon1"
            value="{{$reserve->description}}"/>
    </div>
</div>
<div class="col-md-4">
    <div class="input-group">
        <label>Curso</label>
        <input
            type="text"
            class="form-control"
            aria-describedby="sizing-addon1"
            value="{{$reserve->costCenter->name}}"/>
    </div>
</div>
<div class="col-md-4">
    <div class="input-group">
        <label>Data de Inicio</label>
        <input
            type="text"
            class="form-control"
            aria-describedby="sizing-addon1"
            value="{{$reserve->start_date}}"/>
    </div>
</div>
<div class="col-md-4">
    <div class="input-group">
        <label>Data de Término</label>
        <input
            type="text"
            class="form-control"
            aria-describedby="sizing-addon1"
            value="{{$reserve->end_date}}"/>
    </div>
</div>
    <div>
        <h4>Kits Reservados</h4>
        <ul>
            @foreach ($reserve->kits as $kit)
                <li>{{ $kit->lia_code }} - {{ $kit->description  }}</li>
                @if (!$kit->kits->isEmpty())
                    @foreach ($kit->kits as $item)
                        <li>{{ $item->lia_code }} - {{ $item->description  }}</li>
                    @endforeach
                @endif
            @endforeach 
        </ul>
    </div>
    <style>
        .page-break {
            page-break-after: always;
        }
        </style>
        <div class="page-break"></div>
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
    <br>
    <div>------------------------------------------------------------------------------------------------------------------------------</div>
    <br>
    <label>Requerente __________________________</label>
    <br>
    <br>
    <label>Responsável pelo Laboratório de Interação e Audiovisuais (L 3.6) __________________________</label>
    <br>
    <br>
    <label>Data de Levantamento do Pedido:_________________</label>
    <br>
    <br>
    <br>
    <label>Requerente __________________________</label>
    <br>
    <br>
    <label>Responsável pelo Laboratório de Interação e Audiovisuais (L 3.6) __________________________</label>
    <br>
    <br>
    <label>Data de Entrega:_________________</label>
    <br>
    <br>
    <br>
    <label>Observações:__________________________________________________________________________
    </label>
    <p>_____________________________________________________________________________________</p>
    <p>_____________________________________________________________________________________</p>
    <p>_____________________________________________________________________________________</p>

    


    
</div>
   
