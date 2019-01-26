<template>
    <div class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <slot name="title">Modal Title</slot>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <slot>
                    <div class="modal-body">
                        Modal Content
                    </div>
                </slot>
            </div>
            <div class="text-center m-1 d-block d-sm-none" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-angle-double-up"></i>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>
