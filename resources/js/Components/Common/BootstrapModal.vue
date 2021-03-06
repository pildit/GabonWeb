<template>

    <div ref="modal" class="modal fade background-darken" tabindex="-1" role="dialog" :class="{in:isOpen}" @click.self="close()" @keyup.esc="close()">
        <div class="modal-dialog" :class="modalSize" role="document">
            <div class="modal-content">
                <div v-if="needHeader" class="modal-header">
                    <h4 class="modal-title">
                        <slot name="title">
                            {{ translate('modal') }}
                        </slot>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="body">
                        {{ translate('body') }}
                    </slot>
                </div>
                <div v-if="needFooter" class="modal-footer">
                    <slot name="footer">

                    </slot>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</template>

<script>
export default {
    props: {
        opened: {
            type: Function,
            default: () => {}
        },
        closed: {
            type: Function,
            default: () => {}
        },
        needHeader: {
            type: Boolean,
            default: true
        },
        needFooter: {
            type: Boolean,
            default: true
        },
        size: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            sizeClasses: {
                xtralarge: 'modal-xl',
                large: 'modal-lg',
                small: 'modal-sm',
                medium: 'modal-md',
                full: 'modal-full'
            },
            isOpen: false,
            isShow: false,
            lastKnownBodyStyle: {
                overflow: 'auto'
            }
        }
    },
    methods: {
        open() {
            if (this.isShow) {
                return
            }
            this.isShow = true
            this.$nextTick(() => {
                this.isOpen = true
                this.$refs.modal.focus()
                this.lastKnownBodyStyle.overflow = document.body.style.overflow
                document.body.style.overflow = 'hidden'
                $(this.$el).modal('show');
                this.opened()
            })
        },
        close() {
            this.isOpen = false
            this.$nextTick(() => {
                setTimeout(() => {
                    this.isShow = false
                    document.body.style.overflow = this.lastKnownBodyStyle.overflow
                    $(this.$el).modal('hide');
                    this.closed()
                }, 500)
            })
        }
    },
    computed: {
        modalSize: function() {
            return this.sizeClasses[this.size] || ''
        }
    }
}
</script>

<style scoped>
.background-darken {
    background: rgba(0, 0, 0, 0.3);
}

.modal {
    overflow-x: hidden;
    overflow-y: auto;
}

.modal-full {
    margin-left: 16px;
    margin-right: 16px;
    max-width: 100%;
    height: 90%;
}
.modal-full > .modal-content {
    height: 100%;
}
</style>
