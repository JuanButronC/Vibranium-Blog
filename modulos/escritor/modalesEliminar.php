<!-- Modal confirmación -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fa fa-exclamation-circle" style="color:red;"></i> Mensaje de
                    confirmación</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>¿Está seguro de que desea eliminar el presente artículo?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal"
                    data-target="#ModalCancelar" style="font-size: 18px;">
                    <i class="fa fa-times-circle mr-2"></i> Cancelar
                </button>

                <div>
                    <form id="formularioEliminar" action="eliminar.php?id=<?php echo $id ?>" method="POST">
                        <div class="form-group" style="display: none;">
                            <input type="number" class="form-control" id="id_articulo" name="id_articulo"
                                value="<?php echo $id ?>">
                        </div>
                        <button id="eliminar" name="eliminar" class="btn btn-success" style="font-size: 18px;"><i
                                class="fa fa-check mr-3"></i> Confirmar</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal cancelar -->
<div class="modal fade" id="ModalCancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="fa fa-exclamation-circle" style="color:red;"></i> Importante</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>¡Eliminación Cancelada!</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal"
                    data-target="#ModalCancelar" style="font-size: 18px;">
                    <i class="fa fa-check-circle mr-2"></i> Aceptar
                </button>
            </div>
        </div>
    </div>
</div>