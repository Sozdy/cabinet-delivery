<div class="text-justify">
    <div class="modal" tabindex="-1" role="dialog" id="{{ $id_prefix }}-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-custom text-light">
                    <h5 class="modal-title">@yield('modal-title')</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="#" onsubmit="return false">
                    <div class="modal-body">
                        @yield('modal-body')
                    </div>
                    <div class="modal-footer">
                        @yield('modal-footer')
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
