
<div class="container" id="div-main-articulos" style="margin-bottom:25px">

<nav class="navbar navbar-expand-lg bg-prim" style="margin-top:20px;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon text-white"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav" >
            <li class='nav-item'>
                <a class='nav-link text-white navArea' href='#' id='nav-todas'>Todas las areas</a>
            </li>    
             
        </ul>
        <ul class="navbar-nav mr-auto" id="areaNav" >
 
             
        </ul>
    </div>            
</nav>


        <div class='row' style='margin-top: 20px;'>
            <div class='col-md-12'>
                <div class='card text-left bg-prim' id="card-busqueda">
                    <div class='card-body'>
                        <img src='img/busqueda.png' height='70px'  width='70px' alt='' style='display:inline-block'>
                        <div style='display:inline-block'>
                            <h4 class='card-title' id="card-busqueda-titulo">
                            
                            </h4>
                        </div>
                    </div>   
                </div>   
            </div>   
        </div>          


<div class="row" style="margin-top: 20px;">

    <div class="col-md-4 col-sm-12">
        <div class="row" >
            <div class="col-sm-12">
                <div class="card bg-prim">
                    <div class="card-body">
                        <form id="form-busqueda" action="#" method="get">
                            <div class="form-group">
                                <label for="inputBusqueda">Buscar</label>
                                <input type="text" name="inputBusqueda" id="inputBusqueda" class="form-control" placeholder="Buscar" aria-describedby="helpbsq">
                                <small id="helpbsq" class="text-muted"></small>
                            </div>
                            <button type="submit" class="form-control btn bg-second">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-12">
                <div class="card bg-prim">
                    <div class="card-body">
                        Siglo
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-sm-12" >
                                <form id="form-siglo" action='#' method="get">                                       
                                        <div class="form-check">
                                            <input class="form-check-input century-check" type="checkbox" value="20" id="inputSiglo20" name="inputSiglo20">
                                            <label class="form-check-label" for="inputSiglo20">
                                                Siglo 20
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input century-check" type="checkbox" value="21" id="inputSiglo21" name="inputSiglo21" >
                                            <label class="form-check-label" for="inputSiglo21">
                                                Siglo 21
                                            </label>
                                        </div>                                      
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-12">
                <div class="card bg-prim">
                    <div class="card-body">
                        Decada
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-sm-12" >
                                <form id="form-decada" action="#" method="get">
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="0" name="inputDecada0" id="inputDecada0">
                                        <label class="form-check-label" for="inputDecada0">
                                            00's
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="1" name="inputDecada1" id="inputDecada1" >
                                        <label class="form-check-label" for="inputDecada1">
                                            10´s
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="2" name="inputDecada2" id="inputDecada2">
                                        <label class="form-check-label" for="inputDecada2">
                                            20's
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="3" name="inputDecada3" id="inputDecada3" >
                                        <label class="form-check-label" for="inputDecada3">
                                            30´s
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="4" name="inputDecada4" id="inputDecada4">
                                        <label class="form-check-label" for="inputDecada4">
                                            40's
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="5" name="inputDecada5" id="inputDecada5" >
                                        <label class="form-check-label" for="inputDecada5">
                                            50´s
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="6" name="inputDecada6" id="inputDecada6">
                                        <label class="form-check-label" for="inputDecada6">
                                            60's
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="7" name="inputDecada7" id="inputDecada7" >
                                        <label class="form-check-label" for="inputDecada7">
                                            70´s
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="8" name="inputDecada8" id="inputDecada8">
                                        <label class="form-check-label" for="inputDecada8">
                                            80's
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input decade-check" type="checkbox" value="9" name="inputDecada9" id="inputDecada9" >
                                        <label class="form-check-label" for="inputDecada9">
                                            90´s
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-12">
                <div class="card bg-prim">
                    <div class="card-body" id="div-autores-destacados">
                                                                              
                    </div>
                </div>
            </div>
        </div>   
    </div>       

    <div class="col-md-8 col-sm-12">
        <div id="div-filter-warning">
        </div>
        <div class="overflow-auto" style="height:1000px" id="div-articulos">
            
        </div>
       
    </div>

</div>
</div>

<script src="js/articulos/utilidadesArticulo.js" type="text/javascript"></script>



