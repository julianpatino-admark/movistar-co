<div id="modal-retencion" class="modal modal-brand modal-retencion fade" tabindex="-1" role="dialog" data-show="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="order: 1">
                <div class="modal-body">
                    <div class="modal-retencion_title">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        <h4>Tenemos asesores especializados que resolverán tus dudas <b>Te llamamos GRATIS</b></h4>
                    </div>
                    <div class="modal-retencion_form">
                        <?php echo $__env->make('partials.components.forms.simple',['id' => 'modal-retencion', 'class' => 'form-underline', 'btnClass' => 'btn-flex btn-accent'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/julianjp/htdocs/movistar/resources/views/partials/layouts/modal/retencion.blade.php ENDPATH**/ ?>